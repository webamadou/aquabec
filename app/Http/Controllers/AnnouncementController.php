<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Region;
use App\Models\City;

class AnnouncementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['role:vendeur|annonceur|super-admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(User::with('roles')->get());
        return view('home');
    }
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
        $children   = $user->godchildren()
                            ->where('profile_status','<=',1)
                            ->select('username','id')
                            ->get();
        //Check if user has enough of needed currency
        $can_post   = $user->userHasEnoughCredit('annoucements_price','paid_currency');
        $role_currency = $user->mainRole()->currency;
        $user_events = $user->getUnlinkedEvents()->pluck("events.title","events.id")->all();

        $announcement = new Announcement();
        $announcement->postal_code = @$user->postal_code;
        $announcement->email       = @$user->email;
        $announcement->telephone   = @$user->num_tel;

        return view('announcements.add_announcement',compact('announcement','categories','regions','cities','status','children','user','can_post','role_currency','user_events'));
    }
    /**
     * Store announcement
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required',
            'description'   => 'nullable',
            'excerpt'       => 'nullable',
            'category_id'   => 'required',
            'advertiser_type'=> 'required',
            'images'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'parent'        => 'nullable',
            'posted_by'     => 'required',
            'region_id'     => 'nullable',
            'city_id'       => 'nullable',
            'publication_status'=> 'required',
            'published_at'  => 'nullable',
            'dates'         => 'nullable',
            'event_id'      => 'nullable',
            'price_type'    => 'required',
            'price'         => 'nullable',
            'postal_code'   => 'nullable',
            'telephone'     => 'nullable',
            'email'         => 'nullable',
            'website'       => 'nullable',
        ]);
        $current_user = auth()->user();
        if(!isset($request->owner)){//If the owner is not defined the publisher become the owner
            $data['owner'] = $current_user->id;
        } else {
            $data['owner'] = $request->owner;
        }
        //Check if user has enough to post
        $can_post   = $current_user->userHasEnoughCredit('annoucements_price','paid_currency');
        $data['publication_status'] = $can_post ? $data["publication_status"] : 0;

        $data['posted_by'] = $current_user->id;
        //If announce is published we set the published_at column save the data and update user wallets
        $data['published_at'] = intval($data['publication_status']) === 1 ? date('Y-m-d H:i:s') : null;
        //If price type is set to 1 we need to be sure the price is set
        if(intval(@$data['price_type']) === 1 && (trim(@$data['price']) == "" || intval($data['price']) < 0)){
            return redirect()
                        ->back()
                        ->with("error", "Vous devez preciser le prix de votre annonce")
                        ->withInput();
        }
        $save_announcement = Announcement::create($data);//save data
        // dd($data['event_id'],$save_announcement);
        if($save_announcement){
            //We update user's wallet we make him/her spend the currency if is publishing
            if(intval($data['publication_status']) === 1 ){
                $current_user->updateUserWallet(1,"annoucements_price");
                $save_announcement->purchased = 1;
                // dd("You are publising",$save_announcement->purchased, $save_announcement);
            }
            //Actions if an image is uploaded
            $owner = $save_announcement->owned()->select('username','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-', $owner->username)."_".str_replace(' ','-',$owner->id);
            if($request->has('images')){
                $image = $request->file('images');
                $image_name = $save_announcement->slug.".".\File::extension($image->getClientOriginalName());
                $image_path = 'images/announcements';
                $save_announcement_images = $image->storeAs($image_path,$image_name,'public');
                $save_announcement->images = $image_name;
            }
            $save_announcement->lock_publication = 0; 
            $save_announcement->save();

            if(@$data['event_id'] !== null && @$data['event_id'] !== ""){
                return redirect()
                        ->route('user.my_announcements')
                        ->with('success',"Votre annonce a été enregistrée avec succès");
            } else {
                $save_announcement->lock_publication = 1;
                $save_announcement->save();
                return redirect()
                        ->route('user.create_event',$save_announcement)
                        ->with('success',"Votre annonce a été enregistrée avec succès");
            }
        }
        return redirect()->back();
    }
    /**
     * Show annoucement
     */
    public function show(Announcement $announcement)
    {
        $current_user = auth()->user();
        //User can view annonce if is owner or publisher or announcement is validated and published
        //Later we will have to set gates or policies for this
        if(intval(@$announcement->publication_status) !== 1 && (
                intval(@$current_user->id) !== intval(@$announcement->owner) && 
                intval(@$current_user->id) !== intval(@$announcement->posted_by)
                )
        ){
            $message = "Ce contenu n'est pas encore disponible";
            return view('frontend.feedback',compact('message'));
        }
        $announcement->countViews();
        $announcement->countClicks();
        return view('announcements.show_announcement', compact('announcement','current_user'));
    }
    /**
     * Edit Announcement
     */
    public function edit(Announcement $announcement)
    {
        $categories = Category::where('type','annonce')->get();
        $regions    = Region::pluck('name','id');
        $cities     = City::pluck('name','id');
        $status     = ['Enregistrer en brouillon','Publiée','Enregistrer en privée'];
        $user       = auth()->user();
        $children   = $user->godchildren()
                            ->where('profile_status','<=',1)
                            ->select('username','id')
                            ->get();
        $role_currency = $user->mainRole()->currency;
        //Check if user has enough credit
        $can_post   = $user->userHasEnoughCredit('annoucements_price','paid_currency');
        $user_events = $user->getUnlinkedEvents()->pluck("events.title","events.id")->all();

        $announcement->postal_code = trim($announcement->postal_code) === ""?$user->postal_code:@$announcement->postal_code;
        $announcement->email       = trim($announcement->email) === ""?$user->email:@$announcement->email;
        $announcement->telephone   = trim($announcement->telephone) === ""?$user->num_tel:@$announcement->telephone;

        return view('announcements.edit_announcement',compact('announcement','categories','regions','cities','status','children','user','role_currency','can_post','user_events'));
    }
    /**
     * Update announcement
     */
    public function update(Request $request,Announcement $announcement)
    {
        $data = $request->validate([
            'title'         => 'required',
            'description'   => 'nullable',
            'excerpt'       => 'nullable',
            'category_id'   => 'required',
            'advertiser_type'=> 'required',
            'images'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'parent'        => 'nullable',
            'posted_by'     => 'required',
            'region_id'     => 'nullable',
            'city_id'       => 'nullable',
            'publication_status'=> 'required',
            'published_at'  => 'nullable',
            'dates'         => 'nullable',
            'price_type'    => 'required',
            'price'         => 'nullable',
            'event_id'      => 'nullable',
            'postal_code'   => 'nullable',
            'telephone'     => 'nullable',
            'email'         => 'nullable',
            'website'       => 'nullable',
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
        $can_post   = $current_user->userHasEnoughCredit('annoucements_price','paid_currency');
        $data['publication_status'] = $can_post ? $data["publication_status"] : 0;

        $save = $announcement->update($data);
        if($save){
            //We update user's wallet we make him/her spend the currency if is publishing
            if( intval($data['publication_status']) === 1 && intval(@$announcement->purchased) === 0 ){
                $current_user->updateUserWallet(1,"annoucements_price");
                $announcement->purchased = 1;
            }

            //Actions if an image is uploaded
            $owner = $announcement->owned()->select('username','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-', $owner->username)."_".str_replace(' ','-',$owner->id);
            if($request->has('images')){
                $image = $request->file('images');
                $image_name = $announcement->slug.".".\File::extension($image->getClientOriginalName());
                $image_path = 'images/announcements';
                $save_images = $image->storeAs($image_path,$image_name,'public');
                $announcement->images = $image_name;
            }
            if($announcement->event == null){
                $announcement->lock_publication = 1;
                $announcement->save();

                return redirect()
                        ->route('user.create_event',$announcement)
                        ->with('success',"Votre annonce a été modifiée avec succès. Vous devez maintenant la lier à un événement");
            } elseif (intval($announcement->lock_publication) === 1) {
                $announcement->lock_publication = 0;
            }
            $announcement->save();

            return redirect()
                    ->back()
                    ->with('success',"Votre annonce a été enregistrée avec succès");
        }
        return redirect()
                    ->back()
                    ->with('error',"Il s'est produite une erreur");
    }
    /**
     * Delete announcement
     */
    public function delete(Announcement $announcement)
    {
        if($announcement) {
            /* //The publication is not trully deleted but rather hidden
            $announcement->publication_status = 4;
            $announcement->event_id = NULL; */
            $announcement->delete();
            return redirect()
                        ->route('user.my_announcements')
                        ->with('success', "L'annonce a été supprimée");
        }
    }
}
