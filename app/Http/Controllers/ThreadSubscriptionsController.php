<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelIs, Thread $thread)
    {
        $thread->subscribe();
    }

    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
