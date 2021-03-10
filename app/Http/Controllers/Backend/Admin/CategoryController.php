<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Forms\CategoryForm;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class CategoryController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin|admin']);
        $this->formBuilder = $formBuilder;
    }

    public function eventCategoriesData()
    {
        $categories = Category::where('type','evemenent')->get();

        return datatables()
            ->collection($categories)
            ->addColumn('parent',function ($item) {
                if ($item->parent_id) {
                    return $item->parent->name;
                }
                return '';
            })
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.settings.categories.edit',$item);
                $delete_route = route('admin.settings.categories.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function categoriesData()
    {
        $categories = Category::where('type','!=','')->with('parent')->get();
        return datatables()
            ->collection($categories)
            ->addColumn('action',function ($category) {
                $edit_route = route('admin.settings.categories.edit',$category);
                $delete_route = route('admin.settings.categories.destroy',$category);

                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function announcementCategoriesData()
    {
        $categories = Category::where('type','annonce')->get();

        return datatables()
            ->collection($categories)
            ->addColumn('parent',function ($item) {
                if ($item->parent_id) {
                    return $item->parent->name;
                }
                return '';
            })
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.settings.categories.edit',$item);
                $delete_route = route('admin.settings.categories.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Category|null $category
     * @return Form
     */
    private function getForm(?Category $category = null): Form
    {
        $category = $category ?: new Category();
        return $this->formBuilder->create(CategoryForm::class, [
            'model' => $category
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $form = $this->getForm();
        return view('admin.categories.index',compact('form'));
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

        $slug = Str::slug($form->getFieldValues()['name']);
        $data = array_merge($data,compact('slug'));

        if (@$data['parent_id'] == null) {
            $data['parent_id'] = 0;
        }

        Category::create($data);

        return redirect()->route('admin.settings.categories.index')->with('success','Une catégorie a été créée avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        $form = $this->getForm($category);
        return view('admin.categories.index',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(Category $category)
    {
        $form = $this->getForm($category);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        if (@$data['parent_id'] == null) {
            $data['parent_id'] = 0;
        }

        $category->update($data);
        return redirect()->route('admin.settings.categories.index')->with('success','La catégorie a été mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        if($category->categories_count > 0){
            return redirect()->back()->with("error", "Impossible de supprimer une catégorie qui a des catégories enfant.");
        }
        if($category->type == 'event' && $category->events_count == 0){
            $category->delete();
            return redirect()->back()->with('success','La catégorie a été supprimée avec succès!');
        }

        if($category->type == 'announcement' && $category->announcements_count == 0){
            $category->delete();
            return redirect()->back()->with('success','La catégorie a été supprimée avec succès!');
        }
        return redirect()->back()->with('error','Impossible de supprimer cette catégorie');
    }
}
