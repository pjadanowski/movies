<?php

use App\Country;
use App\Movie;
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
        $countries_count = Country::count();

        foreach (range(1, 20) as $i) {
            Movie::create([
                'title' => $this->faker->sentence,
                'cover' => 'https://via.placeholder.com/150',
                'description' => $this->faker->text,
                'country_id' => $this->faker->numberBetween(1, $countries_count)
            ]);
        }
    }
}
