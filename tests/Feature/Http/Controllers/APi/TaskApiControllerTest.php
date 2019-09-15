<?php

namespace Tests\Feature\Http\Controllers\APi;

use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskApiControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_a_task()
    {
        $faker = Faker::create();

        $response = $this->json('POST', 'api/task', [
            'parent_id' => $parentId = null,
            'user_id' => $userId = $faker->numberBetween(1,5),
            'title' =>  $title = $faker->sentence($nbWords = 6, $variableNbWords = true),
            'points' => $points = $faker->numberBetween(1,5),
            'is_done' => $isDone = $faker->numberBetween(0,1)
        ]);

        $response->assertJsonStructure([
            'id', 'parent_id', 'title', 'points', 'is_done', 'created_at'
        ])
        ->assertJson([
            'parent_id' => $parentId,
            'user_id' => $userId,
            'title' =>  $title,
            'points' => $points,
            'is_done' => $isDone
        ])
        ->assertStatus(201);

        $this->assertDatabasehas('tasks',[
            'parent_id' => $parentId,
            'user_id' => $userId,
            'title' =>  $title,
            'points' => $points,
            'is_done' => $isDone
        ]);
    }
}
