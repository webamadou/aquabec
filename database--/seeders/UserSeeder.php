<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminData = [
            'name' => 'Super Admin',
            'email' => 'suadmin@lagenda.quebec',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('@gend5ue$&c')
        ];
        $adminData = [
            'name' => 'Admin',
            'email' => 'admin@lagenda.quebec',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('@gend5ue$&c20')
        ];

        $superAdmin = User::create($superAdminData);
        $superAdmin->assignRole('super-admin');

        $admin = User::create($adminData);
        $admin->assignRole('admin');

    }
}
