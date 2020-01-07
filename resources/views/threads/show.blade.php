@extends('layouts.app')
@section('title','Login to your account')
@section('content')
<div class="container mx-auto">
    <div class="flex justify-center px-6 my-12">
        <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
            <a href="/threads" class="text 2xl text-blue-500">All threads</a>
            
            <article class="border p-4 mb-2 rounded">
                <h3 class="p-4 text-2xl text-center">{{$thread->title}}</h3>
                <p class="p-2">{{$thread->body}}</p>
            </article>
            
        </div>
    </div>
</div>
@endsection