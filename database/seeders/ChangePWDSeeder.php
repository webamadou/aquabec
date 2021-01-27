<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ChangePWDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::where('email','suadmin@lagenda.quebec')->first();
        $admin      = User::where('email','admin@lagenda.quebec')->first();
        if($superAdmin){
            $superAdmin->password = Hash::make('passer');
            $superAdmin->save();
        }
        if($admin){
            $admin->password = Hash::make('passer');
            $admin->save();
        }

    }
}
