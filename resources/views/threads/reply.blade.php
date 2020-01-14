<article id="reply-{{$reply->id}}" class="border p-4 mb-2 rounded">
    <div class="flex">
        <p class="text-sm flex-1"><a href="{{route('profile.show',$reply->owner->name)}}"
                class="text-blue-500">{{$reply->owner->name }}</a> said
            {{$reply->created_at->diffForHumans()}} ...</p>
        <form action="{{route('reply.favorite',['reply'=>$reply->id])}}" method="post">
            @csrf
            <button class="px-4 py-2 border rounded focus:outline-none" type="submit"
                {{$reply->isFavorited() ? 'disabled' : ''}}>
                {{$reply->favorites_count}} {{Str::plural('favorite',$reply->favorites_count)}}
            </button>
        </form>
    </div>
    <p class="p-2">{{$reply->body}}</p>
    @can('delete', $reply)
    <div class="p-2">
        <form action="{{route('reply.destroy',['reply' => $reply->id])}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="p-2 text-blue">Delete</button>
        </form>
    </div>
    @endcan

</article>