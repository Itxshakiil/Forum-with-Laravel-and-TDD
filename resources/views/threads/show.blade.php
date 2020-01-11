@extends('layouts.app')
@section('title','Login to your account')
@section('content')
<div class="container mx-auto">
    <div class="flex justify-center px-6 my-12">
        <div class="flex flex-col w-full md:w-2/3 bg-white p-5 rounded-lg lg:rounded">
            <div>
                <a href="/threads" class="text 2xl text-blue-500 mb-4 inline-block">All threads</a>
                <a href="/threads/{{$thread->channel->slug}}" class="float-right text-sm py-1 px-2 rounded align-middle text-white bg-blue-500 hover:bg-blue-700 focus:outline-none hover:bg-blue-700 focus:outline-none">{{$thread->channel->slug}}</a>
                <article class="border p-4 mb-2 rounded">
                    <h3 class="p-2">
                    <a href="{{route('profile.show',$thread->creator->name)}}" class="text-blue-500">{{$thread->creator->name}}</a>
                        posted: {{$thread->title}}
                    </h3>
                    <p class="p-2">{{$thread->body}}</p>
                </article>

            </div>
            <div>
                @forelse ($replies as $reply)
                @include('threads.reply')
                {{$replies->links('pagination.default')}}
                @empty
                <p class="p-2">No replies.</p>
                @endforelse
            </div>
            @auth
            <div class="border p-4 mb-2 rounded">
                <form action="{{route('reply.store',['thread'=>$thread->id,'channel'=>$thread->channel->slug])}}"
                    method="post">
                    @csrf
                    <div class="mb-4">
                        <textarea
                            class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('body') border-red-500 @enderror"
                            id="body" type="body" name="body" placeholder="Anything to say?" cols="30"
                            rows="5"></textarea>
                        @error('body')
                        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6 text-center">
                        <button
                            class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                            type="submit">
                            Reply
                        </button>
                    </div>
                </form>
            </div>
            @else
            <p class="p-4">Please <a href="{{route('login')}}" class="text-blue-500">sign in</a> to participate in the
                discussion</p>
            @endauth
        </div>
        <div class="ml-2 w-full md:w-1/3 bg-white p-5 rounded-lg lg:rounded">
            This thread was published {{$thread->created_at->diffForHumans()}} by {{$thread->creator->name}} and has
            {{$thread->replies_count}} {{ Str::plural('comment',$thread->replies_count)}}.
        </div>
    </div>
</div>
@endsection