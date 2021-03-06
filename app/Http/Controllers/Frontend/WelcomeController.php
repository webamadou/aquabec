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
		shuffle($last_published);
		$mont_array = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
		$section_apropos 	= \App\Models\HomeSection::where('title','LIKE','%a propos%')->first();
		$section_comment 	= \App\Models\HomeSection::where('title','LIKE','%comment%')->first();

        return view('frontend.welcome', compact('last_published','mont_array','section_apropos','section_comment'));
    }

	public function eventsRegion(Region $region)
	{
		$events = Event::where('region_id',$region->id)->where('publication_status','1')->get();
		return view('frontend.eventRegion', compact('region','events'));
	}

	public function announcementCategory(Category $category)
	{
		$announcements = Announcement::where('category_id',$category->id)->where('publication_status','1')->get();
		return view('frontend.announcementCategory', compact('category','announcements'));	
	}

	public function searchContent(Request $request)
	{
		$search_query 	= $request->search_q;
		$content_type 	= $request->content_type != 'evènement'?'annonce':'evènement';
		$model 			= $request->content_type != 'evènement'? new Announcement(): new Event;
		$response 		= $model->where("title","LIKE","%{$search_query}%")
										->where('publication_status','1')
										->get();
		$mont_array = ['','Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Dec'];
		return view('frontend.search', compact('response','content_type','search_query','mont_array'));
	}

	public function page(\App\Models\Page $page)
	{
		return view('frontend.pages', compact('page'));
	}
}
