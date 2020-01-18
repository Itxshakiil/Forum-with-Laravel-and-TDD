<?php

namespace App\Providers;

use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUser
{
    /**
     * Handle the event.
     *
     * @param  ThreadRecievedNewReply  $event
     * @return void
     */
    public function handle(ThreadRecievedNewReply $event)
    {
        User::whereIn('name',$event->reply->mentionedUsers())
        ->get()
        ->each(function ($user) use ($event) {
            $user->notify(new YouWereMentioned($event->reply));
        });
    }
}
