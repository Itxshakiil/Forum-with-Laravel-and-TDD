@extends('layouts.app')
@section('title','Login to your account')
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
                                <a href="{{route('profile.show',$thread->creator->name)}}"
                                    class="text-blue-500">{{$thread->creator->name}}
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
                <replies :data="{{$thread->replies }}" @removed="repliesCount--"></replies>
                    {{-- {{$replies->links('pagination.default')}} --}}
                </div>
                {{-- @auth
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
                @endauth --}}
            </div>
            <div class="ml-2 w-full md:w-1/3 bg-white p-5 rounded-lg lg:rounded">
                This thread was published {{$thread->created_at->diffForHumans()}} by {{$thread->creator->name}} and has
                <span v-text="repliesCount "></span> {{ Str::plural('comment',$thread->replies_count)}}.
            </div>
        </div>
    </div>
</thread-view>
@endsection