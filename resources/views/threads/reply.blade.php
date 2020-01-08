<article class="border p-4 mb-2 rounded">
    <p class="text-sm"><a href="#" class="text-blue-500">{{$reply->owner->name }}</a> said
        {{$reply->created_at->diffForHumans()}} ...</p>
    <p class="p-2">{{$reply->body}}</p>
</article>