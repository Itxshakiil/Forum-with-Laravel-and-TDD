<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_user_has_a_profile()
    {
        $user = factory(User::class)->create();

        $this->get("/profiles/{$user->username}")
        ->assertSee($user->name);
    }

    /**
     * @test
     */
    public function profile_displays_all_threads_created_by_associated_user()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create([
            'user_id' => auth()->id()
        ]);

        $this->get('/profiles/' . auth()->user()->username)
        ->assertSee($thread->title)
        ->assertSee($thread->body);
    }
}
