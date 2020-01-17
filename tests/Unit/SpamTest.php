<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Exception;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /**
    * @test
    */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent Reply'));

        $this->expectException(Exception::class);

        $spam->detect('yahoo customer support');
    }

    /**
    * @test
    */
    public function it_checks_for_any_keys_being_held_down()
    {
        $spam = new Spam();

        $this->expectException(Exception::class);

        $spam->detect('Hello oooooo');
    }
}
