<?php

namespace Tests\Unit;

use App\Reply;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->reply = factory(Reply::class)->create();
    }

    /**
      * @test
      */
    public function a_user_has_an_owner()
    {
        $this->assertInstanceOf('App\User', $this->reply->owner, 'No Owner Found');
    }

    /**
    * @test
    */
    public function it_knows_if_it_was_just_published()
    {
        $reply = factory(Reply::class)->create();

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /**
    * @test
    */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = factory(Reply::class)->create(['body' => '@JohnDoe talk to @JaneDoe']);

        $this->assertEquals(['JohnDoe', 'JaneDoe'], $reply->mentionedUsers()) ;
    }

    /**
     * @test
    */
    public function it_wraps_mentioned_usernames_within_anchor_tags()
    {
        $reply = factory(Reply::class)->create(['body' => 'Hello @JaneDoe.']);

        $this->assertEquals(
            'Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.',
            $reply->body
        );
    }

    /**
    * @test
    */
    public function it_knows_if_it_is_the_best_reply()
    {
        $reply = factory(Reply::class)->create();

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->isBest());
    }
}
