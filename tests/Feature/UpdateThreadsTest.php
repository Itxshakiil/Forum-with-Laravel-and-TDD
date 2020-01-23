<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->actingAs(factory(User::class)->create(['email_verified_at' => now()]));
    }
    
    /**
    * @test
    */
    public function unauthorized_user_may_not_update_threads()
    {
        $thread = factory(Thread::class)->create(['user_id' => factory(User::class)->create(['email_verified_at' => now()])]);

        $this->patch(
            $thread->path(),
            ['title' => 'Changed', 'body' => 'Changed body']
        )->assertStatus(403);
    }

    /**
    * @test
    */
    public function a_thread_rquires_a_title_and_body_to_updated()
    {
        $thread = factory(Thread::class)->create(['user_id' => auth()->id()]);

        $this->patch(
            $thread->path(),
            ['title' => 'Changed']
        )->assertSessionHasErrors('body');

        $this->patch(
            $thread->path(),
            ['body' => 'Changed']
        )->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function authorized_user_can_update_thread()
    {
        $thread = factory(Thread::class)->create(['user_id' => auth()->id()]);

        $this->patchJson(
            $thread->path(),
            ['title' => 'Changed', 'body' => 'Changed body']
        );

        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('Changed body', $thread->body);
            $this->assertEquals('Changed', $thread->title);
        });
    }
}
