<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_user_can_search_thread()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';

        factory(Thread::class, 2)->create();
        
        factory(Thread::class, 2)->create(['body' => "It contains {$search} term"]);

        do {
            sleep(.25);
            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}
