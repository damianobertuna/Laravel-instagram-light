<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
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
        auth()->user()->profile->update($data);

        return redirect('/profile/'.$user->id);

    }

}
