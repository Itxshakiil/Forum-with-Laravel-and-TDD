<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->create());
    }

    /**
    * @test
    */
    public function a_notification_is_prepared_when_subscribed_threads_recieved_new_reply_that_is_not_by_current_user()
    {
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
        factory(DatabaseNotification::class)->create();

        $this->assertCount(
            1,
            $this->getJson('/profiles/' . auth()->user()->name . '/notifications')->json()
        );
    }

    /**
     * @test
     */
    public function a_user_can_mark_a_notifiction_as_read()
    {
        factory(DatabaseNotification::class)->create();

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $this->delete("/profiles/{$user->username}/notifications/" . $user->unreadNotifications->first()->id);

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
