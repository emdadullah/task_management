<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 5; $i++) { 
            DB::table('tasks')->insert([ //,
                'parent_id' => null,
                'user_id' => $faker->numberBetween(1,5),
                'title' =>  $faker->sentence($nbWords = 6, $variableNbWords = true),
                'points' => $faker->numberBetween(1,5),
                'is_done' => $faker->numberBetween(0,1)
            ]);
        }      

        factory('App\Models\Task', 100)->create();
    }
}
