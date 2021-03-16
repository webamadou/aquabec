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
        Role::updateOrCreate(['name' => 'chef-vendeur']);
        Role::updateOrCreate(['name' => 'vendeur']);
        Role::updateOrCreate(['name' => 'annonceur']);
        Role::updateOrCreate(['name' => 'Repr: Representant niveau QUATRE']);
        Role::updateOrCreate(['name' => 'Expiré']);
        Role::updateOrCreate(['name' => 'Anno: Annonceur test']);
        Role::updateOrCreate(['name' => 'Publ: Publiciste']);
        Role::updateOrCreate(['name' => 'Empl: Débutant']);
        Role::updateOrCreate(['name' => 'Memb: Membre débutant']);
        Role::updateOrCreate(['name' => 'Empl: Employé  nt']);
        Role::updateOrCreate(['name' => 'Repr: Représentant débutant']);
        Role::updateOrCreate(['name' => 'Fonction en transition']);
        Role::updateOrCreate(['name' => 'Fond Fondation']);
        Role::updateOrCreate(['name' => 'Fond Fondation DEUX']);
        Role::updateOrCreate(['name' => 'Association  un test']);
        Role::updateOrCreate(['name' => 'Attendre réponse suite au courriel']);
        Role::updateOrCreate(['name' => 'Rencontre']);
        Role::updateOrCreate(['name' => 'Membre 1 mois C un mois']);
        Role::updateOrCreate(['name' => 'Secrétaire']);
        Role::updateOrCreate(['name' => 'Secrétaire (représentant)']);
        Role::updateOrCreate(['name' => 'Livreur de Bas de nylon']);

        $permission = Permission::updateOrCreate(['name' => 'all']);
    }
}
