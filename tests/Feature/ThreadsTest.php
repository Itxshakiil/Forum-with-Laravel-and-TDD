<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * A basic test example.
     *
     * @return void
     */
    public function a_user_can_see_threads()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads');

        $response->assertSee($thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_single_thread(){
    
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads/'.$thread->id);
        $response->assertSee($thread->body);
    }
}
