@forelse ($threads as $thread)
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
                <a href="{{route('profile.show',$thread->creator->username)}}"
                    class="text-blue-500">{{$thread->creator->username}}
                </a>
            </h4>
        </div>
        <p class="font-semibold">{{$thread->replies_count}} {{Str::plural('reply',$thread->replies_count)}}
        </p>
    </div>
    <p class="p-2">{{$thread->body}}</p>
    <hr>
    <p>
        <svg class="inline m-1" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true">
            <path fill-rule="evenodd"
                d="M8.06 2C3 2 0 8 0 8s3 6 8.06 6C13 14 16 8 16 8s-3-6-7.94-6zM8 12c-2.2 0-4-1.78-4-4 0-2.2 1.8-4 4-4 2.22 0 4 1.8 4 4 0 2.22-1.78 4-4 4zm2-4c0 1.11-.89 2-2 2-1.11 0-2-.89-2-2 0-1.11.89-2 2-2 1.11 0 2 .89 2 2z">
            </path>
        </svg><span>{{$thread->visits}}</span>
    </p>
</article>
@empty
<p class="p-2">No Threads Found</p>
@endforelse