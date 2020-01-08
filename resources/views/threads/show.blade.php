@extends('layouts.app')
@section('title','Login to your account')
@section('content')
<div class="container mx-auto">
    <div class="flex justify-center px-6 my-12">
        <div class="flex flex-col w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
            <div>
                <a href="/threads" class="text 2xl text-blue-500">All threads</a>

                <article class="border p-4 mb-2 rounded">
                    <h3 class="p-2">
                        <a href="#" class="text-blue-500">{{$thread->creator->name}}</a>
                        posted: {{$thread->title}}
                    </h3>
                    <p class="p-2">{{$thread->body}}</p>
                </article>

            </div>
            <div>
                @forelse ($thread->replies as $reply)
                @include('threads.reply')
                @empty
                <p class="p-2">No replies.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection