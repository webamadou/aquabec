<?php

namespace App\Http\Controllers\Backend\User;

use App\Forms\EventForm;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class EventController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:user']);
        $this->formBuilder = $formBuilder;
    }

    /**
     * @param Event|null $event
     * @return Form
     */
    private function getForm(?Event $event = null): Form
    {
        $event = $event ?: new Event();
        return $this->formBuilder->create(EventForm::class, [
            'model' => $event
        ]);
    }

    public function getCityByRegion($region_id)
    {
        $cities = City::where('region_id',$region_id)->get();
        return response()->json($cities);
    }

    public function getEventsData()
    {
        $events = Event::where('user_id',auth()->id())->get();

        return datatables()
            ->collection($events)
            ->editColumn('title',function ($item){
                return '<h5 class="font-weight-bold">'.$item->title.'</h5>';
            })
            ->addColumn('category',function ($item){
                return $item->category->name;
            })
            ->editColumn('image',function ($item){
                return '<img src="'.asset('storage/events/'.$item->image).'" class="img-circle mr-2" style="height:50px;width:50px" />';
            })
            ->addColumn('action',function ($item) {
                $edit_route = route('user.events.edit',$item);
                $delete_route = route('user.events.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action','image','title'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('user.events.index',);
    }

    public function create()
    {
        $form = $this->getForm();
        return view('user.events.create',compact('form'));
    }

    public function store(Request $request)
    {
        $form = $this->getForm();
        $form->redirectIfNotValid();

        $data = $form->getFieldValues();
        $user_id = auth()->id();
        $data = array_merge($data, compact('user_id'));

        $image = $request->file('image');

        $data['image'] = $image->store('events','public');

        $data['image'] = explode('/',$data['image'])[1];

        $image_resized_name = 'resized_'.$data['image'];

        $image_resized = Image::make($request->file('image'));

        $image_resized->fit(1200, 780);

        $image_resized->save(public_path('storage/events').'/'.$image_resized_name);

        Event::create($data);

        return redirect()->route('user.events.index')->with('success','Vous avez créé un évènement evec succès!');
    }
}
