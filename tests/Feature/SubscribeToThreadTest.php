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

        $this->assertCount(1, $thread->fresh()->subscriptions);
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
