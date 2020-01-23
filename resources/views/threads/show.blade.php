@extends('layouts.app')
@section('title','Login to your account')
@section('extra-css')
<link href="{{ asset('css/vendor/jquery.atwho.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<thread-view :thread="{{$thread}}" inline-template v-cloak>
    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">
            <div class="flex flex-col w-full md:w-2/3 bg-white p-5 rounded-lg lg:rounded">
                <div>
                    <a href="/threads" class="text 2xl text-blue-500 mb-4 inline-block">All threads</a>
                    <a href="/threads/{{$thread->channel->slug}}"
                        class="float-right text-sm py-1 px-2 rounded align-middle text-white bg-blue-500 hover:bg-blue-700 focus:outline-none hover:bg-blue-700 focus:outline-none">{{$thread->channel->slug}}</a>

                    @include('threads._question')

                </div>
                <div>
                    <replies @removed="repliesCount--" @added="repliesCount++"></replies>
                </div>
            </div>
            <div class="ml-2 w-full md:w-1/3 bg-white p-5 rounded-lg lg:rounded">
                This thread was published {{$thread->created_at->diffForHumans()}} by {{$thread->creator->name}} and has
                <span v-text="repliesCount "></span> {{ Str::plural('comment',$thread->replies_count)}}.
                <subscribe-button :active="{{json_encode($thread->isSubscribedTo)}}" v-if="signedIn"></subscribe-button>
                <button class="w-full px-4 py-2 mt-2 font-bold bg-gray-600 text-white rounded-full focus:outline-none"
                    v-if="authorize('isAdmin')" @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock'"></button>
            </div>
        </div>
    </div>
</thread-view>
@endsection