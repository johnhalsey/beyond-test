<?php

namespace Tests\Feature;

use Tests\TestCase;
use Inertia\Testing\AssertableInertia;

class ErrorControllerTest extends TestCase
{
    public function test_guest_will_get_error_page()
    {
        $this->call('GET', '/error')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Error')
            );
    }
}
