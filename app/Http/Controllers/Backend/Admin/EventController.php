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
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

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
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            $data = Event::where('publication_status','<',2);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('publication',function ($row) {
                        $annonce_status = "";
                        if($row->lock_publication)
                            return '<span class="badge badge-warning position-relative"><span class="text-danger"><i class="fa fa-ban"></i></span> Publication bloquée: ';
                        switch (intval($row->publication_status)){
                            case 0:
                                $annonce_status = '<span class="badge badge-warning font-bold">Bouillon</span>';
                                break;
                            case 1:
                                $annonce_status = '<span class="badge badge-success font-bold">Publiée</span>';
                                break;
                            case 2:
                                $annonce_status = '<span class="badge badge-primary font-bold">Privée</span>';
                                break;
                            case 4:
                                $annonce_status = '<span class="badge badge-danger font-bold">Suprimée</span>';
                                break;
                        
                            default:
                                break;
                        }
                        $validation_status = intval($row->validated) === 1?'<span class="badge badge-success"><i class="fa fa-check"></i> Validé</span>':(intval($row->validated > 1)?'<span class="badge badge-danger">Rejeté</span>':'<span class="badge badge-primary">Validation en attente</span>');
                        return $validation_status."<br>".$annonce_status;
                    })
                    ->addColumn('title',function ($row) {
                        return '<a href="'.url("/admin/event/$row->id").'"><img src="'.url("/voir/images/$row->images").'" alt="'.@$row->title.'" style="width:50px; height: auto"><strong>'.$row->title.'</strong></a>';
                    })
                    ->addColumn("organisation", function($row){
                        return @$row->organisation->name;
                    })
                    ->addColumn('dates',function($row){
                        $dates = $row->event_dates;
                        $dates_string = "";
                        if($dates){
                            foreach ($dates as $key => $date) {
                                if(trim($date->event_date) != "")
                                    $dates_string .= '<span class="badge badge-primary text-sm d-block my-1 font-weight-normal"> '.date('d-m-Y H:i', strtotime($date->event_date)).'</span> ';
                            }
                            return $dates_string;
                        }
                        $prix = intval($row->price_type) === 1? '$'.number_format($row->price,2,'.',''):(intval($row->price_type) === 3?"Gratuit":"Échange");
                        return $prix;
                    })
                    ->addColumn('owner', function($row){
                        $retour = $row->owned?$row->owned->username:"";
                        if($row->owned->id !== $row->posted->id)
                            $retour .= '<br><strong> Postée par :'. @$row->posted->username.'</strong>';

                        return $retour;
                    })
                    ->addColumn('region_id', function($row){
                        return '<strong>Region : </strong>'.@$row->region->name.'<br><strong>Ville : </strong>'.@$row->city->name;
                    })
                     ->addColumn('action',function ($row) {
                        $edit_route = route("admin.edit_event",$row->id);
                        $modal_togglers = [
                            [
                                'name' => "Valider l'événement",
                                'route' => route('admin.validation_event',$row->id),
                                'modal_title' => "Confirmer ou rejeter la validation de l'événement <strong>$row->title</strong>"
                            ]
                        ];

                        return view('layouts.back.datatables.actions-btn',compact('edit_route','modal_togglers'));
                    })
                   ->filter(function ($instance) use ($request) {
                        if ($request->get('region_id') != '') {
                           $instance->where('region_id', $request->get('region_id'));
                        }
                        if ($request->get('city_id') != '') {
                           $instance->where('city_id', $request->get('city_id'));
                        }
                        if ($request->get('filter_categ_id') != '') {
                           $instance->where('category_id', $request->get('filter_categ_id'));
                        }
                        if ($request->get('postal_code') != '') {
                            $postal_code = $request->get('postal_code');
                           $instance->where('postal_code','LIKE', "%$postal_code%");
                        }
                        if ($request->get('price_type') == '3' || $request->get('price_type') == '2') {
                           $instance->where('price_type', $request->get('price_type'));
                        }
                        if ($request->get('organisateur') != '' ) {
                           $instance->where('organisation_id','<=', $request->get('organisateur'));
                        }
                        if ($request->get('pub_type') != '') {
                           $instance->where('publication_status', $request->get('pub_type'));
                        }
                        if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                               $search = $request->get('search');
                               $w->orWhere('title', 'LIKE', "%$search%");
                           });
                        }
                   })
                   ->rawColumns(['title','organisation','dates','owner','region_id','publication','action'])
                   ->make(true);
        }
        $data = Event::where('publication_status','<',2);
        
        //$form       = $this->getForm();
        $regions    = Region::pluck('name','id');
        $cities     = City::orderby('name')->pluck('name','id');
        $organisations = \App\Models\Organisation::pluck('name','id');
        $categories = Category::pluck('name','id');
        $regions    = \App\Models\Region::pluck('name','id');
        $announcements = null;

        return view('admin.events.index', compact('user','announcements','regions','cities','organisations','categories'));
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
                    $announcement->lock_publication = 0;
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
            //Before deletion we need to get the event announcement if any, and update the values.
            $announcement = $event->announcement ;
            if($announcement){
                $announcement->lock_publication = 1 ;
                $announcement->event_id = null;
                $announcement->save();
            }
            $event->delete();
            return redirect()
                        ->route('admin.listevents')
                        ->with('success', "L'évènement a été supprimé");
        }
    }
}
