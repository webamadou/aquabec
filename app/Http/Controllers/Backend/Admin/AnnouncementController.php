<?php
namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Region;
use App\Models\City;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['role:admin|super-admin']);
    }

    /**
     * list anoucements of current announcements
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            $data = Announcement::where('publication_status','<',2);
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
                        $validation_status = intval($row->validated) === 1?'<span class="badge badge-success"><i class="fa fa-check"></i> Validée</span>':(intval($row->validated > 1)?'<span class="badge badge-danger">Rejetée</span>':'<span class="badge badge-primary">Validation en attente</span>');
                        return $validation_status."<br>".$annonce_status;
                    })
                    ->addColumn('id',function ($row) {
                        return $row->id;
                    })
                    ->addColumn('title',function ($row) {
                        $event = \App\Models\Event::where('id',@$row->event_id)
                                                    ->select('id','title','slug','images')
                                                    ->first();
                        $event = $event?"<br><strong>Evenement</strong> : <a href='".route('user.show_announcement',$event->slug)."'>$event->slug</a>":'';
                        return '<a href="'.url("/admin/announcement/$row->id").'"> <img src="'.url("/voir/images/$row->images").'" alt="'.@$row->title.'" style="width:50px; height: auto"> <strong>'.$row->title.'</strong></a> '.$event;
                    })
                    ->addColumn("category_id", function($row){
                        return @$row->category->name;
                    })
                    ->addColumn('price',function($row){
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
                        }
                        if ($request->get('price_type') == '3' || $request->get('price_type') == '2') {
                           $instance->where('price_type', $request->get('price_type'));
                        }
                        if ($request->get('price_min') != '' && $request->get('price_max') != '' ) {
                           $instance->where('price','>=', $request->get('price_min'))->where('price','<=', $request->get('price_max'));
                        }
                        if ($request->get('price_min') != '' && $request->get('price_max') == '' ) {
                           $instance->where('price','>=', $request->get('price_min'));
                        }
                        if ($request->get('price_min') == '' && $request->get('price_max') != '' ) {
                           $instance->where('price','<=', $request->get('price_max'));
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
                                case 2:
                                    $instance->orderby('category_id', $order['dir'])
                                    ->orderby('id','desc');
                                    break;
                                case 3:
                                    $instance->orderby('price', $order['dir'])
                                    ->orderby('id','desc');
                                    break;
                                case 4:
                                    $instance->orderby('owner', $order['dir'])
                                    ->orderby('id','desc');
                                    break;
                                case 5:
                                    $instance->orderby('region_id', $order['dir']
                                    ->orderby('city_id', $order['dir'])
                                    ->orderby('id','desc'));
                                    break;
                                case 6:
                                    $instance->orderby('owner', $order['dir'])
                                    ->orderby('id','desc');
                                    break;
                                
                                default:
                                    $instance->orderby('id', "desc")
                                    ->orderby('id','desc');
                                    break;
                            }
                            $instance
                                ->skip( @$request->get('start') )
                                ->take( @$request->get('length') );
                    })
                    ->rawColumns(['id','title','category_id','price','owner','region_id','publication','action'])
                    ->make(true);
        }
        
        //$form       = $this->getForm();
        $regions    = Region::pluck('name','id');
        $cities     = City::orderby('name')->pluck('name','id');
        $categories = Category::pluck('name','id');
        $regions    = \App\Models\Region::pluck('name','id');
        $announcements = null;

        return view('admin.announcements.index', compact('user','announcements','cities','categories','regions'));
    }
    /*
     * Get current user announcements data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myAnnouncementsData()
    {
        $user = auth()->user();
        $announcement = Announcement::with('owned','posted','category','region','city')
                                    ->orderby('validated','asc')
                                    ->get();
        return datatables()
            ->collection($announcement)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.edit_announcement',$item);
                $delete_route = route('admin.delete_announcement',$item);
                $modal_togglers = [
                    [
                        'name' => "Valider l'annonce classée",
                        'route' => route('admin.validation_announcement',$item),
                        'modal_title' => "Confirmer ou rejeter la validation de l'annonce <strong>$item->title</strong>"
                    ]
                ];
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route','modal_togglers'));
            })
            ->rawColumns(['action'])
            ->make(true);
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
        $role_currency = $user->mainRole()->currency;
        $user_events = $user->getUnlinkedEvents()->pluck("events.title","events.id")->all();

        $announcement = new Announcement();
        $announcement->postal_code = @$user->postal_code;
        $announcement->email       = @$user->email;
        $announcement->telephone   = @$user->num_tel;

        return view('admin.announcements.add_announcement',compact('announcement','categories','regions','cities','status','children','user','can_post','role_currency','user_events'));
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
            $owner = $save_announcement->owned()->select('name','prenom','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-',$owner->name)."_".str_replace(' ','-', $owner->prenom)."_".str_replace(' ','-',$owner->id);
            if($request->has('images')){
                $image = $request->file('images');
                $image_name = $save_announcement->slug.".".\File::extension($image->getClientOriginalName());
                $image_path = 'images/announcements';
                $save_announcement_images = $image->storeAs($image_path,$image_name,'public');
                $save_announcement->images = $image_name;
            }
            $save_announcement->save();

            if(@$data['event_id'] !== null && @$data['event_id'] !== ""){
                return redirect()
                        ->route('admin.announcements')
                        ->with('success',"L'annonce a été enregistrée avec succès");
            } else {
                $save_announcement->lock_publication = 1;
                $save_announcement->save();
                $annoucement_id = $save_announcement->id;
                return redirect()
                        ->route('admin.create_event',$save_announcement)
                        ->with('success',"Votre annonce a été enregistrée avec succès");
            }
        }
        return redirect()->back();
    }

    /**
     * Validation announcement
     */
    public function validation(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'validated' => 'required',
            'rejection_reasons' => 'nullable'
            ]);
        
        $announcement->validated = $data['validated'];
        $announcement->rejection_reasons = $data['rejection_reasons'];
        $announcement->validated_by = auth()->user()->id;
        $announcement->validated_at = date('Y-m-d H:i:s');
        $announcement->save();
        $message = "L'annonce a été validée";
        if($announcement->validated > 1){
            $message = "L'annonce à été rejetée";
        }
        //dd($announcement->id,$announcement->title,@$data);
        return redirect()
                    ->back()
                    ->with('success', $message);
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
        return view('admin.announcements.show_announcement', compact('announcement','current_user'));
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
        $children   = $user->godchildren()->select('name','prenom','email','id')->get();
        $role_currency = $user->mainRole()->currency;
        //Check if user has enough credit
        $can_post   = $user->userHasEnoughCredit('annoucements_price','paid_currency');
        $user_events = $user->getUnlinkedEvents()->pluck("events.title","events.id")->all();

        $announcement->postal_code = trim($announcement->postal_code) === ""?$user->postal_code:@$announcement->postal_code;
        $announcement->email       = trim($announcement->email) === ""?$user->email:@$announcement->email;
        $announcement->telephone   = trim($announcement->telephone) === ""?$user->num_tel:@$announcement->telephone;

        return view('admin.announcements.edit_announcement',compact('announcement','categories','regions','cities','status','children','user','role_currency','can_post','user_events'));
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
            $owner = $announcement->owned()->select('name','prenom','id')->first() ;
            //Each user has a folder where to save image and other eventual files
            $user_folder = str_replace(' ','-',$owner->name)."_".str_replace(' ','-', $owner->prenom)."_".str_replace(' ','-',$owner->id);
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
                        ->route('admin.create_event',$announcement)
                        ->with('success',"Votre annonce a été modifiée avec succès. Vous devez maintenant la lier à un événement");
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
            //The publication is not trully deleted but rather hidden
            $announcement->publication_status = 4;
            $announcement->delete();
            return redirect()
                        ->route('admin.announcements')
                        ->with('success', "L'annonce a été supprimée");
        }
        return redirect()
                        ->route("admin.announcements");
    }
}
