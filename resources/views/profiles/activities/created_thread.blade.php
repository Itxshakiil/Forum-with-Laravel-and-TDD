@component('profiles.activities.activity')
@slot('heading')
{{$profileUser->name}} created <a href="{{$activity->subject->path()}}"
    class="text-blue-500">{{$activity->subject->title}}</a>
@endslot
@slot('body')
{{$activity->subject->body}}
@endslot
@endcomponent