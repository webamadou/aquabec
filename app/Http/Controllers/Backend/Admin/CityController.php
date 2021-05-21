<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Forms\CityForm;
use App\Http\Controllers\Controller;

use App\Models\City;
use App\Models\User;
use App\Models\Event;
use App\Models\Announcement;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\Datatables\Datatables;

class CityController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin']);
        $this->formBuilder = $formBuilder;
    }

    public function citiesData()
    {
        $cities = City::all();

        return datatables()
            ->collection($cities)
            ->addColumn('full_name',function ($role) {
                if ($role->prefix) {
                    return $role->name . ' (' . $role->prefix . ')';
                }
                return $role->name;
            })
            ->addColumn('region',function ($role) {
                return $role->region->name;
            })
            ->addColumn('action',function ($role) {
                $edit_route = route('admin.settings.cities.edit',$role);
                $delete_route = route('admin.settings.cities.destroy',$role);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param City|null $city
     * @return Form
     */
    private function getForm(?City $city = null): Form
    {
        $city = $city ?: new City();
        return $this->formBuilder->create(CityForm::class, [
            'model' => $city
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
          $data = City::select('*');
           return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('full_name',function ($row) {
                        if ($row->prefix) {
                            return $row->name . ' (' . $row->prefix . ')';
                        }
                        return $row->name;
                    })
                    ->addColumn('action',function ($row) {
                        $edit_route = route('admin.settings.cities.edit',$row->id);
                        $delete_route = route('admin.settings.cities.destroy',$row->id);
                        return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
                    })
                    ->addColumn('region',function ($role) {
                        return $role->region->name;
                    })
                   ->filter(function ($instance) use ($request) {
                       if ($request->get('region_id') != '') {
                           $instance->where('region_id', $request->get('region_id'));
                       }
                       if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                               $search = $request->get('search');
                               $w->orWhere('name', 'LIKE', "%$search%");
                           });
                       }
                   })
                   ->rawColumns(['status'])
                   ->make(true);
        }
        
        $form = $this->getForm();
        $regions = \App\Models\Region::pluck('name','id'); 
        return view('admin.cities.index',compact('form','regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $form = $this->getForm();
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        $slug = Str::slug($form->getFieldValues()['prefix'].'-'.$form->getFieldValues()['name']);
        $data = array_merge($data,compact('slug'));

        City::create($data);

        return redirect()->route('admin.settings.cities.index')->with('success','Une ville a été créée avec succès!');
    }
}
