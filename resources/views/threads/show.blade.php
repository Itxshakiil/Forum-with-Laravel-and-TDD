@extends('layouts.app')
@section('title','Login to your account')
@section('extra-css')
<link href="{{ asset('css/vendor/jquery.atwho.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<thread-view :initial-replies-count="{{$thread->replies_count}}" inline-template>
    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">
            <div class="flex flex-col w-full md:w-2/3 bg-white p-5 rounded-lg lg:rounded">
                <div>
                    <a href="/threads" class="text 2xl text-blue-500 mb-4 inline-block">All threads</a>
                    <a href="/threads/{{$thread->channel->slug}}"
                        class="float-right text-sm py-1 px-2 rounded align-middle text-white bg-blue-500 hover:bg-blue-700 focus:outline-none hover:bg-blue-700 focus:outline-none">{{$thread->channel->slug}}</a>
                    <article class="border p-4 mb-2 rounded">
                        <div class="flex">
                            <h3 class="p-2 flex-1">
                                <a href="{{route('profile.show',$thread->creator->name)}}" class="text-blue-500">
                                    <img src="{{$thread->creator->avatar()}}" alt="" width="25" height="25"
                                        class="inline rounded-full">
                                    {{$thread->creator->name}}
                                </a>
                                posted: {{$thread->title}}
                            </h3>
                            @can('delete', $thread)
                            <form action="{{$thread->path()}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="p-2 text-blue" type="submit">Delete Thread</button>
                            </form>
                            @endcan
                        </div>
                        <p class="p-2">{{$thread->body}}</p>
                    </article>

                </div>
                <div>
                    <replies @removed="repliesCount--" @added="repliesCount++"></replies>
                </div>
            </div>
            <div class="ml-2 w-full md:w-1/3 bg-white p-5 rounded-lg lg:rounded">
                This thread was published {{$thread->created_at->diffForHumans()}} by {{$thread->creator->name}} and has
                <span v-text="repliesCount "></span> {{ Str::plural('comment',$thread->replies_count)}}.
                <subscribe-button :active="{{json_encode($thread->isSubscribedTo)}}"></subscribe-button>
            </div>
        </div>
    </div>
</thread-view>
@endsection