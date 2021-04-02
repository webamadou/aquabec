<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Models\AgeRange;
use App\Models\CreditsTransfersLog;
use App\Models\Announcement;
use App\Models\Event;

use Mail;
use App\Mail\UserMails;


class DashboardController extends Controller
{
    public function index()
    {
        $notifications  = \App\Models\Notifications::all();
        $current_user   = auth()->user();
        $events         = $current_user->myEvents()->count() ;
        $announcements  = $current_user->myAnnouncements()->count() ;
        return view('user.dashboard', compact('notifications','events','announcements'));
    }
    /**
     * 
     * page of the vendors of a chief vendor
     */
    public function myTeam(){
        $current_user = auth()->user();
        if($current_user->can("vendor", $current_user)){
            return view('user.vendeurs.my_team', compact('current_user'));
        }
    }
    /**
     * Return the datable of the vendeur of a chef vendeur on datatable format
     */
    public function myTeamData($user_id = null) {
        $user_id = $user_id === null?auth()->user()->id:$user_id;
        //we get the vendeurs of the currently authenticated user
        $logs = User::vendors()->where('godfather', $user_id)->where('profile_status','<=','1')->get();
        if(auth()->user()->hasRole('vendeur')){
            $logs = auth()->user()->godchildren()->where('profile_status','<=',1)->get();
        }

        return datatables()
            ->collection($logs)
            ->addColumn('action', function($item){
                $edit_route = route('vendeurs.edit_vendeur',$item);
                return view('layouts.back.datatables.actions-btn', compact('edit_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showProfile(User $user)
    {
        if($user->profile_status >1)
            return $this->notAvailable();
        $current_user = auth()->user();
        return view('user.profile.show', compact('user','current_user'));
    }

    public function createVendeur()
    {
        $current_user   = auth()->user();
        $user           = new User();
        $region_list    = Region::pluck('name','id');
        $cities_list    = City::where('region_id',$user->region_id)->pluck('name','id');
        $age_group      = AgeRange::ageSelect();
        $title          = $current_user->hasRole('vendeur')?"Enregistrer un annonceur dans votre équipe":"Enregistrer un vendeur dans votre équipe";
        $role_name          = $current_user->hasRole('vendeur')?"vendeur":"annonceur";

        return view('user.vendeurs.cvcreate', compact('title','current_user','user','region_list','cities_list','age_group','role_name'));
    }

    public function editVendeur(User $user)
    {
        // dd($user->email);
        $current_user = auth()->user();
        $region_list = Region::pluck('name','id');
        $cities_list = City::where('region_id',$user->region_id)->pluck('name','id');
        $age_group   = AgeRange::ageSelect();

        return view('user.vendeurs.cvedit', compact('current_user','user','region_list','cities_list','age_group'));
    }

    public function infosPerso($default_tab=null){
        //the default_tab var is use to set default tab to display in the page 
        $user = auth()->user();
        $default_tab = $default_tab == null ? 'account': $default_tab ;
        $region_list = Region::pluck('name','id');
        $cities_list = City::where('region_id',$user->region_id)->pluck('name','id');

        $age_group   = AgeRange::ageSelect();

        $fonction_except    = ['admin','super-admin','membre','chef vendeur','chef-vendeur','vendeur','Banquier'];
        $fonctions          = Role::select('name','id','description')->whereNotIn("name",$fonction_except)->get();

        return view('user.profile.infosperso',compact('region_list','cities_list', 'age_group','user','default_tab','fonctions'));
    }

    public function selectCities(Request $request)
    {
        $res = Region::find($request->id)->cities->pluck('name','id');

        return response()->json($res);
    }
    /**
     * 
     * return the data for the datatable.
     */
    public function userSentTransactions()
    {
        $user = auth()->user();
        $logs = CreditsTransfersLog::with('sentBy','sentTo','credit')
                                    ->where('sent_by',$user->id)
                                    ->orWhere('sent_to',$user->id)
                                    ->orderBy("created_at","desc")
                                    ->get();

        return datatables()
            ->collection($logs)
            /* ->addColumn('action',function ($logs) {
                $edit_route = route('banker.credits.edit',$logs);
                $delete_route = route('banker.credits.destroy',$logs);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            }) */
            /* ->rawColumns(['action']) */
            ->make(true);
    }

    public function notAvailable()
    {
        return view('user.not_available');
    }
    
    public function transferCurrency(\App\Models\Currency $currency)
    {
        $current_user = auth()->user();
        $currency = $current_user->currencies()->where('slug',$currency->slug)->first();
        if(!$currency){
            return redirect()->route('welcome');
        }
        $users = $current_user->recipientList()
                              ->select('id','name','prenom','email')
                              ->get();

        //We need to display the id next to name in list of users. We just need to add some leading zeros
        $nbr_leading_zeros = $users->count()<100?3:0;

        return view("user.currencies.transfer", compact("currency","users","current_user","nbr_leading_zeros"));
    }
    /**
     * Will use this method to return the image for an announcement
     */
    public function showImage($images=null)
    {
        $path = storage_path('app/public/images/announcements/'. $images);
        if ($images ===null || !\File::exists($path)) {
            $path = storage_path('app/public/images/announcements/default.jpg');
        }
        $file = \File::get($path);
        $type = \File::mimeType($path);
        $response = \Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
    /** *** ANNOUNCEMENT METHODS *** */
    /*
     * Get current user announcements data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myAnnouncementsData()
    {
        $user = auth()->user();
        $announcement = $user->myAnnouncements()->with('owned','posted','category','region','city')->get();
        return datatables()
            ->collection($announcement)
            ->addColumn('action',function ($item) {
                $edit_route = route('user.edit_announcement',$item);
                $delete_route = route('user.delete_announcement',$item);

                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * list anoucements of current user
     */
    public function myAnnouncements()
    {
        $user = auth()->user();
        $announcements = $user->myAnnouncements();

        return view('announcements.my_announcements', compact('user','announcements'));
    }
    /**
     * Create annoucement
     */
    public function create()
    {
        $categories = Category::where('type','annonce')->get();
        $regions    = Region::pluck('name','id');
        $cities     = City::pluck('name','id');
        $status     = ['Enregistrer en brouillon','Publiée','Enregistrer en privée'];
        $user       = auth()->user();
        $children   = $user->godchildren()->select('name','prenom','email','id')->get();
        //Check if user has enough of needed currency
        $can_post   = $user->userHasEnoughCredit('annoucements_price','paid_currency');
        $user_events = $user->getUnlinkedEvents()->pluck("events.title","events.id")->all();

        return view('announcements.add_announcement',compact('categories','regions','cities','status','children','user','can_post','user_events'));
    }
    /**
     * Store announcement
     */
    public function storeAnnouncement(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required',
            'description'   => 'nullable',
            'excerpt'       => 'nullable',
            'category_id'   => 'required',
            'images'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'parent'        => 'nullable',
            'posted_by'     => 'required',
            'region_id'     => 'nullable',
            'city_id'       => 'nullable',
            'publication_status'=> 'required',
            'published_at'  => 'nullable',
            'dates'         => 'nullable',
        ]);
        $current_user = auth()->user();
        if(!isset($request->owner)){//If the owner is not defined the publisher become the publisher
            $data['owner'] = $current_user->id;
        } else {
            $data['owner'] = $request->owner;
        }
        //dd($data,$request->owner);
        //Check if user has enough to post
        $can_post   = $current_user->userHasEnoughCredit('annoucements_price','free_currency');
        $data['publication_status'] = $can_post ? $data["publication_status"] : 0;

        $data['posted_by'] = $current_user->id;
        //If announce is published we set the published_at column save the data and update user wallets
        $data['published_at'] = intval($data['publication_status']) === 1 ? date('Y-m-d H:i:s') : null;
        
        $save_publication = Announcement::create($data);//save data
        if($save_publication){
            //We update user's wallet
            $current_user->updateUserWallet(1,"annoucements_price");

            //Actions if an image is uploaded
            $owner = $save_publication->owned()->select('name','prenom','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-',$owner->name)."_".str_replace(' ','-', $owner->prenom)."_".str_replace(' ','-',$owner->id);
            if($request->has('images')){
                $image = $request->file('images');
                $image_name = $save_publication->slug.".".\File::extension($image->getClientOriginalName());
                $image_path = 'images/announcements';
                $save_publication_images = $image->storeAs($image_path,$image_name,'public');
                $save_publication->images = $image_name;
                $save_publication->save();
            }
            return redirect()
                    ->route('user.my_announcements')
                    ->with('success',"Votre annonce a été enregistrée avec succès");
        }
        return redirect()->back();
    }
    /**
     * Show annoucement
     */
    public function showAnnouncement(Announcement $announcement)
    {
        $current_user = auth()->user();
        //User can view annonce if is owner or publisher or announcement is validated and published
        //Later we will have to set gates or policies for this
        if((
                intval(@$announcement->publication_status) !== 1 || 
                intval(@$announcement->lock_publication) === 1) 
        && (
                intval(@$current_user->id) !== intval(@$announcement->owner) && 
                intval(@$current_user->id) !== intval(@$announcement->posted_by)
        )){
            $message = "Ce contenu n'est pas disponible";
            return view('frontend.feedback',compact('message'));
        }
        $announcement->countViews();
        $announcement->countClicks();
        return view('announcements.show_announcement', compact('announcement','current_user'));
    }
    /**
     * Edit Announcement
     */
    public function editAnnouncement(Announcement $announcement)
    {
        $categories = Category::where('type','annonce')->get();
        $regions    = Region::pluck('name','id');
        $cities     = City::pluck('name','id');
        $status     = ['Enregistrer en brouillon','Publiée','Enregistrer en privée'];
        $user       = auth()->user();
        $children   = $user->godchildren()->select('name','prenom','email','id')->get();
        //Check if user has enough credit
        $can_post   = $user->userHasEnoughCredit('annoucements_price','paid_currency');

        return view('announcements.edit_announcement',compact('announcement','categories','regions','cities','status','children','user','can_post'));
    }
    /**
     * Update announcement
     */
    public function updateAnnouncement(Request $request,Announcement $announcement)
    {
        $data = $request->validate([
            'title'         => 'required',
            'description'   => 'nullable',
            'excerpt'       => 'nullable',
            'category_id'   => 'required',
            'images'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'parent'        => 'nullable',
            'posted_by'     => 'required',
            'region_id'     => 'nullable',
            'city_id'       => 'nullable',
            'publication_status'=> 'required',
            'published_at'  => 'nullable',
            'dates'         => 'nullable',
        ]);
        $current_user = auth()->user();
        if(!isset($request->owner)){//If the owner is not defined the publisher become the publisher
            $data['owner'] = $current_user->id;
        } else {
            $data['owner'] = $request->owner;
        }
        //If annouce is published we set the published_at column
        if(intval($data['publication_status']) === 1){
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        $data['posted_by'] = $current_user->id;
        //Make sure user has enough to publish
        $can_post   = $current_user->userHasEnoughCredit('annoucements_price','free_currency');
        $data['publication_status'] = $can_post ? $data["publication_status"] : 0;

        $save = $announcement->update($data);
        if($save){
            /* if(intval($data['publication_status']) === 1){
                $current_user->updateUserWallet(1,"annoucements_price");
            } */
            //Actions if an image is uploaded
            $owner = $announcement->owned()->select('name','prenom','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-',$owner->name)."_".str_replace(' ','-', $owner->prenom)."_".str_replace(' ','-',$owner->id);
            if($request->has('images')){
                $image = $request->file('images');
                $image_name = $announcement->slug.".".\File::extension($image->getClientOriginalName());
                $image_path = 'images/announcements';
                $save_images = $image->storeAs($image_path,$image_name,'public');
                $announcement->images = $image_name;
                $announcement->save();
            }
            return redirect()
                    ->back()
                    ->with('success',"Votre annonce a été modifiée avec succès");
        }
        return redirect()
                    ->back()
                    ->with('error',"Il s'est produite une erreur");
    }
    /**
     * Delete announcement
     */
    public function deleteAnnouncement(Announcement $announcement)
    {
        if($announcement) {
            //The publication is not trully deleted but rather hidden
            $announcement->publication_status = 4;
            $announcement->delete();
            return redirect()
                        ->route('user.my_announcements')
                        ->with('success', "L'annonce a été supprimée");
        }
    }

    /**
     * list events of current user
     */
    public function myEvents()
    {
        $user = auth()->user();
        $events = $user->myEvents();

        return view('events.my_events', compact('user','events'));
    }
    /**
     * Create event
     */
    public function createEvent(Announcement $announcement = null)
    {
        $categories = Category::where('type','evènement')->get();
        $regions    = Region::pluck('name','id');
        $cities     = City::pluck('name','id');
        $status     = ['Enregistrer en brouillon','Publiée','Enregistrer en privée'];
        $user       = auth()->user();
        $children   = $user->godchildren()->select('name','prenom','email','id')->get();
        //Check if user has enough credit
        $can_post   = $user->userHasEnoughCredit('events_price','free_currency');

        return view('events.add_event',compact('announcement','categories','regions','cities','status','children','user','can_post'));
    }

    /**
     * Store announcement
     */
    public function storeEvent(Request $request)
    {
        //dd("ici",$request->dates);
        $data = $request->validate([
            'title'         => 'required|max:250',
            'description'   => 'nullable',
            'excerpt'       => 'nullable',
            'category_id'   => 'nullable',
            'images'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'parent'        => 'nullable',
            'posted_by'     => 'required',
            'postal_code'   => 'nullable',
            'region_id'     => 'required',
            'telephone'     => 'nullable',
            'email'         => 'nullable|email',
            'website'       => 'nullable',
            'city_id'       => 'nullable',
            'publication_status'=> 'required',
            'published_at'  => 'nullable',
            'dates'         => 'required',
        ]);
        $current_user = auth()->user();
        if(!isset($request->owner)){//If the owner is not defined the publisher become the publisher
            $data['owner'] = $current_user->id;
        } else {
            $data['owner'] = $request->owner;
        }
        //If annouce is published we set the published_at column
        if(intval($data['publication_status']) === 1){
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        $data['posted_by'] = $current_user->id;
        //Make sure user has enough to publish
        $can_post   = $current_user->userHasEnoughCredit('annoucements_price','free_currency');
        $data['publication_status'] = $can_post ? $data["publication_status"] : 0;

        if($save = Event::create($data)){
            //We update user's wallet after save
            $current_user->updateUserWallet(1,"events_price");

            //Actions if an image is uploaded
            $owner = $save->owned()->select('name','prenom','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-',$owner->name)."_".str_replace(' ','-', $owner->prenom)."_".str_replace(' ','-',$owner->id);
            if($request->has('images')){
                $image = $request->file('images');
                $image_name = config('app.name').'-'.$save->slug.".".\File::extension($image->getClientOriginalName());
                $image_path = 'images/announcements';
                $save_images = $image->storeAs($image_path,$image_name,'public');
                $save->images = $image_name;
                $save->save();
            }
            return redirect()
                    ->route('user.my_events')
                    ->with('success',"Votre évènement a été enregistré avec succès");
        }
        return redirect()->back();
    }

}
