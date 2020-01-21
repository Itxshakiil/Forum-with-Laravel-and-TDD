@foreach ($threads as $thread)
<article class="border p-4 mb-2 rounded">
    <div class="flex justify-between">
        <div class="flex flex-col">
            <a href="{{$thread->path()}}" class="flex-1 text-2xl text-blue-500">
                @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                <span class="font-semibold">{{$thread->title}}</span>
                @else
                {{$thread->title}}
                @endif
            </a>
            <h4 class="text-sm">Posted By:
                <a href="{{route('profile.show',$thread->creator->name)}}"
                    class="text-blue-500">{{$thread->creator->name}}
                </a>
            </h4>
        </div>
        <p class="font-semibold">{{$thread->replies_count}} {{Str::plural('reply',$thread->replies_count)}}
        </p>
    </div>
    <p class="p-2">{{$thread->body}}</p>
    <hr>
    <p>{{$thread->visits}} Visits</p>
</article>
@endforeach