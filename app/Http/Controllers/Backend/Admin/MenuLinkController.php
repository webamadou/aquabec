<?php
namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MenuLink;
use App\Models\Menu ;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Str;
use App\Forms\MenuLinkForm;

class MenuLinkController extends Controller
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
        $menus = MenuLink::with('menu','page')->get();
        return datatables()
            ->collection($menus)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.settings.menu_links.edit',$item);
                $delete_route = route('admin.settings.menu_links.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * 
     */
    private function getForm(?MenuLink $menu_link = null): Form
    {
        $menu_link = $menu_link ?: new MenuLink();
        return $this->formBuilder->create(MenuLinkForm::class, [
            'model' => $menu_link
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model  = new MenuLink();
        $form   = $this->getForm();
        $current_user = auth()->user();
        $menus = MenuLink::orderby('updated_at','desc')->get();
        // dd($menus[0]->page->id);
        return view('admin.menulinks.index',compact('form','menus'));
    }
    public function create()
    {
        return view('admin.menulinks.index');
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
            'menu_id'   => 'nullable',
            'page_id'   => 'nullable',
            'custom_url'=> 'nullable',
        ]);
        $data["url"] = "";
        if(@$data["page_id"] != ""){
            $page = \App\Models\Page::find(@$data["page_id"]);
            if($page){
                $data["url"] = url('/')."/pages/".$page->slug;  
            }
        }
        if(@$data["costum_url"] != ""){
            $data["url"] = @$data["costum_url"];
            unset($data['costum_url']);
        }

        $menu = MenuLink::create($data);

        return redirect()
                    ->back()
                    ->with('success','Le nouveau lien a été créé avec succès!');
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
    public function edit(MenuLink $menu_link)
    {
        $form = $this->getForm($menu_link);
        return view("admin.menulinks.index",compact('form','menu_link'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuLink $menu_link)
    {
        $data = $request->validate([
            'name'      => 'required',
            'menu_id'   => 'nullable',
            'page_id'   => 'nullable',
            'custom_url'=> 'nullable',
        ]);
        $data["url"] = "";
        if(@$data["page_id"] != ""){
            $page = \App\Models\Page::find(@$data["page_id"]);
            if($page){
                $data["url"] = url('/')."/pages/".$page->slug;  
            }
        }
        if(@$data["costum_url"] != ""){
            $data["url"] = @$data["costum_url"];
            unset($data['costum_url']);
        }

        $menu_link->update($data);
        return redirect()->route('admin.settings.menu_links.index')->with('success','Le lien a été mis à jour avec succès!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuLink $link)
    {
        if($link){
            $link->delete();
            return redirect()->back()->with('success','Le lien a été supprimé avec succès!');
        }
        return redirect()->back()->with('error','Le lien est introuvable');
    }
}
