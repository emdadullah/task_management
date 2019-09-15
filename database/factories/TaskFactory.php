<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {    
    return [
        'parent_id' => $faker->numberBetween(1,15),
        'user_id' => $faker->numberBetween(1,5),
        'title' =>  $faker->sentence($nbWords = 6, $variableNbWords = true),
        'points' => $faker->numberBetween(1,5),
        'is_done' => $faker->numberBetween(0,1)
    ];
});
