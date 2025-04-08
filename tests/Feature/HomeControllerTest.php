<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia;

class HomeControllerTest extends TestCase
{
    public function test_guest_can_access_home_page()
    {
        Http::fake([
            '*' => Http::response([
                'data' => [],
                'meta' => [
                    'pagination' => [
                        'more' => false,
                    ]
                ],
            ])
        ]);

        $this->call('GET', '/')
            ->assertStatus(200)
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Home')
                ->has('employees')
            );
    }

    public function test_guest_will_get_directed_to_error_on_api_error()
    {
        Http::fake([
            '*' => Http::response(status: 500)
        ]);

        $this->call('GET', '/')
            ->assertRedirect('/error');
    }

    public function test_guest_can_index_employees()
    {
        Http::fakeSequence()
            ->push([
                'data' => [
                    [
                        'id'       => 1,
                        'forename' => 'John',
                        'surname'  => 'Doe',
                        'title'    => 'Mr'
                    ],
                    [
                        'id'       => 2,
                        'forename' => 'Jayne',
                        'surname'  => 'Doe',
                        'title'    => 'Mrs'
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'more' => true,
                    ]
                ],
            ])
            ->push([
                'data' => [
                    [
                        'id'       => 3,
                        'forename' => 'John',
                        'surname'  => 'Smith',
                        'title'    => 'Dr'
                    ],
                    [
                        'id'       => 4,
                        'forename' => 'Jayne',
                        'surname'  => 'smith',
                        'title'    => 'Ms'
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'more' => false,
                    ]
                ],
            ]);

        $this->call('GET', '/')
            ->assertStatus(200)
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Home')
                ->has('employees', 4)
            );
    }
}
