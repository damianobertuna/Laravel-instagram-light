@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-3 p-5">
            <img alt="bionutrimednutrizione's profile picture" class="rounded-circle"  src="https://instagram.fpmo1-1.fna.fbcdn.net/v/t51.2885-19/s150x150/161378937_1162081890891723_8781743102445000298_n.jpg?tp=1&amp;_nc_ht=instagram.fpmo1-1.fna.fbcdn.net&amp;_nc_ohc=WE32T2l57CoAX-58wTW&amp;edm=ABfd0MgAAAAA&amp;ccb=7-4&amp;oh=6377af6ade15299a21e6b52e0734b2c9&amp;oe=60A848D7&amp;_nc_sid=7bff83">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1 class="h2">Bionutrimed Nutrizione - {{ $user->username }}</h1>
                <a href="/p/create">Add new post</a>
            </div>
            @can('update', $user->profile)
            <a href="/profile/{{ $user->id }}/edit">Edit profile</a>
            @endcan
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $user->posts->count() }}</strong> posts</div>
                <div class="pr-5"><strong>23k</strong> followers</div>
                <div class="pr-5"><strong>212</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">Bionutrimed.it - {{ $user->profile->title }}</div>
            <div class="pt-4">
                {{ $user->profile->description }}
            </div>
            <div><a href="{{ $user->profile->url }}">{{ $user->profile->url ?? "N/A" }}</a></div>
        </div>
    </div>

    <div class="row pt-4">
        @foreach($user->posts as $post)
        <div class="col-4 pb-4">
            <a href="/p/{{ $post->id }}">
                <img class="w-100" src="/storage/{{ $post->image }}">
            </a>
        </div>
        @endforeach
    </div>



</div>
@endsection
