<?php

namespace Tests\Feature;

use App\Activity;
use App\Reply;
use App\Thread;
use App\User;
use Carbon\Carbon;
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

    /**
    * @test
    */
    public function it_fetches_a_feed_for_the_user()
    {
        $this->actingAs(factory(User::class)->create());

        factory(Thread::class, 2)->create([
            'user_id' => auth()->id()
        ]);

        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()->format('Y-m-d')]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
