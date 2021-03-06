<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Currency;
use App\Models\Role;
use App\Models\City;
use App\Models\Region;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Announcement;
use App\Models\Event;

class UpdateDBController extends Controller
{
    public function index() {
        /* ================= ADABT USERS TABLE =================== */
        $request_fromorigin = DB::connection('mysql2')->table('comptes')->limit(5)->get();
        //$request_fromorigin = DB::connection('mysql2')->table('comptes')->limit(450)->get();
        //$request_fromorigin = DB::connection('mysql2')->table('comptes')->skip(450)->take(450)->get();
        //$request_fromorigin = DB::connection('mysql2')->table('comptes')->skip(900)->take(100)->get();
        ####Updateing users from comptes
        foreach ($request_fromorigin as $key => $item) {
            $user = new User();
            if(trim($item->username) != "" || trim($item->email) != ""){
                $user_exist = User::where('email',$item->email)->first();
                $user = $user_exist?$user_exist:$user;

                $user->username = substr($item->username,0,191);
                $user->password = substr($item->password,0,191);
                $user->email = $item->email?substr($item->email,0,191):'----';
                $user->created_at = substr($item->date_registered,0,191);
                $user->region_id = intval($item->region);
                $user->prenom = substr($item->prenom,0,191);
                $user->name = $item->nom?substr($item->nom,0,191):'-----';
                $user->gender = strtolower($item->sexe) === 'homme'?1:0;
                $user->postal_code = substr($item->code_postal,0,15);
                $user->num_tel = substr($item->telephone,0,40);
                $user->mobile_phone = substr($item->cellulaire,0,40);
                $user->last_seen = $item->last_seen?substr($item->last_seen,0,191):null;
                $user->street = $item->adresse;
                $user->num_civique = substr($item->numero_civique,0,191);
                //get the corresponding age group
                $age_group = \App\Models\AgeRange::where('name','LIKE',"%$item->groupe_age%")->first();
                $user->age_group = @$age_group->name;
                //update city
                //$city_name = str_replace(['Saint-','Sainte-'],'',@$item->ville);
                $city = DB::table('cities')->where('name',"LIKE","%$item->ville%")->first(); 
                echo @$city->name."<br>";
                // $city = City::where('name','LIKE',$city-)->first();
                $user->city_id = @$city->id;
                
                $user->save();
                
                //Update user credits
                $user->setUserCurrency(1, ["free_currency"=>0,"paid_currency" => @$item->credits]);
                //aadapt roles
                $orginal_role = DB::connection('mysql2')->table('usergroups')->find($item->usergroup);
                if($orginal_role){
                    $role_name = ($orginal_role->usergroup === "Adnimistrateur" || $orginal_role->usergroup === "Administrateur") ? 'super-admin' : $orginal_role->usergroup;
                    @$user->assignRole($role_name);
                }

                echo "User $user->prenom $user->name saved<br> with role $role_name";
            }
            
        }
        return "I see fire";
        //*/
        /* ================= ADABT CATEGORIES TABLE =================== *
        $category_annonce = DB::connection('mysql2')->table('categories_annonces')->get();
        foreach ($category_annonce as $key => $item) {
            echo "Saving annonce category $item->categorie <br/>";
            $category = Category::find(@$item->id);
            $category = $category == null? new Category() : $category;
            $category->name = @$item->categorie;
            $category->parent_id = 0;
            $category->slug = Str::slug($item->categorie,'-');
            $category->type = 'annonce';


            $category->save();
        }

        $category_annonce = DB::connection('mysql2')->table('categories_evenements')->get();
        foreach ($category_annonce as $key => $item) {
            echo "Saving evènement category $item->categorie <br/>";
            $category = Category::find(@$item->id);
            $category = $category == null? new Category() : $category;
            $category->name = @$item->categorie;
            $category->parent_id = 0;
            $category->slug = Str::slug($item->categorie,'-');
            $category->type = 'evènement';


            $category->save();
        }
        //*/
        /* ================= ADABT TRANSACTIONS TABLE =================== *
        $transactions = DB::connection('mysql2')->table('credits_transactions')->limit(500)->get();
        // $transactions = DB::connection('mysql2')->table('credits_transactions')->skip(500)->take(500)->get();
        // $transactions = DB::connection('mysql2')->table('credits_transactions')->skip(1000)->take(500)->get();
        // $transactions = DB::connection('mysql2')->table('credits_transactions')->skip(1500)->take(500)->get();
        // $transactions = DB::connection('mysql2')->table('credits_transactions')->skip(2000)->take(500)->get();
        foreach ($transactions as $key => $item) {
            echo "Saving transaction $item->id <br/>";
            $payment = Payment::find(@$item->id);
            $payment = $payment == null? new Payment() : $payment;

            $payment->user_id = @$item->id_compte;
            $payment->created_at = date('Y-m-d', strtotime(@$item->date));
            $payment->updated_at = date('Y-m-d', strtotime(@$item->date));
            $payment->purchassable_id = 1;
            $payment->purchassable_type = "App\Models\Currency";
            $payment->amount = $item->nombre;
            $payment->total_price = $item->cout;
            $payment->payment_method = 'none';
            $payment->note = '';


            $payment->save();
        }
        //*/
        /* ================= ADABT ANNOUNCEMENT TABLE =================== *
        $annonces = DB::connection('mysql2')->table('annonces')->get();
        foreach ($annonces as $key => $item) {
            if(@$item->titre != ""){
                echo "Saving annonce $item->titre <br/>";
                $annonce = Announcement::find(@$item->id);
                $annonce = $annonce == null? new Announcement() : $annonce;

                $annonce->images = @$item->image;
                $annonce->title = @$item->titre;
                $annonce->description = @$item->description;
                $annonce->region_id = @$item->region;
                $annonce->price = @$item->prix;
                $annonce->price_type = "fixed";
                $annonce->website = substr(@$item->site_web,0,250);
                $annonce->telephone = substr(@$item->telephone,0,50);
                $annonce->email = substr(@$item->email,0,150);
                $annonce->validated_at = @$item->validated_date;
                $annonce->published_at = @$item->validated_date;
                $annonce->publication_status = intval(substr(@$item->validated,0,1));
                $annonce->validated = intval(substr(@$item->validated,0,1));
                $annonce->category_id = intval(@$item->categorie);
                $annonce->views = @$item->nombre_vues;
                $annonce->rejection_reasons = @$item->reject_reason;
                $annonce->created_at = @$item->date_added;
                $annonce->updated_at = @$item->date_lastedit;
                $annonce->event_id = @$item->linked_event;

                $user = DB::connection('mysql2')->table('comptes')->where('id',$item->id_utilisateur)->select('id','email')->first();
                if(@$user->id){
                    $user = User::select('id','email')->where('email',$user->email)->first();
                    $annonce->posted_by = @$user->id;
                    $annonce->owner = @$user->id;
                } else {
                    continue;
                }
                $user = DB::connection('mysql2')->table('comptes')->where('id',$item->validated_by)->select('id','email')->first();
                if(@$user->id){
                    $user = User::select('id','email')->where('email','LIKE',$user->email)->first();
                    $annonce->validated_by = @$user->id;
                }

                $category = DB::table('categories')->where('name',"LIKE","%$item->categorie%")->select('id','name')->first(); 
                //save category
                if($category !== null){
                    echo " categorie->".@$category->name."<br>";
                    $annonce->category_id = @$category->id;
                }
                //save cities
                $city = DB::table('cities')->where('name',"LIKE","%$item->ville%")->select('id','name')->first(); 
                echo " ville->".@$city->name."<br>";
                if($city !== null)
                    $annonce->city_id = @$city->id;

                $annonce->save();
            }
        }
        //*/
        /* ================= ADABT ANNOUNCEMENT TABLE =================== *
        // $events = DB::connection('mysql2')->table('evenements')->limit(500)->get();
        //$events = DB::connection('mysql2')->table('evenements')->skip(500)->take(500)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1000)->take(500)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1500)->take(500)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(2000)->take(100)->get();
        foreach ($events as $key => $item) {
            if(@$item->titre != ""){
                echo "Saving event $item->titre <br/>";
                $event = Event::find(@$item->id);
                $event = $event == null? new Event() : $event;

                $event->images = @$item->image;
                $event->title = @$item->titre;
                $event->description = @$item->description;
                $event->region_id = @$item->region;
                $event->website = substr(@$item->site_web,0,250);
                $event->telephone = substr(@$item->telephone,0,50);
                $event->email = substr(@$item->email,0,150);
                $event->validated_at = @$item->validated_date;
                $event->published_at = @$item->validated_date;
                $event->publication_status = intval(substr(@$item->validated,0,1));
                $event->validated = intval(substr(@$item->validated,0,1));
                $event->category_id = intval(@$item->categorie);
                $event->views = @$item->nombre_vues;
                $event->rejection_reasons = @$item->reject_reason;
                $event->created_at = @$item->date_added;
                $event->updated_at = @$item->date_lastedit;
                $user = DB::connection('mysql2')->table('comptes')->where('id',$item->id_utilisateur)->select('id','email')->first();
                if(@$user->id){
                    $user = User::select('id','email')->where('email',$user->email)->first();
                    $event->posted_by = @$user->id;
                    $event->owner = @$user->id;
                } else {
                    continue;
                }
                $user = DB::connection('mysql2')->table('comptes')->where('id',$item->validated_by)->select('id','email')->first();
                if(@$user->id){
                    $user = User::select('id','email')->where('email','LIKE',$user->email)->first();
                    $event->validated_by = @$user->id;
                }

                $category = DB::table('categories')->where('name',"LIKE","%$item->categorie%")->select('id','name')->first(); 
                //save category
                if($category !== null){
                    echo " categorie->".@$category->name."<br>";
                    $event->category_id = @$category->id;
                }
                //save cities
                $city = DB::table('cities')->where('name',"LIKE","%$item->ville%")->select('id','name')->first(); 
                echo " ville->".@$city->name."<br>";
                if($city !== null)
                    $event->city_id = @$city->id;

                $event->save();
            }
        }
        //*/
    }
}
