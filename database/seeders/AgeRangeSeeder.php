<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgeRange;

class AgeRangeSeeder extends Seeder
{
    public $ranges = [
                        ['name' => 'moins de 17 ans', 'position'     => 1],
                        ['name' => 'de 18 à 24 ans',  'position'     => 2],
                        ['name' => 'de 25 à 34 ans',  'position'     => 3],
                        ['name' => 'de 35 à 44 ans',  'position'     => 4],
                        ['name' => 'de 45 à 54 ans',  'position'     => 5],
                        ['name' => 'de 55 à 64 ans',  'position'     => 6],
                        ['name' => 'de 65 à 74 ans',  'position'     => 7],
                        ['name'  => 'plus de 75 ans', 'position'     => 8],
                        ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->ranges as $range){
            AgeRange::updateOrCreate($range);
        }
    }
}
