<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
    * @test
    */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get(route('threads.create'))
        ->assertRedirect('/login');

        $this->post('/threads')
        ->assertRedirect('/login');
        ;
    }

    /**
    * @test
    */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->actingAs(factory(User::class)->create());
        
        $thread = factory(Thread::class)->make();
        
        $response =$this->post('/threads', $thread->toArray());
        
        $this->get($response->headers->get('Location'))
        ->assertSee($thread->title)
        ->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function a_thread_requires_a_title()
    {
        $this->publishThreads(['title' => null])
        ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_thread_requires_a_body()
    {
        $this->publishThreads(['body' => null])
        ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function a_thread_requires_a_valid_channel()
    {
        factory(Channel::class,2)->create();
        $this->publishThreads(['channel_id' => null])
        ->assertSessionHasErrors('channel_id');
    
        $this->publishThreads(['channel_id' => 999])
        ->assertSessionHasErrors('channel_id');
    }


    public function publishThreads($overrirdes =[])
    {
        $this->withExceptionHandling()->actingAs(factory(User::class)->create());
        
        $thread = factory(Thread::class,$overrirdes)->make();

        return $this->post('/threads',$thread->toArray());
    }
}
