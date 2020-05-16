<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($file = fopen("database/countries.txt", "r")) {
            while (!feof($file)) {
                $line = fgets($file);

                if (strlen($line) > 1) {

                    $pieces = explode("\t", $line);

                    $code = trim($pieces[0]);
                    $name = trim($pieces[1]);
                    Country::create([
                        'code' => $code,
                        'name' => $name,
                    ]);
                }
            }
            fclose($file);
        }
    }
}
