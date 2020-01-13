<?php

namespace Tests\Feature;

use App\Activity;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivitiesTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function it_records_activity_when_thread_is_created()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create();

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /**
     * @test
     */
    public function it_records_activity_when_reply_is_created()
    {
        $this->actingAs(factory(User::class)->create());

        $reply = factory(Reply::class)->create();

        $this->assertEquals(2, Activity::count());
    }
}
