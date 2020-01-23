<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show()
    {
        $search = request('q');
        $threads = Thread::search($search)->paginate(25);

        if (request()->wantsJson()) {
            return $threads;
        }
        return view('threads.index', compact('threads'));
    }
}
