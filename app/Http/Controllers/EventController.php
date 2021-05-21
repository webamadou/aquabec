<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

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
        $this->middleware('auth',['role:vendeur|annonceur|super-admin|admin']);
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
            $data = Event::where('publication_status','<=',3)
                            ->where('posted_by',$user->id)
                            ->select('id','images','title','region_id','dates','city_id','organisation_id','owner','slug','posted_by','category_id','publication_status','created_at','updated_at')
                            ->with('region','city','organisation','owned','posted','category');
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
                    ->addColumn('id',function ($row) {
                        return $row->id;
                    })
                    ->addColumn('title',function ($row) {
                        return '<a href="'.route("user.show_event",$row->slug).'" class="table-link-publication"><img src="'.url("/voir/images/$row->images").'" alt="'.@$row->title.'" style="width:50px; height: auto"><strong>'.$row->title.'</strong></a>';
                    })
                    ->addColumn("organisation", function($row){
                        return @$row->organisation->name;
                    })
                    ->addColumn('dates',function($row){
                        $dates = $row->event_dates;
                        $dates_string = '<div class="collapsable-dates" id="date-'.$row->slug.'">';
                        if($dates){
                            $i = 0;
                            foreach ($dates as $key => $date) {
                                ++$i;
                                if(trim($date->event_date) != "")
                                    $dates_string .= '<span class="badge badge-primary text-sm d-block my-1 font-weight-normal"> '.date('Y-m-d', strtotime($date->event_date)).'</span> ';
                            }
                            $uncollapse = $i > 1?'<span class="uncolapser" data-item="'.$row->slug.'"><i class="fa fa-folder-open"></i><u class="d-none">'.$i.'</u></span>':$i;
                            return $dates_string.$uncollapse.'</div>';
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
                    ->addColumn('created_at', function($row){
                        return @$row->created_at;
                    })
                    ->addColumn('updated_at', function($row){
                        return @$row->updated_at;
                    })
                    ->addColumn('category_id', function($row){
                        return @$row->category->name;
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
                        if ($request->get('date_min') != '') {
                            $dates = date( 'Y-m-d', strtotime($request->get('date_min')) );
                            $instance
                                /* ->join('event_dates','events.id','=','event_dates.event_id') */
                                ->where('events.dates','LIKE', "%".$dates."%");
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
                        if ($request->get('filter_id') != '') {
                            $instance->where('id', $request->get('filter_id'));
                        }
                        if ($request->get('created_at') != '') {
                            $date_min = $request->get('created_at').' 00:00:00';
                            $date_max = $request->get('created_at').' 23:59:59';
                            $instance->where('created_at', '>=',$date_min)
                                    ->where('created_at', '<=',$date_max);
                        }
                        if ($request->get('updated_at') != '') {
                            $date_min = $request->get('updated_at').' 00:00:00';
                            $date_max = $request->get('updated_at').' 23:59:59';
                            $instance->where('updated_at', '>=',$date_min)
                                    ->where('updated_at', '<=',$date_max);
                        }
                        if ($request->get('filter__date') != '') {
                            $dates = $request->get('filter__date');
                            $instance->where('dates','LIKE', "%$dates%");
                        }
                        if ($request->get('owner') != '') {
                            $instance->where('dates', $request->get('owner'));
                        }
                        if ($request->get('filter_title') != '') {
                            $title = $request->get('filter_title');
                            $instance->where('title','LIKE', "%$title%");
                        }
                        /* if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                               $search = $request->get('search');
                               $w->orWhere('title', 'LIKE', "%$search%")
                                    ->orWhere('dates', 'LIKE', "%$search%")
                                    ->orWhere('id', 'LIKE', "%$search%");
                           });
                        } */
                    })
                    ->order(function ($instance) use ($request){
                            $order = @$request->get('order')[0];
                            switch ($order['column']) {
                                case 0:
                                    $instance->orderby('events.id', $order['dir']);
                                    break;
                                case 1:
                                    $instance->orderby('events.title', $order['dir']);
                                    break;
                                case 2:
                                    $instance
                                        ->join('event_dates','event_dates.event_id','=','events.id')
                                        ->orderby('event_dates.event_date', $order['dir']);
                                    break;
                                case 3:
                                    $instance->orderby('events.region_id', $order['dir'])
                                                ->orderby('events.city_id', $order['dir']);
                                    break;
                                case 4:
                                    $instance->orderby('events.owner', $order['dir']);
                                    break;
                                /* case 5:
                                    $instance->orderby('region_id', $order['dir'])
                                                ->orderby('city_id', $order['dir']);
                                    break; */
                                case 6:
                                    $instance->orderby('events.publication_status', $order['dir']);
                                    break;
                                
                                default:
                                    $instance->orderby('events.updated_at', "desc");
                                    break;
                            }
                            $instance
                                /* ->join('event_dates','event_dates.event_id','=','events.id')
                                ->groupby('events.id') */
                                ->skip( @$request->get('start') )
                                ->take( @$request->get('lenght') );
                            
                            // echo $instance->join('event_dates','event_dates.event_id','=','events.id')->groupby('events.id')->toSql();
                    })
                    ->rawColumns(['id','title','organisation','dates','owner','region_id','publication','action','created_at','updated_at'])
                    ->make(true);
        }
        
        //$form       = $this->getForm();
        $regions    = Region::pluck('name','id');
        $cities     = City::orderby('name')->pluck('name','id');
        $organisations = \App\Models\Organisation::pluck('name','id');
        $categories = Category::where('type','!=','annonce')->pluck('name','id');
        $regions    = \App\Models\Region::select('name','id','region_number')->get();
        $announcements = null;
        $list_users = $user->recipientList()
                        ->orderby('username')
                        ->select('id','name','prenom','username')
                        ->get();
        if($user->hasAnyRole(['vendeur','chef-vendeur','annonceur'])){
            return view('events.index', compact('user','announcements','regions','cities','organisations','categories','list_users'));
        }elseif ($user->hasAnyRole(['super-admin','admin'])) {
            return view('events.index_admins', compact('user','announcements','regions','cities','organisations','categories','list_users'));
        }
    }

    /** *** EVENTS METHODS *** */
    /**
     * List events
     */
    public function myEventsData()
    {
        $user = auth()->user();
        $events = $user->myEvents()->with('owned','posted','category','region','city')->get();
        return datatables()
            ->collection($events)
            ->addColumn('action',function ($item) {
                $edit_route = "#";

                return view('layouts.back.datatables.actions-btn',compact('edit_route'));
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

        return view('events.my_events', compact('user','events'));
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
        $children   = $user->godchildren()
                            ->where('profile_status','<=',1)
                            ->select('username','id')
                            ->get();
        $role_currency = $user->mainRole()->currency;
        //Check if user has enough credit
        $can_post   = $user->userHasEnoughCredit('events_price','free_currency');

        $event = new Event();
        $event->postal_code = @$user->postal_code;
        $event->email       = @$user->email;
        $event->telephone   = @$user->num_tel;
        $organisations      = \App\Models\Organisation::pluck("name","id");

        return view('events.add_event',compact('event','announcement','categories','regions','cities','status','children','user','role_currency','can_post',"organisations"));
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
        //21-04-09*09:30;21-04-10*09:30;21-04-16*09:30;
        // dd($data);
        // $date['dates'] = explode(";",$date['dates']);
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
        $data['dates'] = str_replace("*", " ", $data['dates']);
        $event_dates = explode(";",$data['dates']);//Save the dates in an array
        // unset($data['dates']);

        $save_event = Event::create($data);//save data
        if($save_event){
            foreach ($event_dates as $key => $date) {
                if(trim($date) != ""){
                    \App\Models\EventDate::create( [
                        'event_id'      => $save_event->id,
                        'event_date'    => date('Y-m-d H:i:s', strtotime($date) ) 
                    ] );
                }
            }
            //We update user's wallet we make him/her spend the currency if is publishing
            if(intval($data['publication_status']) === 1 ){
                $save_event->published_at = date('Y-m-d H:i:s');
                //We update user's wallet we make him/her spend the currency
                $current_user->updateUserWallet(1,"events_price");
                $save_event->purchased = 1;
            }
            //Actions if an image is uploaded
            $owner = $save_event->owned()->select('username','prenom','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-',$owner->username).str_replace(' ','-',$owner->id);
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
                    ->route('user.my_announcements')
                    ->with('success',"Votre évènement a été enregistré et relier à l'annonce");
            }
            return redirect()
                    ->route('user.my_events')
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
        return view('events.show_event', compact('event','current_user'));
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
        $children   = $user->godchildren()
                        ->where("profile_status",'<=',1)
                        ->select('username','id')
                        ->get();
        $role_currency = $user->mainRole()->currency;
        //Check if user has enough credit
        $can_post       = $user->userHasEnoughCredit('events_price','free_currency');
        $announcement   = Announcement::where('event_id',$event->id)->first();

        $event->postal_code = trim($event->postal_code) === ""?$user->postal_code:@$event->postal_code;
        $event->email       = trim($event->email) === ""?$user->email:@$event->email;
        $event->telephone   = trim($event->telephone) === ""?$user->num_tel:@$event->telephone;
        $organisations      = \App\Models\Organisation::pluck("name","id");

        return view('events.edit_event',compact('event','categories','regions','cities','status','children','user','can_post','role_currency','announcement','organisations'));
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
        $event_dates = explode(";",str_replace("*", " ", $data['dates']));//Save the dates in an array
        // unset($data['dates']);

        $save = $event->update($data);

        if($save){
            foreach ($event_dates as $key => $date) {
                if(trim($date) != ""){
                    \App\Models\EventDate::updateOrCreate( [
                        'event_id'      => $event->id,
                        'event_date'    => date('Y-m-d H:i:s', strtotime($date) ) 
                    ] );
                }
            }
            //We update user's wallet we make him/her spend the currency if is publishing
            if( intval($data['publication_status']) === 1 && intval(@$event->purchased) === 0 ){
                $current_user->updateUserWallet(1,"events_price");
                $event->purchased = 1;
            }
            //Actions if an image is uploaded
            $owner = $event->owned()->select('username','id')->first() ;
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
                        ->route('user.my_events')
                        ->with('success', "L'évènement a été supprimé");
        }
    }
}
