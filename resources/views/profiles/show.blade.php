@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <p class="p-4 text-2xl">{{$profileUser->name}} <small>Since {{$profileUser->created_at->diffForHumans()}}</small></p>
    @foreach ($threads as $thread)
    <article class="border p-4 mb-2 rounded">
        <h3 class="p-2">
            <a href="#" class="text-blue-500">{{$thread->creator->name}}</a>
            posted {{$thread->title}}
        </h3>
        <p class="p-2">{{$thread->body}}</p>
    </article>
    @endforeach
    {{$threads->links('pagination.default')}}
</div>
@endsection