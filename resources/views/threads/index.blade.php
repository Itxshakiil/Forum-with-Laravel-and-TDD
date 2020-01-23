@extends('layouts.app')
@section('title','All Threads')
@section('content')
<div class="container mx-auto">
    <div class="flex justify-center px-6 my-12">
        <div class="w-full md:w-9/12 bg-white p-5 rounded-lg lg:rounded-l-none">
            <h3 class="p-4 text-2xl text-center">Threads!</h3>
            @include('threads._list')

            {{$threads->links('pagination.default')}}
        </div>
        <div class="w-full md:w-3/12 bg-white p-2 rounded-lg lg:rounded-l-none ml-2">
            <h3 class="p-4 text-2xl text-center">Search!</h3>
            
            <form class="px-8 pt-6 mb-4 bg-white rounded" method="GET" action="{{ route('search') }}">
                <div class="mb-4">
                    <input
                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror"
                        id="q" type="search" placeholder="Search Threads..." name="q" value="{{ old('q') }}" required
                        autocomplete="q" />
                </div>
                <div class="mb-6 text-center">
                    <button
                        class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        Search
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection