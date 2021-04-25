<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'Créer des événements', 'permission_group' => 'base'],
            ['name' => 'Créer des annonces classées', 'permission_group' => 'base'],
            ['name' => 'est un represntant', 'permission_group' => 'base'],
            ['name' => 'Transferer du crédit', 'permission_group' => 'base'],
            ['name' => 'Transferer du crédit', 'permission_group' => 'base'],
            ['name' => 'Modifier des pages', 'permission_group' => 'general'],
            ['name' => 'Gérer des organisations', 'permission_group' => 'general'],
            ['name' => 'Gérer des organisations', 'permission_group' => 'general'],
            ['name' => 'Gérer les catégories', 'permission_group' => 'general'],
            ['name' => 'Gérer les groupes', 'permission_group' => 'general'],
            ['name' => 'Gérer les fichiers', 'permission_group' => 'general'],
            ['name' =>'Ajouter/Retirer des credits', 'permission_group' => 'users'],
            ['name' =>'Gestion des utilisateurs', 'permission_group' => 'users'],
            ['name' =>'Gérer lrs groupes d\'utilisateurs', 'permission_group' => 'users'],
            ['name' =>'Télécharger le fichier excel des membres', 'permission_group' => 'users'],
            ['name' =>'Gérer les représentants', 'permission_group' => 'users'],
            ['name' =>'Télécharger le fichier excel des representants', 'permission_group' => 'users'],
            ['name' =>'Accepter des événements', 'permission_group' => 'events'],
            ['name' =>'Supprimer des événements', 'permission_group' => 'events'],
            ['name' =>'Éditer des événements', 'permission_group' => 'events'],
            ['name'=>'Accepter des annonces', 'permission_group' => 'announcement'],
            ['name'=>'Supprimer des annonces', 'permission_group' => 'announcement'],
            ['name'=>'Éditer des annonces', 'permission_group' => 'announcement'],
            ['name'=>'Banquier', 'permission_group' => 'banquier'],
        ];
        foreach ($permissions as $key => $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}
