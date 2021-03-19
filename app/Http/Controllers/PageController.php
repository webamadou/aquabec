<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\Datatables\Datatables;

use App\Models\Page;
use App\Forms\PageForm;
use App\Models\HomeSection;

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
    public function index()
    {
        $model  = new Page();
        $form   = $this->getForm();
        $current_user = auth()->user();
        $pages = Page::all();
        $pagesection = HomeSection::all();
        return view('admin.pages.index',compact('form','current_user','pages','pagesection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
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
            'content'   => 'nullable'
        ]);

        //$form->redirectIfNotValid();

        $page = Page::create($data);

        return redirect()->route('admin.settings.pages.index')->with('success','La nouvelle page a été créé avec succès!');
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
    public function edit(Page $page)
    {
        return view("admin.pages.create",compact('page'));
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

        $page->update($data);
        return redirect()->route('admin.settings.pages.index')->with('success','La page a été mise à jour avec succès!');
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
    public function destroy($id)
    {
        //
    }
}
