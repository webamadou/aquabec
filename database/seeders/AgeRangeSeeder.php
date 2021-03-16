<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgeRange;

class AgeRangeSeeder extends Seeder
{
    public $ranges = [
                        ['name' => '-18', 'position'     => 1],
                        ['name' => '18-30',  'position'     => 2],
                        ['name' => '30-60',  'position'     => 3],
                        ['name' => '60+',  'position'     => 4],
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
