<?php

use Illuminate\Database\Seeder;

class GenreMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movies = \App\Movie::all();
        $genres = \App\Genre::get('id');

        foreach ($movies as $movie) {
            $movie->genres()->attach($genres->random(rand(3,5))->pluck('id'));
        }
    }
}
