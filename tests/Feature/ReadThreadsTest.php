<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
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
        $this->get($this->thread->path())
            ->assertSee($this->thread->body);
    }

    /**
     * @test
     */
    public function a_user_can_read_reply_associated_with_a_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
    }

    /**
    * @test
    */
    public function a_user_has_an_owner()
    {
        $reply = factory('App\Reply')->create();

        $this->assertInstanceOf('App\User', $reply->owner, 'No Owner Found');
    }

    /**
    * @test
    */
    public function a_user_can_filter_threads_according_to_tag()
    {
        $channel = factory(Channel::class)->create();
        $threadInChannel = factory(Thread::class, ['channel_id' => $channel->id])->create();
        $threadNotInThread = factory(Thread::class)->create();

        $this->get("/threads/{$channel->slug}")
        ->assertDontSee($threadNotInThread->title);

        /* Because $threadNotInChannel is Collection */
        foreach ($threadInChannel as $channels) {
            $this->get("/threads/{$channel->slug}")
            ->assertDontSee($channels->title);
        }
    }

    /**
    * @test
    */
    public function a_user_can_filter_thredas_by_popularity()
    {
        $threadWithNoReply = $this->thread;

        $threadWithOneReply = factory(Thread::class)->create();
        factory(Reply::class)->create([
            'thread_id' => $threadWithOneReply->id
        ]);

        $threadWithThreeeReply = factory(Thread::class)->create();
        factory(Reply::class, 3)->create([
            'thread_id' => $threadWithThreeeReply->id
        ]);

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3, 1, 0], array_column($response, 'replies_count'));
    }

    /**
     * @test
     */
    public function a_user_can_filter_by_those_that_are_unanswered()
    {
        $thread = factory(Thread::class)->create();
        factory(Reply::class)->create(['thread_id' => $thread->id]);

        $response = $this->getJson('/threads?unanswer=1')->json();

        $this->assertCount(1, $response);
    }

    /**
    * @test
    */
    public function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = factory(Thread::class)->create();

        factory(Reply::class, 2)->create(['thread_id' => $thread->id]);

        $response = $this->get($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
}
