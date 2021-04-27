<?php

namespace App\Http\Controllers;

use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        //$user = User::findOrFail($user);

        return view('profiles.index', compact('user'));//['user' => $user,]);
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
