<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\Datatables\Datatables;

use App\Models\Page;
use App\Forms\PageForm;
use App\Models\HomeSection;
use App\Models\MenuLink;
use App\Models\Menu;
use App\Models\Faq_group;
use App\Models\Faq;

class PageController extends Controller
{
    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin'],['except' => ['creditsTransfer']]);
        $this->formBuilder = $formBuilder;
    }

    /*
     * Get credit data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagesData()
    {
        $pages = Page::all();
        return datatables()
            ->collection($pages)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.settings.pages.edit',$item);
                $delete_route = route('admin.settings.pages.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * 
     */
    private function getForm(?Page $page = null): Form
    {
        $page = $page ?: new Page();
        return $this->formBuilder->create(PageForm::class, [
            'model' => $page
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model  = new Page();
        $page = Page::all();
        if ($request->ajax()) {
            $data = Page::where('id','!=','')->with('menu_link');

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
                        return '<a class="table-link-publication" href="'.route("admin.settings.pages.edit",$row->id).'"> <strong>'.$row->title.'</strong></a> ';
                    })
                    ->addColumn("page_type", function($row){
                        return intval($row->page_type) === 1 ? "Page aide" : "Page générique";
                    })
                    ->addColumn("menu", function($row){
                        $menus = '';
                        foreach($row->menu_link as $menu){
                            $menus .= '<h5 class="text-sm text-center bg-gray-light"><strong>'.@$menu->menu->name.'</strong> </h5>';
                        }
                        return $menus;
                    })
                    ->addColumn('action',function ($item) {
                        $edit_route     = route('admin.settings.pages.edit',$item->id);
                        $delete_route   = route('admin.settings.pages.destroy',$item->id);
                        $modal_togglers = [
                            [
                                'name'          => "Editer le menu",
                                'route'         => route('admin.settings.page.menus',$item->id),
                                'modal_title'   => "Ajouter ou editer le menu pour la page <strong>$item->title</strong>"
                            ]
                        ];
                        return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route','modal_togglers'));
                    })
                    ->filter(function ($instance) use ($request) {
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
                        if ($request->get('page_type') != '') {
                            $instance->where('page_type', $request->get('page_type'));
                        }
                        if ($request->get('page_menu') != '') {
                            $page_id = $request->get('page_menu');
                            $instance->whereHas('menu_link',function($q) use ($page_id){$q->where('menu_id',$page_id);});
                        }
                        if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('announcements.title', 'LIKE', "%$search%")
                                    ->orWhere('announcements.slug', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->order(function ($instance) use ($request){
                            $order = @$request->get('order')[0];
                            switch ($order['column']) {
                                case 0:
                                    $instance->orderby('title', $order['dir']);
                                    break;
                                case 1:
                                    $instance->orderby('page_type', $order['dir']);
                                    break;
                                case 3:{
                                    $instance->orderby('updated_at', $order['dir']);
                                    break;
                                }
                                default:
                                    $instance->orderby('id', $order['dir']);

                                    break;
                            }
                            $instance
                                ->skip( @$request->get('start') )
                                ->take( @$request->get('length') );
                    })
                    ->rawColumns(['id','title','menu','page_type','created_at','updated_at','action'])
                    ->make(true);
        }

        $form   = $this->getForm();
        $current_user = auth()->user();
        $pages = Page::all();
        $pagesection = HomeSection::all();
        $menus = \App\Models\Menu::where('visible','1')->get();

        return view('admin.pages.index',compact('form','current_user','pages','pagesection','menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \App\Models\Role::all();
        return view('admin.pages.create',compact('roles'));
    }

    public function create_section()
    {
        return view('admin.pages.create_section');
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
            'title'     => 'required',
            'page_type' => 'required',
            'subtitle'  => 'nullable',
            'content'   => 'nullable',
            'is_public'   => 'nullable',
            'roles'   => 'nullable',
        ]);
        //$form->redirectIfNotValid();

        $page = Page::create($data);

        return redirect()->route('admin.settings.pages.index')->with('success','La nouvelle page a été créée avec succès!');
    }

    public function store_section(Request $request)
    {
        /* $form = $this->getForm();
        $data = $form->getFieldValues();

        $form->redirectIfNotValid(); */
        $data = $request->validate([
            'title' => 'required',
            'content' => 'nullable'
        ]);
        HomeSection::create($data);

        return redirect()->route('admin.settings.pages.index')->with('success','La nouvelle section a été créé avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $roles = \App\Models\Role::all();
        return view("admin.pages.create",compact('page','roles'));
    }

    public function edit_section(HomeSection $home_section)
    {
        return view("admin.pages.create_section",compact('home_section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title'     => 'required',
            'page_type' => 'required',
            'subtitle'  => 'nullable',
            'content'   => 'nullable'
            ]);
        //If page is successfully saved we start saving faqs
        if($page->update($data)){
            //First we need the total nbr of faq groups and will loop through them
            $total_faqg_total = intval($request->faqg_total);
            for ($i=1; $i <= $total_faqg_total ; $i++) { 
                //We get the id of the faq_group or create a new instance
                $faqg = Faq_group::find(@$request->input("faqg_id_".$i)) ?? new Faq_group();
                $faqg->title = $request->input("faqg_title_".$i);
                $faqg->save();

                //Now we need the total nbr of faq for each faq_group
                $faqg_total_faq = $request->input("faq_total_".$faqg->id);
                for ($j=1; $j <= $faqg_total_faq  ; $j++) {
                    //For each faq we get it from the id or create a new instance
                    $faq = Faq::find(@$request->input("faq_id_".$j)) ?? new Faq();

                    $faq->position  = @$request->input("faq_position_".$j);
                    $faq->title     = @$request->input("faq_title_".$j);
                    $faq->content   = @$request->input("faq_content_".$j);

                    $faq->save();
                }
            }
        }

        return redirect()->back()->with('success','La page a été mise à jour avec succès!');
    }
    /**
     * 
     */
    public function update_section(Request $request, HomeSection $homeSection)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'nullable'
        ]);

        $homeSection->update($data);
        return redirect()->route('admin.settings.pages.index')->with('success','La section a été mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if($page){
            $page->delete();
            return redirect()->back()->with('success','La page a été supprimée avec succès!');
        }
        return redirect()->back()->with('error','La page est introuvable');
    }

    public function setMenu(Request $request,Page $page)
    {
        $data = $request->validate([
            'name'      => 'nullable',
            'custom_url'=> 'nullable',
        ]);
        $data["url"] = "";
        if($page){
            $data["url"] = url('/')."/pages/".$page->slug;
        }
        if(@$data["costum_url"] != ""){
            $data["url"] = @$data["costum_url"];
            unset($data['costum_url']);
        }
        $data['name']       = $page->title;
        $data['page_id']    = @$page->id;

        $menus = Menu::where('visible',1)->select('id','name')->get();
        foreach ($menus as $menu) {
            $data["menu_id"] = $menu->id;
            $menu_link = MenuLink::where('menu_id',$data['menu_id'])->where('page_id',$data['page_id'])->first();
            //if checked and exist
            if($request->input("menu_".$menu->id) && $menu_link){
                $menu_link->update($data);
            }
            //if checked and not exist
            if($request->input("menu_".$menu->id) && !$menu_link){
                $menu = MenuLink::create($data);
            }
            //if not checked and exist
            if(!$request->input("menu_".$menu->id) && $menu_link){
                $menu_link->delete();
            }
        }

        return redirect()
                    ->back()
                    ->with('success','Vos modifications ont été enregistrées!');
    }
}
