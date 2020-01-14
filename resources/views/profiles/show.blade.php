@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <p class="p-4 text-2xl">{{$profileUser->name}} <small>Since {{$profileUser->created_at->diffForHumans()}}</small>
    </p>
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