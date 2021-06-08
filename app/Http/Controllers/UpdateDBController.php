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
use App\Models\EventDate;
use App\Models\Menu;
use App\Models\MenuLink;
use App\Models\Page;
use App\Models\Faq_group;
use App\Models\Faq;

class UpdateDBController extends Controller
{
    public function index() {
        /* ================= ADABT USERS TABLE =================== */
        // $request_fromorigin = DB::connection('mysql2')->table('comptes')->limit(450)->get();
        $request_fromorigin = DB::connection('mysql2')->table('comptes')->limit(450)->get();
        // $request_fromorigin = DB::connection('mysql2')->table('comptes')->skip(450)->take(450)->get();
        // $request_fromorigin = DB::connection('mysql2')->table('comptes')->skip(900)->take(100)->get();
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
        // $transactions = DB::connection('mysql2')->table('credits_transactions')->limit(500)->get();
        // $transactions = DB::connection('mysql2')->table('credits_transactions')->skip(500)->take(500)->get();
        // $transactions = DB::connection('mysql2')->table('credits_transactions')->skip(1000)->take(500)->get();
        // $transactions = DB::connection('mysql2')->table('credits_transactions')->skip(1500)->take(500)->get();
        $transactions = DB::connection('mysql2')->table('credits_transactions')->skip(2000)->take(500)->get();
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
                echo "Saving annonce $item->titre = $item->prix <br/>";
                $annonce = Announcement::find(@$item->id);
                $annonce = $annonce == null? new Announcement() : $annonce;

                $annonce->images = @$item->image;
                $annonce->title = @$item->titre;
                $annonce->description = @$item->description;
                $annonce->region_id = @$item->region;
                $annonce->price = intval(str_replace(['$',','],'',@$item->prix));
                $annonce->price_type = "fixed";
                $annonce->website = substr(@$item->site_web,0,250);
                $annonce->telephone = substr(@$item->telephone,0,50);
                $annonce->postal_code = substr(@$item->code_postal,0,50);
                $annonce->email = substr(@$item->email,0,150);
                $annonce->advertiser_type = substr(@$item->type_annonceur,0,150);
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

                $user = DB::connection('mysql2')
                            ->table('comptes')
                            ->where('id',$item->id_utilisateur)
                            ->select('id','email')
                            ->first();
                // dd($user);
                if(@$user !== null){
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
        /* ================= ADABT  EVENTS TABLE =================== *
        // $events = DB::connection('mysql2')->table('evenements')->limit(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(100)->take(100)->get();
        //$events = DB::connection('mysql2')->table('evenements')->skip(200)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(300)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(400)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(500)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(600)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(700)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(800)->take(100)->get();
        $events = DB::connection('mysql2')->table('evenements')->skip(900)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1000)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1100)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1200)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1300)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1400)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1500)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1600)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1700)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1800)->take(100)->get();
        // $events = DB::connection('mysql2')->table('evenements')->skip(1900)->take(100)->get();
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
                $event->event_time = @$item->heure;
                $event->region_id = @$item->region;
                $event->website = substr(@$item->site_web,0,250);
                $event->telephone = substr(@$item->telephone,0,50);
                $event->email = substr(@$item->email,0,150);
                $event->postal_code = substr(@$item->code_postal,0,150);
                $event->validated_at = @$item->validated_date;
                $event->published_at = @$item->validated_date;
                $event->publication_status = intval(substr(@$item->validated,0,1));
                $event->validated = intval(substr(@$item->validated,0,1));
                $event->category_id = intval(@$item->categorie);
                $event->views = @$item->nombre_vues;
                $event->rejection_reasons = @$item->reject_reason;
                $event->created_at = @$item->date_added;
                $event->updated_at = @$item->date_lastedit;
                $event->validated = @$item->validated;
                $event->validated_by = 1;
                $event->validated_at = @$item->validated_date;
                //get in organisation table name like $item->organisation
                $organisation = DB::table('organisations')->where('name',$item->organisation)->first();
                if(@$organisation){
                    $event->organisation_id = $organisation->id;
                }
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
                //Save dates 
                $event_dates_oroginal = $event_dates = DB::connection('mysql2')->table('evenements_dates')->where('id',$item->id)->get();
                foreach ($event_dates_oroginal as $dates){
                    $event->dates .= date('Y-m-d H:i:s', strtotime($dates->date.' '.$dates->heure));
                    EventDate::create([
                                        'event_id'=>$event->id,
                                        'event_date'=>date('Y-m-d H:i:s', strtotime($dates->date.' '.$dates->heure)),
                                    ]);
                }
                $event->save();
            }
        }
        //*/
        /* ================= ADABT MENUS TABLE =================== *
        $menus = DB::connection('mysql2')->table('PH_menu')->orderby('id', 'asc')->limit(500)->get();
        foreach ($menus as $key => $item) {
            if(@$item->name != ""){
                echo "Saving menus $item->name <br/>";
                $menu = \App\Models\Menu::find(@$item->id);
                $menu = $menu == null? new \App\Models\Menu() : $menu;

                $menu->name     = @$item->name;
                $menu->position = @$item->position;
                $menu->roles    = @$item->permission;
                $menu->public   = intval($item->locked) === 1 ? 0 : 1;
                $menu->visible  = @$item->visible;
                // $menu->page_type = @$item->helppage;
                //$menu->custom_link = @$item->custom_link; 

                $menu->save();
            }
        }
        //*/
        /* ================= ADABT PAGES TABLE =================== *
        // $pages = DB::connection('mysql2')->table('PH_pages')->orderby('id', 'asc')->limit(500)->get();
        // $pages = DB::connection('mysql2')->table('PH_pages')->orderby('id', 'asc')->skip(500)->take(500)->get();
        $pages = DB::connection('mysql2')->table('PH_pages')->orderby('id', 'asc')->skip(1000)->take(500)->get();
        //$pages = DB::connection('mysql2')->table('PH_pages')->orderby('id', 'asc')->skip(1500)->take(500)->get();
        foreach ($pages as $key => $item) {
            //if(@$item->nom != "" && @$item->texte !=""){
                echo "Saving page $item->nom <br/>";
                $page = \App\Models\Page::find(@$item->id);
                $page = $page == null? new \App\Models\Page() : $page;

                $page->id    = @$item->id;
                $page->title    = @$item->nom;
                $page->slug     = @$item->url_name;
                $page->status   = @$item->protected;
                $page->content  = @$item->texte;
                $page->position = @$item->position;
                $page->is_a_separator   = @$item->is_a_separator;
                $page->page_type        = @$item->helppage;
                $page->custom_link      = @$item->custom_link;

                $page->save();
                $menu = Menu::where('name','LIKE', "%$page->menu_parent%")->first();
                if($menu){
                    MenuLink::create(['name'    => $page->title,
                                      'menu_id' => $menu->id,
                                      'page_id' => $page->id,
                                      'visible' => $menu->visible
                                    ]);
                }
            //}
        }
        //*/
        /* ================= ADABT FAQ_GROUPS TABLE =================== *
        $faq_titles = DB::connection('mysql2')->table('faq_titles')->orderby('id', 'asc')->get();
        foreach ($faq_titles as $key => $item) {
            // if(@$item->name != ""){
                $faq_group = Faq_group::where('title', @$item->titre)->first();
                $faq_group = \App\Models\Faq_group::find(@$item->id);
                $faq_group = $faq_group == null? new \App\Models\Faq_group() : $faq_group;

                $faq_group->id    = @$item->id;
                $faq_group->title    = @$item->titre;
                $faq_group->slug     = Str::slug(@$item->titre, '-');
                $faq_group->position = @$item->position;
                $page = DB::connection('mysql')->table('pages')->where('slug', $item->page)->first();
                // $faq_group->page_type = @$item->helppage;
                //$faq_group->custom_link = @$item->custom_link; 
                //if($page){
                //}
                $faq_group->page_id  = @$page->id ?? null;
                $faq_group->save();
                echo "Saving FAQ titles id = $item->id $item->titre === ".@$faq_group->title." ".@$faq_group->id."<br/>";
            // } 
        }
        //*/
        /* ================= ADABT FAQ TABLE =================== *
        // $faqs = DB::connection('mysql2')->table('faq')->orderby('id', 'asc')->limit(500)->get();
        // $faqs = DB::connection('mysql2')->table('faq')->orderby('id', 'asc')->skip(500)->take(500)->get();
        // $faqs = DB::connection('mysql2')->table('faq')->orderby('id', 'asc')->skip(1000)->take(500)->get();
        // $faqs = DB::connection('mysql2')->table('faq')->orderby('id', 'asc')->skip(1500)->take(500)->get();
        // $faqs = DB::connection('mysql2')->table('faq')->orderby('id', 'asc')->skip(2000)->take(500)->get();
        $faqs = DB::connection('mysql2')->table('faq')->orderby('id', 'asc')->skip(2500)->take(500)->get();
        foreach ($faqs as $key => $item) {
            if(@$item->parent_id != ""){
                echo "Saving faq $item->titre <br/>";
                $faq = \App\Models\Faq::find(@$item->id);
                $faq = $faq == null? new \App\Models\Faq() : $faq;

                $faq->title         = @$item->titre;
                $faq->faq_group_id  = @$item->parent_id;
                $faq->position      = @$item->position;
                $faq->content       = @$item->contenu;
                $faq->publication_status   = 1;
                //Get faq_title from faq->parent_id
                // $faq_title = DB::connection('mysql2')->table('faq_titles')->select('titre','id')->where('id', $item->parent_id)->first();
                //$faq_groups = DB::connection('mysql')->table('faq_groups')->select('title','id','page_id')->where('title', //$faq_title->titre)->first(); 
                
                // echo "@$faq_groups->title + $faq_groups->page_id => faq->parent_id = $item->parent_id<br>";
                $faq->page_id  = @$item->parent_id;

                $faq->save();
            }
        }
        //*/
    }
}
