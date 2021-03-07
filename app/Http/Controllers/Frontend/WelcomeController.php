<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Region;
use App\Models\Event;
use App\Models\Announcement;

class WelcomeController extends Controller
{
    public function welcomePage()
    {
		$user = Auth::user();
		$events = Event::where('publication_status','1')
							->orderby('published_at','desc')
							->limit(3)
							->get();
		$announcements = Announcement::where('publication_status','1')
							->orderby('published_at','desc')
							->limit(3)
							->get();
		$last_published = array_merge($events->all(), $announcements->all());
		//dd($last_published);
		shuffle($last_published);
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
     * Show annoucement
     */
    public function showAnnouncement(Announcement $announcement)
    {
        $current_user = auth()->user();
        //User can view annonce if is owner or publisher or announcement is validated and published
        //Later we will have to set gates or policies for this
        if(@$announcement->publication_status !== 1 && (@$current_user->id !== @$announcement->owner && @$current_user->id !== @$announcement->posted_by)){
            $message = "Ce contenu n'est pas encore disponible";
            return view('frontend.feedback',compact('message'));
        }
        $announcement->countViews();
        $announcement->countClicks();
        return view('frontend.show_announcement', compact('announcement','current_user'));
    }

    /**
     * Show event
     */
    public function showEvent(Event $event)
    {
        $current_user = auth()->user();
        //User can view annonce if is owner or publisher or event is validated and published
        //Later we will have to set gates or policies for this
        if(@$event->publication_status !== 1 && (@$current_user->id !== @$event->owner && @$current_user->id !== @$event->posted_by)){
            $message = "Ce contenu n'est pas encore disponible";
            return view('frontend.feedback',compact('message'));
        }
        $event->countViews();
        $event->countClicks();
        return view('frontend.show_event', compact('event','current_user'));
    }

	public function eventsRegion(Region $region)
	{
		$events = Event::where('region_id',$region->id)->where('publication_status','1')->get();
		$month_array = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
		return view('frontend.eventRegion', compact('region','events','month_array'));
	}

	public function announcementCategory(Category $category)
	{
		$announcements = Announcement::where('category_id',$category->id)->where('publication_status','1')->get();
		$month_array = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
		return view('frontend.announcementCategory', compact('category','announcements','month_array'));	
	}

	public function searchContent(Request $request)
	{
		$search_query 	= $request->search_q;
		$content_type 	= $request->content_type != 'evènement'?'annonce':'evènement';
		$model 			= $request->content_type != 'evènement'? new Announcement(): new Event;
		$response 		= $model->where("title","LIKE","%{$search_query}%")
										->where('publication_status','1')
										->get();
		$month_array = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
		return view('frontend.search', compact('response','content_type','search_query','month_array'));
	}

	public function page(\App\Models\Page $page)
	{
		return view('frontend.pages', compact('page'));
	}
}
