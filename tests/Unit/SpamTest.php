<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
    /** @test */
    public function it_validates_spam()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));
    }
}
