<article class="border p-4 mb-2 rounded" v-if="editing">
    <input
        class="w-full px-3 py-2 m-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror"
        id="email" type="text" placeholder="title" name="title" required autocomplete="title" autofocus
        v-model="form.title" />
    <textarea
        class="w-full px-3 py-2 m-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
        id="body" type="body" name="body" cols="30" rows="5" required v-model="form.body"></textarea>
    <div class="flex justify-between p-2">
        <div>
            <button class="px-2 py-1 mt-2 border rounded" @click="update">Update</button>
            <button class="px-2 py-1 mt-2 border rounded" @click="resetForm">Cancel</button>
        </div>
        @can('delete', $thread)
        <form action="{{$thread->path()}}" method="post">
            @csrf
            @method('delete')
            <button class="px-2 py-1 mt-2 border rounded bg-red-200 text-red-900" type="submit">Delete Thread</button>
        </form>
        @endcan
    </div>
</article>

<article class="border p-4 mb-2 rounded" v-else>
    <div class="flex">
        <h3 class="p-2 flex-1">
            <a href="{{route('profile.show',$thread->creator->username)}}" class="text-blue-500">
                <img src="{{$thread->creator->avatar_path}}" alt="" width="25" height="25" class="inline rounded-full">
                {{$thread->creator->username}}
            </a>
            posted: <span v-text="title"></span>
        </h3>
    </div>
    <p class="p-2" v-text="body">{{$thread->body}}</p>
    <button class="px-2 py-1 mt-2 border rounded" @click="editing =true" v-if="authorize('owns',thread)">Edit</button>
</article>