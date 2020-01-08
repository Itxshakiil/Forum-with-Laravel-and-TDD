<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /**
     * @test
     * A basic test example.
     *
     * @return void
     */
    public function a_user_can_see_threads()
    {
        $this->get('/threads')
        ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_single_thread()
    {
        $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->body);
    }

    /**
     * @test
     */
    public function a_user_can_read_reply_associated_with_a_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);
    }/**
     * @test
     */
    // public function a_user_has_an_owner(){

    //     $reply = factory('App\Reply')->create();

    //     $this->assertInstanceOf('App\User',$reply->owner,'No Owner Found');
    // }
}
