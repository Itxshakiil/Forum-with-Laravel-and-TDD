@component('profiles.activities.activity')
@slot('heading')
<a class="text-blue-500" href="{{$activity->subject->favorited->path()}}">{{$profileUser->name}} favorited a reply</a>
@endslot
@slot('body')
{{$activity->subject->favorited->body}}
@endslot
@endcomponent