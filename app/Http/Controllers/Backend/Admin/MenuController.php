<?php
namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Menu ;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Str;
use App\Forms\MenuForm;

class MenuController extends Controller
{
    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin']);
        $this->formBuilder = $formBuilder;
    }
    
    /*
     * Get credit data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function menusData()
    {
        $menus = Menu::all();
        return datatables()
            ->collection($menus)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.settings.menus.edit',$item);
                $delete_route = route('admin.settings.menus.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * 
     */
    private function getForm(?Menu $menu = null): Form
    {
        $menu = $menu ?: new Menu();
        return $this->formBuilder->create(MenuForm::class, [
            'model' => $menu
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model  = new Menu();
        $form   = $this->getForm();
        $current_user = auth()->user();
        $menus = Menu::all();
        return view('admin.menus.index',compact('form','current_user','menus'));
    }
    public function create()
    {
        return view('admin.menus.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required',
            'parent'    => 'nullable',
            'visible'   => 'nullable',
            'public'    => 'nullable',
            'roles'     => 'nullable',
        ]);
        //$form->redirectIfNotValid();
        // dd($data);
        $menu = Menu::create($data);

        return redirect()
                    ->back()
                    ->with('success','Le nouveau menu a été créé avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $form = $this->getForm($menu);
        return view("admin.menus.index",compact('form','menu'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name'      => 'required',
            'parent'    => 'nullable',
            'visible'   => 'nullable',
            'public'    => 'nullable',
            'roles'     => 'nullable',
        ]);
        $data['visible'] = intval(@$data['visible'])>= 1?1:0;
            // dd($data);
        $menu->update($data);
        return redirect()->route('admin.settings.menus.index')->with('success','Le menu a été mis à jour avec succès!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if($menu){
            $menu->delete();
            return redirect()->back()->with('success','Le menu a été supprimé avec succès!');
        }
        return redirect()->back()->with('error','Le menu est introuvable');
    }
}
