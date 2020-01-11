<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteReplyTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function guest_can_not_favorite_any_reply()
    {
        $this->withExceptionHandling();

        $this->post('/replies/1/favorites')
        ->assertRedirect('login');
    }

    /**
    * @test
    */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->actingAs(factory(User::class)->create());

        $reply = factory(Reply::class)->create();

        $this->post("/replies/{$reply->id}/favorites");

        $this->assertCount(1, $reply->favorites);
    }

    /**
    * @test
    */
    public function a_user_can_favorite_a_reply_once()
    {
        $this->actingAs(factory(User::class)->create());

        $reply = factory(Reply::class)->create();
        try {
            $this->post("/replies/{$reply->id}/favorites");
            $this->post("/replies/{$reply->id}/favorites");
        } catch (\Exception $e) {
            $this->fail('Did  not expect to insert same record twice');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
