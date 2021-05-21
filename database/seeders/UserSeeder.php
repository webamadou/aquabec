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
            'email' => 'suadmin@lagenda.quebec',
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email_verified_at' => Carbon::now(),
        'password' => Hash::make('@gend5ue$&c')
        ];
        $adminData = [
            'email' => 'admin@lagenda.quebec',
            'name' => 'Admin',
            'username' => 'admin',
            'email_verified_at' => Carbon::now(),
        'password' => Hash::make('@gend5ue$&c')
        ];
        $banker = [
            'email' => 'banker@lagenda.quebec',
            'name'  => 'Banquier',
            'username'  => 'banquier',
            'email_verified_at' => Carbon::now(),
        'password' => Hash::make('passer')
        ];
        $membre = [
            'email' => 'membre@lagenda.quebec',
            'name' => 'membre',
            'username' => 'membre',
            'email_verified_at' => Carbon::now(),
        'password' => Hash::make('passer')
        ];
        $user = [
            'email' => 'user@lagenda.quebec',
            'name' => 'membre',
            'username' => 'user',
            'email_verified_at' => Carbon::now(),
        'password' => Hash::make('passer')
        ];
        $annonceur = [
            'email' => 'annonceur@lagenda.quebec',
            'name' => 'annonceur',
            'username' => 'annonceur',
            'email_verified_at' => Carbon::now(),
        'password' => Hash::make('passer')
        ];


        $superAdmin = User::updateOrCreate($superAdminData);
        $role       = Role::updateOrCreate(['name' => 'super-admin']);
        $superAdmin->assignRole($role);

        $admin      = User::updateOrCreate($adminData);
        $role       = Role::updateOrCreate(['name' => 'admin']);
        $admin->assignRole($role);

        $banker     = User::updateOrCreate($banker);
        $role       = Role::updateOrCreate(['name' => 'banquier']);
        $banker->assignRole($role);
        $banker->givePermissionTo("Banquier");

        $membre     = User::updateOrCreate($membre);
        $membre->assignRole('membre');

        $membre     = User::updateOrCreate($user);
        $membre->assignRole('membre');

        $membre     = User::updateOrCreate($annonceur);
        $membre->assignRole('annonceur');

    }
}
