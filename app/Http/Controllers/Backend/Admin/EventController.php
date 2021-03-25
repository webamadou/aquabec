<?php
namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Region;
use App\Models\City;

class EventController extends Controller
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

    /** *** EVENTS METHODS *** */
    /**
     * List events
     */
    public function myEventsData()
    {
        $user = auth()->user();
        $events = Event::with('owned','posted','category','region','city')
                        ->select('id','title','dates','event_time','owner','posted_by','updated_at','validated')
                        ->get();
        return datatables()
            ->collection($events)
            ->addColumn('action',function ($item) {
                $edit_route = "#";
                $modal_togglers = [
                    [
                        'name' => "Valider l'événement",
                        'route' => route('admin.validation_event',$item),
                        'modal_title' => "Confirmer ou rejeter la validation de l'événement <strong>$item->title</strong>"
                    ]
                ];

                return view('layouts.back.datatables.actions-btn',compact('edit_route','modal_togglers'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * list events of current user
     */
    public function myEvents()
    {
        $user = auth()->user();
        $events = $user->myEvents();

        return view('admin.events.my_events', compact('user','events'));
    }


    /**
     * Validation events
     */
    public function validation(Request $request, Event $event)
    {
        $data = $request->validate([
            'validated' => 'required',
            'rejection_reasons' => 'nullable'
            ]);
        
        $event->validated = $data['validated'];
        $event->rejection_reasons = $data['rejection_reasons'];
        $event->validated_by = auth()->user()->id;
        $event->validated_at = date('Y-m-d H:i:s');
        $event->save();
        $message = "L'annonce a été validée";
        if($event->validated > 1){
            $message = "L'annonce à été rejetée";
        }
        //dd($announcement->id,$announcement->title,@$data);
        return redirect()
                    ->back()
                    ->with('success', $message);
    }
    /**
     * Create event
     * 
     */
    public function create(Announcement $announcement = null)
    {
        $categories = Category::where('type','evènement')->get();
        $regions    = Region::pluck('name','id');
        $cities     = City::pluck('name','id');
        $status     = ['Enregistrer en brouillon','Publiée','Enregistrer en privée'];
        $user       = auth()->user();
        $children   = $user->godchildren()->select('name','prenom','email','id')->get();
        $role_currency = $user->mainRole()->currency;
        //Check if user has enough credit
        $can_post   = $user->userHasEnoughCredit('events_price','free_currency');

        $event = new Event();
        $event->postal_code = @$user->postal_code;
        $event->email       = @$user->email;
        $event->telephone   = @$user->num_tel;
        $organisations      = \App\Models\Organisation::pluck("name","id");

        return view('admin.events.add_event',compact('event','announcement','categories','regions','cities','status','children','user','role_currency','can_post',"organisations"));
    }

    /**
     * Store announcement
     */
    public function store(Request $request)
    {
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
            'event_time'    => 'nullable',
            'organisation_id'    => 'nullable',
        ]);
        $current_user = auth()->user();
        if(!isset($request->owner)){//If the owner is not defined the publisher become the publisher
            $data['owner'] = $current_user->id;
        } else {
            $data['owner'] = $request->owner;
        }
        $data['posted_by'] = $current_user->id;
        //Make sure user has enough to publish
        $can_post   = $current_user->userHasEnoughCredit('annoucements_price','free_currency');
        $data['publication_status'] = $can_post ? $data["publication_status"] : 0;

        $save_event = Event::create($data);//save data
        if($save_event){
            //We update user's wallet we make him/her spend the currency if is publishing
            if(intval($data['publication_status']) === 1 ){
                $save_event->published_at = date('Y-m-d H:i:s');
                //We update user's wallet we make him/her spend the currency
                $current_user->updateUserWallet(1,"events_price");
                $save_event->purchased = 1;
            }
            //Actions if an image is uploaded
            $owner = $save_event->owned()->select('name','prenom','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-',$owner->name)."_".str_replace(' ','-', $owner->prenom)."_".str_replace(' ','-',$owner->id);
            if($request->has('images')){
                $image = $request->file('images');
                $image_name = config('app.name').'-'.$save_event->slug.".".\File::extension($image->getClientOriginalName());
                $image_path = 'images/announcements';
                $save_event_images = $image->storeAs($image_path,$image_name,'public');
                $save_event->images = $image_name;
            }
            $save_event->save();

            //If we have an announcement in the request, we need to link it to the event
            if($request->announcement_id){
                $announcement = Announcement::select('id','event_id')
                                    ->where('id',$request->announcement_id)
                                    ->first();
                if($announcement){
                    $announcement->event_id = $save_event->id;
                    $announcement->save();
                }
            return redirect()
                    ->route('admin.announcements')
                    ->with('success',"Votre évènement a été enregistré et relier à l'annonce");
            }
            return redirect()
                    ->route('admin.listevents')
                    ->with('success',"Votre évènement a été enregistré avec succès");
        }
        return redirect()->back();
    }

    /**
     * Show event
     */
    public function show(Event $event)
    {
        $current_user = auth()->user();
        //User can view annonce if is owner or publisher or event is validated and published
        //Later we will have to set gates or policies for this
        if(intval(@$event->publication_status) !== 1 && (
                        intval(@$current_user->id) !== intval(@$event->owner) && 
                        intval(@$current_user->id) !== intval(@$event->posted_by)
                    )
        ){
            $message = "Ce contenu n'est pas encore disponible";
            return view('frontend.feedback',compact('message'));
        }
        $event->countViews();
        $event->countClicks();
        return view('admin.events.show_event', compact('event','current_user'));
    }

    /**
     * Edit Announcement
     */
    public function edit(Event $event)
    {
        $categories = Category::where('type', 'évènement')->get();
        $regions    = Region::pluck('name','id');
        $cities     = City::pluck('name','id');
        $status     = ['Enregistrer en brouillon','Publiée','Enregistrer en privée'];
        $user       = auth()->user();
        $children   = $user->godchildren()->select('name','prenom','email','id')->get();
        $role_currency = $user->mainRole()->currency;
        //Check if user has enough credit
        $can_post       = $user->userHasEnoughCredit('events_price','free_currency');
        $announcement   = Announcement::where('event_id',$event->id)->first();

        $event->postal_code = trim($event->postal_code) === ""?$user->postal_code:@$event->postal_code;
        $event->email       = trim($event->email) === ""?$user->email:@$event->email;
        $event->telephone   = trim($event->telephone) === ""?$user->num_tel:@$event->telephone;
        $organisations      = \App\Models\Organisation::pluck("name","id");

        return view('admin.events.edit_event',compact('event','categories','regions','cities','status','children','user','can_post','role_currency','announcement','organisations'));
    }

    /**
     * Update announcement
     */
    public function update(Request $request,Event $event)
    {
        $data = $request->validate([
            'title'         => 'required',
            'description'   => 'nullable',
            'excerpt'       => 'nullable',
            'category_id'   => 'nullable',
            'images'        => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'parent'        => 'nullable',
            'posted_by'     => 'required',
            'postal_code'   => 'nullable',
            'region_id'     => 'nullable',
            'telephone'     => 'nullable',
            'email'         => 'nullable',
            'website'       => 'nullable',
            'city_id'       => 'nullable',
            'publication_status'=> 'required',
            'published_at'  => 'nullable',
            'dates'         => 'required',
            'event_time'    => 'nullable',
            'organisation_id'    => 'nullable',
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

        $save = $event->update($data);
        // dd($event->organisation_id,$data);
        if($save){
            //We update user's wallet we make him/her spend the currency if is publishing
            // dd( intval($data['publication_status']) ,intval(@$event->purchased) );
            if( intval($data['publication_status']) === 1 && intval(@$event->purchased) === 0 ){
                $current_user->updateUserWallet(1,"events_price");
                $event->purchased = 1;
            }
            //Actions if an image is uploaded
            $owner = $event->owned()->select('name','prenom','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-',$owner->name)."_".str_replace(' ','-', $owner->prenom)."_".str_replace(' ','-',$owner->id);
            if($request->has('images')){
                $image = $request->file('images');
                $image_name = $event->slug.".".\File::extension($image->getClientOriginalName());
                $image_path = 'images/announcements';
                $save_images = $image->storeAs($image_path,$image_name,'public');
                $event->images = $image_name;
            }
            $event->save();

            return redirect()
                    ->back()
                    ->with('success',"Votre évènement a été modifié avec succès");
        }
        return redirect()
                    ->back()
                    ->with('error',"Il s'est produite une erreur");
    }
    /**
     * Delete event
     */
    public function delete(Event $event)
    {
        if($event) {
            $event->delete();
            return redirect()
                        ->route('admin.listevents')
                        ->with('success', "L'évènement a été supprimé");
        }
    }
}
