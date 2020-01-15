<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswer'];

    /**
     * Filter by User's name
     *
     * @param  mixed $username
     *
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Return Threads by popularity
     *
     * @param  mixed $username
     *
     * @return mixed
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * Return Threads those are unaswered
     *
     * @param  mixed $username
     *
     * @return mixed
     */
    protected function unanswer()
    {
        return $this->builder->where('replies_count', 0);
    }
}
