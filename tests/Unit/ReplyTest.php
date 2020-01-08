<?php

namespace Tests\Unit;

use App\Reply;
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
}
