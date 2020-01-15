<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_user_can_subscribe_to_threads()
    {
        $this->actingAs(factory(User::class)->create());
        $thread = factory(Thread::class)->create();

        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Random Reply...',
        ]);

        // $this->assertCount(1,auth()->user()->notifications );
        // $this->assertCount(1,$thread->subscriptions);
    }

    /**
     * @test
     */
    public function a_user_can_unsubscribed_from_threads()
    {
        $this->actingAs(factory(User::class)->create());
        $thread = factory(Thread::class)->create();

        $thread->subscribe();

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->subscriptions);
    }
}
