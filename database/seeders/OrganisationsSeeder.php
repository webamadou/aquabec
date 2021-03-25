<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organisation;

class OrganisationsSeeder extends Seeder
{
    public $organisations = [
                        ["name" => "Age d\'or"],
                        ["name" => "Association de "],
                        ["name" => "Chambre de commerce"],
                        ["name" => "Chevaliers de Colomb"],
                        ["name" => "Choisir Organisateur dans liste déroulante"],
                        ["name" => "Club Optimiste"],
                        ["name" => "Cours"],
                        ["name" => "Eglise"],
                        ["name" => "Entreprise"],
                        ["name" => "F.A.D.O.Q."],
                        ["name" => "Filles  Isabelle"],
                        ["name" => "Folklore Québec"],
                        ["name" => "Hôtel Bar Club"],
                        ["name" => "L\'Agenda du Québec"],
                        ["name" => "La Tablée"],
                        ["name" => "La Ville"],
                        ["name" => "Les Loisirs"],
                        ["name" => "Les Petits Frères"],
                        ["name" => "Municipalité"],
                        ["name" => "Par un commerce"],
                        ["name" => "Par un particulier"],
                        ["name" => "Producteur"],
                        ["name" => "Relais vers le collaborateur"],
                        ["name" => "Salon"],
                        ["name" => "Un membre"],
                        ["name" => "Z Neutre"],
        ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->organisations as $organisation){
            Organisation::updateOrCreate($organisation);
        }
    }
}
