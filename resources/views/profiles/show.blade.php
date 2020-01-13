@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <p class="p-4 text-2xl">{{$profileUser->name}} <small>Since {{$profileUser->created_at->diffForHumans()}}</small>
    </p>
    @foreach ($activities as $date => $activity)
    <h3 class="text-2xl p-2">{{$date}}</h3>
    @foreach ($activity as $record)
    @include("profiles.activities.{$record->type}",['activity' => $record])
    @endforeach
    @endforeach
</div>
@endsection