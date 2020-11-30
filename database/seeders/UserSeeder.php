<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'password' => Hash::make('passer')
        ];
        $adminData = [
            'name' => 'Admin',
            'email' => 'admin@lagenda.quebec',
            'email_verified_at' => Carbon::now(),
        'password' => Hash::make('passer')
        ];
        $client = [
            'name' => 'Client',
            'email' => 'client@lagenda.quebec',
            'email_verified_at' => Carbon::now(),
        'password' => Hash::make('passer')
        ];


        $superAdmin = User::create($superAdminData);
        $role = Role::create(['name' => 'super-admin']);
        $permission = Permission::create(['name' => 'all']);
        $role->givePermissionTo($permission);
        $superAdmin->assignRole($role);

        $admin = User::create($adminData);
        $role = Role::create(['name' => 'admin']);
        $admin->assignRole($role);

        $admin = User::create($client);
        $role = Role::create(['name' => 'client']);
        $admin->assignRole("user");

    }
}
