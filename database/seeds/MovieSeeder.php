<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MovieSeeder extends Seeder
{
    protected $faker;


    public function __construct()
    {
        $this->faker = Faker::create();
    }


    public function run()
    {

        foreach (range(1, 20) as $i) {
            \App\Movie::create([
                'title' => $this->faker->sentence,
                'genre_id' => $this->faker->numberBetween(1, 20),
                'cover' => 'https://via.placeholder.com/150',
                'description' => $this->faker->text,
                'country_id' => $this->faker->numberBetween(1, Country::count())
            ]);
        }
    }
}
