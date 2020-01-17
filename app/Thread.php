<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];
    protected $with = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     *  A thread belongs to a User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A thread has many Replies
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * A thread belongs to a channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * add a reply to thread
     *
     * @param  mixed $reply
     *
     * @return void
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        $this->notifySubscribers($reply);

        return $reply;
    }

    public function notifySubscribers($reply)
    {
        $this->subscriptions
        ->where('user_id', '!=', $reply->user_id)
        ->each
        ->notify($reply);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?? auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
        ->where('user_id', $userId ?? auth()->id())
        ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);

         return $this->updated_at > cache($key);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
        ->where('user_id', auth()->id())
        ->exists();
    }

    public function scopeFilter($builder, $filters)
    {
        return $filters->apply($builder);
    }
}
