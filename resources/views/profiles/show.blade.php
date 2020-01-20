@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <p class="p-4 text-2xl">
        <img src="{{$profileUser->avatar()}}" alt="" width="50" height="50" class="rounded-full inline">
        {{$profileUser->name}} <small>Since {{$profileUser->created_at->diffForHumans()}}</small>
    </p>
    @can('update', $profileUser)

    <form class="px-8 pt-2 mb-4" method="POST" action="/api/users/{{auth()->id()}}/avatar"
        enctype="multipart/form-data">
        <div>
            <input
                class="px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none"
                id="avatar" type="file" name="avatar" required />
        </div>
        <div>
            <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                type="submit">
                Upload
            </button>
        </div>
        @csrf
    </form>
    @endcan
    @foreach ($activities as $date => $activity)
    <h3 class="text-2xl p-2">{{$date}}</h3>
    @foreach ($activity as $record)
    @if (view()->exists("profiles.activities.{$record->type}"))
    @include("profiles.activities.{$record->type}",['activity' => $record])
    @endif
    @endforeach
    @endforeach
</div>
@endsection