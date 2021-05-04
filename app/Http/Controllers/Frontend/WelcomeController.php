<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Region;
use App\Models\City;
use App\Models\Event;
use App\Models\Announcement;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Home page
     */
    public function welcomePage()
    {
		$user = Auth::user();
		/* $events = Event::where('publication_status','1')
							->orderby('published_at','desc')
							->limit(3)
							->get(); */
		$announcements = Announcement::where('publication_status','1')
                            ->where('lock_publication','!=',1)
							->orderby('published_at','desc')
							->limit(6)
							->get();
		$last_published = $announcements->all();
		/* shuffle($last_published); */
		$month_array = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
		$section_apropos 	= \App\Models\HomeSection::where('title','LIKE','%a propos%')->first();
		$section_comment 	= \App\Models\HomeSection::where('title','LIKE','%comment%')->first();

        return view('frontend.welcome', compact('last_published','month_array','section_apropos','section_comment'));
    }

    public function showProfile(\App\Models\User $user)
    {
        if($user->profile_status >1)
            return $this->notAvailable();
        $current_user = auth()->user();

        return view('frontend.user_profile', compact('user','current_user'));
    }

    /**
     * Show an annoucement page
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

        return view('frontend.show_announcement', compact('announcement','current_user'));
    }

    /**
     * Show an event page
     */
    public function showEvent(Event $event)
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
        return view('frontend.show_event', compact('event','current_user'));
    }

	public function eventsRegion(Region $region)
	{
		$events = Event::where('region_id',$region->id)
                        ->where('publication_status','1')
                        ->where('lock_publication','!=','1')
                        ->where('validated','1')
                        ->orderby("updated_at","desc")
                        ->paginate(12);

		$month_array    = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
        $categories     = \App\Models\Category::where('type','evènement')->pluck("name","slug");
        $cities         = \App\Models\City::where('region_id',$region->id)
                                            ->pluck("name","slug");

        return view('frontend.eventRegion', compact('region','events','month_array','cities','categories'));
	}

    public function announcementsCategoriesTable(Request $request,Category $category)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            $data = Announcement::where('category_id',$category->id)
                                ->where('publication_status','1')
                                ->where('lock_publication','!=','1')
                                ->where('validated','1');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('id',function ($row) {
                    return $row->id;
                })
                ->addColumn('updated_at',function ($row) {
                    return $row->updated_at;
                })
                ->addColumn('created_at',function ($row) {
                    return $row->created_at;
                })
                ->addColumn('title',function ($row) {
                    $event = \App\Models\Event::where('id',@$row->event_id)
                                                ->select('id','title','slug','images')
                                                ->first();
                    $event = $event?"<br><strong>Evenement</strong> : <a href='".route('user.show_announcement',$event->slug)."'>$event->slug</a>":'';
                    return '<a class="table-link-publication" href="'.route("user.show_announcement",$row->slug).'"> <img src="'.url("/voir/images/$row->images").'" alt="'.@$row->title.'" style="width:50px; height: auto"> <strong>'.$row->title.'</strong></a> '.$event;
                })
                ->addColumn("category_id", function($row){
                    return @$row->category->name;
                })
                ->addColumn('postal_code',function($row){
                    return $row->postal_code;
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
                    $edit_route = route('admin.edit_announcement',$row->id);
                    $delete_route = route('admin.delete_announcement',$row->id);
                    $modal_togglers = [
                        [
                            'name' => "Valider l'annonce classée",
                            'route' => route('admin.validation_announcement',$row->id),
                            'modal_title' => "Confirmer ou rejeter la validation de l'annonce <strong>$row->title</strong>"
                        ]
                    ];
                    return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route','modal_togglers'));
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
                        // dd($instance->toSql(), "%$postal_code%");
                    }
                    if ($request->get('title') != '') {
                        $title = $request->get('title');
                        $instance->where('title','LIKE', "%$title%");
                    }
                    if ($request->get('id') != '') {
                        $instance->where('id', $request->get('id'));
                    }
                    if ($request->get('updated_at') != '') {
                        $instance
                            ->where('updated_at','>=', $request->get('updated_at')." 00:00:00")
                            ->where('updated_at','<=', $request->get('updated_at')." 23:59:59" );
                    }
                    if ($request->get('created_at') != '') {
                        $instance
                            ->where('created_at','>=', $request->get('created_at')." 00:00:00")
                            ->where('created_at','<=', $request->get('created_at')." 23:59:59" );
                    }
                    if ($request->get('pub_type') != '') {
                        $instance->where('publication_status', $request->get('pub_type'));
                    }
                    if ($request->get('date_min') != '') {
                        $instance->where('published_at', '>=', date('Y-m-d', strtotime($request->get('date_min'))));
                    }
                    if ($request->get('date_max') != '') {
                        $instance->where('published_at', '<=', date('Y-m-d', strtotime($request->get('date_max'))));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('announcements.title', 'LIKE', "%$search%")
                                ->orWhere('announcements.id', 'LIKE', "%$search%");
                        });
                    }
                })
                ->order(function ($instance) use ($request){
                        $order = @$request->get('order')[0];
                        switch ($order['column']) {
                            case 0:
                                $instance->orderby('id', $order['dir'])
                                ->orderby('id','desc');
                                break;
                            case 1:
                                $instance->orderby('title', $order['dir'])
                                ->orderby('id','desc');
                                break;
                            
                            default:
                                $instance->orderby('id', $order['dir']);

                                break;
                        }
                        $instance
                            ->skip( @$request->get('start') )
                            ->take( @$request->get('length') );
                })
                ->rawColumns(['id','title','category_id','postal_code','owner','region_id','created_at','updated_at','action'])
                ->make(true);
        }

        $regions    = Region::select('name','id','region_number')->get();
        $cities     = City::orderby('name')->pluck('name','id');
        $categories = Category::where('type','annonce')->pluck('name','id');
        $regions    = Region::select('name','id','region_number')->get();
        $announcements = null;
        return view('frontend.announcementsTable', compact('user','announcements','cities','categories','regions','category'));
    }

	public function announcementCategory(Category $category)
	{
		$announcements = Announcement::where('category_id',$category->id)
                                    ->where('publication_status','1')
                                    ->where('lock_publication','!=','1')
                                    ->where('validated','1')
                                    ->paginate(12);

		$month_array = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
        $regions    = \App\Models\Region::pluck("name","slug");
        $cities     = \App\Models\City::pluck("name","slug");
        $categories = \App\Models\Category::where('type','annonce')->pluck("name","slug");

		return view('frontend.announcementCategory', compact('category','announcements','month_array',"regions","cities","categories"));	
	}

	public function searchContent(Request $request)
	{
		$search_query 	= $request->search_q;
		$content_type 	= $request->content_type != 'evènement'?'annonce':'evènement';
		$model 			= $request->content_type != 'evènement'? new Announcement(): new Event;
		$response 		= $model->where("title","LIKE","%{$search_query}%")
										->where('publication_status','1')
										->where('lock_publication','!=','1')
										->paginate(12);

		$month_array = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
		return view('frontend.search', compact('response','content_type','search_query','month_array'));
	}

	public function page(\App\Models\Page $page)
	{
		return view('frontend.pages', compact('page'));
	}

    /**
     * Function to filter Announcements
     */
    public function filterAnnouncements(Request $request)
    {
        $components = '';
        if($request->get('type') === 'announcements'){
            $announcements = DB::table($request->get('type'));
            if( trim($request->get("region_id")) != "" ){
                $region = Region::where( 'slug',$request->get('region_id') )
                                ->select('id')
                                ->first();
                $announcements->where( 'announcements.region_id', $region->id );
            }
            if( trim($request->get("city_id")) != "" ){
                $city = City::where( 'slug',$request->get('city_id') )
                                ->select('id')
                                ->first();
                $announcements->where('announcements.city_id',$city->id );
            }
            if( trim($request->get("category_id")) != "" ){
                $categ = Category::where( 'slug',$request->get('category_id') )
                                ->select('id')
                                ->first();
                $announcements->where('announcements.category_id',$categ->id);
                //echo $categ->id.' '.$request->get("category_id").' '.$announcements->toSql();
            }
            if( trim($request->get("postal_code")) != "" ){
                $announcements->where( 'announcements.postal_code','LIKE','%'.$request->get('postal_code').'%' );
            }
            if( trim($request->get("price")) != "" ){
                $announcements->where( 'announcements.price','>=', intval($request->get('price')) );
            }
            if( trim($request->get("user")) != "" ){
                $user = \App\Models\User::where("slug",'LIKE','%'.$request->get('user').'%' )
                            ->select('id')
                            ->first();
                $announcements->where( 'announcements.owner', @$user->id );
            }
            if( trim($request->get("title")) != "" ){
                $announcements->where('announcements.title','LIKE','"%'.$request->get('title').'%"' );
            }

            $components = $announcements
                            ->join('categories', 'announcements.category_id','=','categories.id')
                            ->join('users', 'announcements.owner','=','users.id')
                            ->select( 'announcements.title', 'announcements.slug', 'announcements.images', 'announcements.price', 'announcements.price_type', 'categories.name as categ_name','users.username as owner' )
                            ->get();
            
            /* $announcements = Announcement::where('category_id',$category->id)
                                    ->where('publication_status','1')
                                    ->where('lock_publication','!=','1')
                                    ->where('validated','1')
                                    ->paginate(12); */
        }
        return response()->json($components   , 200);
    }

    /**
     * Function to filter Events
     */
    public function filterEvents(Request $request)
    {
        $components = '';
        if($request->get('type') === 'events'){
            $events = DB::table($request->get('type'));
            if( trim($request->get("region_id")) != "" ){
                $events->where( 'events.region_id', $request->get("region_id") );
            }
            if( trim($request->get("city_id")) != "" ){
                $city = City::where( 'slug',$request->get('city_id') )
                                ->select('id')
                                ->first();
                $events->where('events.city_id',$city->id );
            }
            if( trim($request->get("category_id")) != "" ){
                $categ = Category::where( 'slug',$request->get('category_id') )
                                ->select('id')
                                ->first();
                $events->where('events.category_id',$categ->id);
            }
            if( trim($request->get("postal_code")) != "" ){
                $events->where( 'events.postal_code','LIKE','%'.$request->get('postal_code').'%' );
            }
            if( trim($request->get("dates")) != "" ){
                $date = date( 'Y-m-d', strtotime( $request->get('dates') ) );
                $events->where( 'events.dates','LIKE', '%'.$date.'%' );
            }
            if( trim($request->get("user")) != "" ){
                $user = \App\Models\User::where("slug",'LIKE','%'.$request->get('user').'%' )
                            ->select('id')
                            ->first();
                $events->where( 'events.owner', @$user->id );
            }
            if( trim($request->get("title")) != "" ){
                $events->where('events.title','LIKE','"%'.$request->get('title').'%"' );
            }
            /* echo $events
                        ->join('categories', 'events.category_id','=','categories.id')
                        ->join('users', 'events.owner','=','users.id')
                        ->select( 'events.title', 'events.slug', 'events.images', 'event_dates.event_date as dates', 'categories.name as categ_name','users.username as owner' )
                        ->toSql(); */

            $components = $events
                            ->join('categories', 'events.category_id','=','categories.id')
                            ->join('users', 'events.owner','=','users.id')
                            ->select( 'events.title', 'events.slug', 'events.images', 'events.dates', 'categories.name as categ_name','users.username as owner' )
                            ->get();
        }
        return response()->json($components   , 200);
    }

    public function test(Request $request){
        return view('test');
    }
}
