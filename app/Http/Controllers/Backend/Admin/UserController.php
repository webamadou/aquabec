<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:super-admin|admin']);
    }

    public function usersData()
    {
        $users = User::role('user')->with('roles')->get();

        return datatables()
            ->collection($users)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.users.edit',$item);
                $delete_route = route('admin.users.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.users.index');
    }
}
