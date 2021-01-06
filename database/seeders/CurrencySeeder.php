<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = [
            'ref'       => Str::random(20),
            'name'      => 'Credit',
            'icons'     => 'fas fa-coins',
            'status'    =>  1,
            'created_by' => 3
        ];

        $create = Currency::updateOrCreate($currency);
    }
}
