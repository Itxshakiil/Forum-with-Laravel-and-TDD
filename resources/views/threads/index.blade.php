@extends('layouts.app')
@section('title','All Threads')
@section('content')
<div class="container mx-auto">
    <div class="flex justify-center px-6 my-12">
        <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
            <h3 class="p-4 text-2xl text-center">Threads!</h3>
            @include('threads._list')

            {{$threads->links('pagination.default')}}
        </div>
    </div>
</div>
@endsection