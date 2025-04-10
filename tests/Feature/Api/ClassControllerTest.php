<?php

namespace Feature\Api;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\ClassResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_show_single_class(): void
    {
        $classId = 'ABC123456789';

        $responseData = [
            'data' => [
                'id' => $classId,
                'name' => 'Super cool class',
                'students' => [
                    'data' => [
                        [
                            'id' => 'BCF677889966',
                            'forename' => 'Joe',
                            'surname' => 'Walsh',
                        ],
                        [
                            'id' => 'BCF677889966',
                            'forename' => 'Don',
                            'surname' => 'Henly',
                        ],
                        [
                            'id' => 'BCF677889966',
                            'forename' => 'John',
                            'surname' => 'Mayer',
                        ],
                    ]
                ]
            ]
        ];

        Http::fake([
                '*/classes/' . $classId . '*' => Http::response($responseData)
        ]);

        $response = $this->json(
            'GET',
            route('api.classes.show', ['classId' => $classId])
        )->assertStatus(200);

        $this->assertSame($responseData['data'], (new ClassResource($response->decodeResponseJson()['data']))->resource);
    }


    public function test_it_will_return_error_if_error(): void
    {
        $classId = 'ABC123456789';

        Http::fake([
            '*/classes/' . $classId . '*' => Http::response('Could not find class', 500)
        ]);

        $response = $this->json(
            'GET',
            route('api.classes.show', ['classId' => $classId])
        )->assertStatus(500);

        $this->assertTrue(Str::contains($response->decodeResponseJson()->json, 'Could not find class'));
    }
}
