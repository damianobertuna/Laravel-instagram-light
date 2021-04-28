<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        //$user = User::findOrFail($user);
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        /*$postCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
               return $user->posts->count();
            });

        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds("30"),
            function () use ($user) {
                return $user->profile->followers->count();
            });

        $followingCount = Cache::remember(
            "count.following." . $user->id,
            now()->addSeconds('30'),
            function () use ($user) {
                return $user->following->count();
            });*/
        $postCount = $this->cacheData('posts', '30', $user, $user->posts->count());
        $followersCount = $this->cacheData('followers', '30', $user, $user->profile->followers->count());
        $followingCount = $this->cacheData('following', '30', $user, $user->following->count());

        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));//['user' => $user,]);
    }

    public function cacheData($variableToCache, $timeToCache, $user, $countingVariable)
    {
        return Cache::remember(
            "count." . $variableToCache.".". $user->id,
            now()->addSeconds($timeToCache),
            function () use ($countingVariable) {
                return $countingVariable;
            });
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => ''
        ]);

        /*
            RIPASSA - per consentire che solo un utente
            loggato possa fare un update di un profilo
        */

        if (request('image'))
        {
            /* handle the profile image, it's not mandatory to insert it */
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/".$imagePath))->fit(1000, 1000);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));
        return redirect('/profile/'.$user->id);

    }

}
