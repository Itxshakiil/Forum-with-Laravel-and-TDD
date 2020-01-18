<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentionUserTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function mentioned_user_get_notified()
    {
        $john = factory(User::class)->create(['name' => 'JohnDoe']);

        $this->actingAs($john);

        $jane = factory(User::class)->create(['name' => 'JaneDoe']);

        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class)->make(['body' => '@JaneDoe please look at this. @frandoe']);

        $this->json('post', "{$thread->path()}/replies", $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}
