<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReplyRequest;
use App\Reply;
use App\Thread;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $channelId
     * @param  \App\Reply  $reply
     * @param  \App\Http\Requests\CreateReplyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, CreateReplyRequest $request)
    {
        if (Gate::denies('create', new Reply)) {
            return response('You are posting too frequently.Please take a break :)', 429);
        }
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            request()->validate(['body' => ['required', 'spamfree']]);

            $reply->update(['body' => $request->body]);
        } catch (Exception $e) {
            return response('Sorry, your reply could not be updated.', 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back()->with('flash', 'Reply Deleted Succesfully.');
    }
}
