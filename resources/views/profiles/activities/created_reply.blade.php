@component('profiles.activities.activity')
@slot('heading')
{{$profileUser->name}} replied to <a href="{{$activity->subject->thread->path()}}"
    class="text-blue-500">{{$activity->subject->thread->title}}</a>
@endslot
@slot('body')
{{$activity->subject->body}}
@endslot
@endcomponent