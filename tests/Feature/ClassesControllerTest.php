<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ClassesControllerTest extends TestCase
{
    public function test_guest_can_index_classes_for_employee()
    {
        Http::fakeSequence()
            ->push([
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'ART1',
                        'description' => 'ART104',
                        'year_group' => 1,
                        'employees' => [
                            'data' => [
                                [
                                    'id' => 1,
                                ],
                                [
                                    'id' => 2,
                                ],
                                [
                                    'id' => 3,
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => 2,
                        'name' => 'ART2',
                        'description' => 'ART204',
                        'year_group' => 2,
                        'employees' => [
                            'data' => [
                                [
                                    'id' => 2,
                                ],
                                [
                                    'id' => 3,
                                ]
                            ]
                        ]
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
                        'id' => 3,
                        'name' => 'ART1.1',
                        'description' => 'ART101',
                        'year_group' => 2,
                        'employees' => [
                            'data' => [
                                [
                                    'id' => 5,
                                ],
                                [
                                    'id' => 3,
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => 4,
                        'name' => 'ART3',
                        'description' => 'ART301',
                        'year_group' => 4,
                        'employees' => [
                            'data' => [
                                [
                                    'id' => 2,
                                ],
                                [
                                    'id' => 6,
                                ]
                            ]
                        ]
                    ],

                ],
                'meta' => [
                    'pagination' => [
                        'more' => false,
                    ]
                ],
            ]);

        $response = $this->json('GET', 'api/employees/2/classes')
            ->assertStatus(200);

        $data = $response->decodeResponseJson();
        $this->assertCount(3, $data['data']);
    }

    public function test_error_returned_if_error()
    {
        Http::fakeSequence()
            ->push([
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'ART1',
                        'description' => 'ART104',
                        'year_group' => 1,
                        'employees' => [
                            'data' => [
                                [
                                    'id' => 1,
                                ],
                                [
                                    'id' => 2,
                                ],
                                [
                                    'id' => 3,
                                ]
                            ]
                        ]
                    ],
                    [
                        'id' => 2,
                        'name' => 'ART2',
                        'description' => 'ART204',
                        'year_group' => 2,
                        'employees' => [
                            'data' => [
                                [
                                    'id' => 2,
                                ],
                                [
                                    'id' => 3,
                                ]
                            ]
                        ]
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'more' => true,
                    ]
                ],
            ])
            ->push('Error establishing connection', status: 500);

        $response = $this->json('GET', 'api/employees/2/classes')
            ->assertStatus(500);

        $this->assertTrue(Str::contains($response->decodeResponseJson()['error'], 'Error establishing connection'));
    }
}
