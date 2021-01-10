<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Forms\SubscriptionForm;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class SubscriptionController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin|admin']);
        $this->formBuilder = $formBuilder;
    }

    public function subscriptionsData()
    {
        $subscriptions = Subscription::all();

        return datatables()
            ->collection($subscriptions)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.subscriptions.edit',$item);
                $delete_route = route('admin.subscriptions.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Subscription|null $subscription
     * @return Form
     */
    private function getForm(?Subscription $subscription = null): Form
    {
        $subscription = $subscription ?: new Subscription();
        return $this->formBuilder->create(SubscriptionForm::class, [
            'model' => $subscription
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
        return view('admin.subscriptions.index',compact('form'));
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

        Subscription::create($data);

        return redirect()->route('admin.subscriptions.index')->with('success','Un abonnement a été créé avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subscription $subscription
     * @return Application|Factory|View
     */
    public function edit(Subscription $subscription)
    {
        $form = $this->getForm($subscription);
        return view('admin.subscriptions.index',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Subscription $subscription
     * @return RedirectResponse
     */
    public function update(Subscription $subscription)
    {
        $form = $this->getForm($subscription);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        $subscription->update($data);
        return redirect()->route('admin.subscriptions.index')->with('success',"L'abonnement a été mis à jour avec succès!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscription $subscription
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->back()->with('error','Impossible de supprimer cet abonnement');
    }
}
