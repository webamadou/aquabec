<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public $regions = [
        ['region_number'=>'01','name'=> 'Bas-Saint-Laurent'],
        ['region_number'=>'02','name'=> 'Saguenay–Lac-Saint-Jean'],
        ['region_number'=>'03','name'=> 'Capitale-Nationale'],
        ['region_number'=>'04','name'=> 'Mauricie'],
        ['region_number'=>'05','name'=> 'Estrie'],
        ['region_number'=>'06','name'=> 'Montréal'],
        ['region_number'=>'07','name'=> 'Outaouais'],
        ['region_number'=>'08','name'=> 'Abitibi-Témiscamingue'],
        ['region_number'=>'09','name'=> 'Côte-Nord'],
        ['region_number'=>'10','name'=> 'Nord-du-Québec'],
        /* ['region_number'=>'00','name'=> 'CRÉ de la Baie-James'],
        ['region_number'=>'00','name'=> 'Cree Regional Authority'],
        ['region_number'=>'00','name'=> 'Kativik Regional Government'], */
        ['region_number'=>'11','name'=> 'Gaspésie–Îles-de-la-Madeleine'],
        ['region_number'=>'12','name'=> 'Chaudière-Appalaches'],
        ['region_number'=>'13','name'=> 'Laval'],
        ['region_number'=>'14','name'=> 'Lanaudière'],
        ['region_number'=>'15','name'=> 'Laurentides'],
        ['region_number'=>'16','name'=> 'Montérégie'],
        /* ['region_number'=>'00','name'=> 'CRÉ de Longueuil'],
        ['region_number'=>'00','name'=> 'CRÉ Montérégie Est'],
        ['region_number'=>'00','name'=> 'CRÉ Vallée-du-Haut-Saint-Laurent'], */
        ['region_number'=>'17','name'=> 'Centre-du-Québec'],
        ['region_number'=>'20','name'=> 'Partout au Québec'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->regions as $key => $value) {
            $region = $value;
            $region['slug'] = Str::of($region['name'])->slug('-');
            
            Region::updateOrCreate($region);
        }
    }
}
