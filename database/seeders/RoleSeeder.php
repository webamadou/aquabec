<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Role::create(['name' => 'super_admin']);
        //Role::create(['name' => 'admin']);
        Role::updateOrCreate(['name' => 'membre']);
        Role::updateOrCreate(['name' => 'chef vendeur']);
        Role::updateOrCreate(['name' => 'vendeur']);

        $permission = Permission::updateOrCreate(['name' => 'all']);
    }
}
