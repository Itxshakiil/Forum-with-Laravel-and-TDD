<reply :attributes="{{$reply}}" inline-template v-cloak>
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
        <div v-if="editing">
            <textarea
                class="w-full px-3 py-2 m-1 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none"
                v-model="body"></textarea>
            <button class="p-2 text-blue-900 bg-blue-200 rounded" @click="update">Update</button>
            <button class="p-2 border rounded" @click=" editing = false">Cancel</button>
        </div>
        <div v-else v-text="body" class="p-2">
        </div>
        @can('update', $reply)
        <div class="flex">
            <button class="px-3 py-2 mb-3 mr-2 text-sm leading-tight text-gray-700 border  rounded appearance-none focus:outline-none" @click=" editing = true">Edit</button>
            <button class="px-3 py-2 mb-3 text-sm leading-tight bg-red-300 text-red-700 border  rounded appearance-none focus:outline-none" @click="destroy">Delete</button>
        </div>
        @endcan

    </article>
</reply>