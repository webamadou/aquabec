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
}
