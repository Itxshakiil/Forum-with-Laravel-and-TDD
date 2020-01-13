<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function unauthorized_user_can_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = factory(Thread::class)->create();
        $this->delete($thread->path())->assertRedirect(route('login'));

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->delete($thread->path())->assertStatus(403);
    }

    /**
    * @test
    */
    public function an_authorized_user_can_delete_thier_threads()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $thread = factory(Thread::class)->create([
            'user_id' => auth()->user()->id
        ]);

        $reply = factory(Reply::class)->create([
            'thread_id' => $thread->id
        ]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(200);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);
    }
}
