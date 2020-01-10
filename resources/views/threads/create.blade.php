@extends('layouts.app')
@section('title','Create New Thread')
@section('content')
<div class="container mx-auto">
    <div class="flex justify-center px-6 my-12">
        <div class="flex flex-col w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
            <div class="border p-4 mb-2 rounded">
                <h3 class="pt-4 text-2xl text-center">Create New Thread!</h3>
                <form action="{{route('threads.store')}}" method="post">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="title">
                            Title
                        </label>
                        <input
                            class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('title') border-red-500 @enderror"
                            id="title" type="text" placeholder="title" name="title" value="{{ old('title') }}" required
                            autocomplete="title" autofocus />
                        @error('title')
                        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="channel_id">
                            Choose Channel
                        </label>
                        <select name="channel_id" id="channel_id"
                            class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('channel_id') border-red-500 @enderror" required>
                            <option>Choose a Channel</option>
                            @foreach (App\Channel::all() as $channel)
                            <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' :''}}>
                                {{$channel->name}}
                            </option>
                            @endforeach
                        </select>
                        @error('channel_id')
                        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <textarea
                            class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('body') border-red-500 @enderror"
                            id="body" type="body" name="body" placeholder="Anything to say?" cols="30"
                            rows="5" required></textarea>
                        @error('body')
                        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    @csrf
                    <div class="mb-6 text-center">
                        <button
                            class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                            type="submit">
                            Add Thread
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection