<?php

namespace Tests\Feature\Api;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\LessonResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_index_lessons_for_employee(): void
    {
        $employeeId = 'BCF677889966';

        Carbon::setTestNow(Carbon::parse('2025-04-10'));

        Http::fakeSequence()
            ->push([
                'data' => [
                    [
                        'id'       => 1,
                        'start_at' => Carbon::today()->addDays(3)->addHours(8)->toDateTimeString(),
                        'start_at' => Carbon::today()->addDays(3)->addHours(9)->toDateTimeString(),
                        'employee' => [
                            'data' => [
                                'id' => $employeeId
                            ],
                        ],
                        'employees' => [
                            'data' => []
                        ],
                        'class'    => [
                            'data' => [
                                'id' => 'AB12345',
                                'name' => 'Super cool class',
                            ]
                        ]
                    ],
                    [
                        'id'       => 2,
                        'start_at' => Carbon::today()->addDays(3)->addHours(9)->toDateTimeString(),
                        'start_at' => Carbon::today()->addDays(3)->addHours(10)->toDateTimeString(),
                        'employee' => [
                            'data' => [
                                'id' => 'HGG9887655'
                            ],
                        ],
                        'employees' => [
                            'data' => [
                                [
                                    'id' => $employeeId
                                ]
                            ]
                        ],
                        'class'    => [
                            'data' => [
                                'id' => 'AB12346',
                                'name' => 'Hyper cool class',
                            ]
                        ]
                    ],
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
                        'id'       => 2,
                        'start_at' => Carbon::today()->addDays(3)->addHours(10)->toDateTimeString(),
                        'start_at' => Carbon::today()->addDays(3)->addHours(11)->toDateTimeString(),
                        'employee' => [
                            'data' => [
                                'id' => $employeeId
                            ],
                        ],
                        'employees' => [
                            'data' => []
                        ],
                        'class'    => [
                            'data' => [
                                'id' => 'AB12346',
                                'name' => 'amazing class',
                            ]
                        ]
                    ],
                    [
                        'id'       => 2,
                        'start_at' => Carbon::today()->addDays(3)->addHours(15)->toDateTimeString(),
                        'start_at' => Carbon::today()->addDays(3)->addHours(16)->toDateTimeString(),
                        'employee' => [
                            'data' => [
                                'id' => 'HGG9887655'
                            ],
                        ],
                        'employees' => [
                            'data' => []
                        ],
                        'class'    => [
                            'data' => [
                                'id' => 'AB12346',
                                'name' => 'amazing class',
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

        $response = $this->json(
            'GET',
            route('api.lessons.index', ['employeeId' => $employeeId]),
            [
                'startAfter' => Carbon::today()->addDays(3)->toDateTimeString(),
            ]
        )->assertStatus(200);

        $data = $response->decodeResponseJson()['data'];
        $this->assertCount(3, $data);
        foreach ($data as $lesson) {
            $this->assertSame($lesson, (new LessonResource($lesson))->resource);
        }
    }

    public function test_it_will_return_error_on_error(): void
    {
        $employeeId = 'BCF677889966';

        Http::fake([
            '*' => Http::response('Error retrieving lessons', 500)
        ]);

        $response = $this->json(
            'GET',
            route('api.lessons.index', ['employeeId' => $employeeId]),
            [
                'startAfter' => Carbon::today()->addDays(3)->toString(),
            ]
        )->assertStatus(500);

        $this->assertTrue(Str::contains($response->decodeResponseJson()->json, 'Error retrieving lessons'));
    }
}
