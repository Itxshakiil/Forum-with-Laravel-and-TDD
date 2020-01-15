<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_notification_is_prepared_when_subscribed_threads_recieved_new_reply_that_is_not_by_current_user()
    {
        $this->actingAs(factory(User::class)->create());
        $thread = factory(Thread::class)->create()->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Random Reply...',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body' => 'Random Reply...',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /**
    * @test
    */
    public function a_user_can_fetch_thier_unread_messages()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create()->subscribe();

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body' => 'Random Reply...',
        ]);
        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications")->json();

        $this->assertCount(1, $response);
    }

    /**
     * @test
     */
    public function a_user_can_mark_a_notifiction_as_read()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create()->subscribe();

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body' => 'Random Reply...',
        ]);
        $user = auth()->user();

        $notificationId = $user->unreadNotifications->first()->id;
        $this->assertCount(1, $user->unreadNotifications);

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
