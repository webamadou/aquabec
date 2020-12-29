<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\User;
use App\Models\Event;
use App\Models\Announcement;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:super-admin|admin']);
    }

    public function usersData()
    {
        $users = User::role(['user','admin'])->with('roles')->get();

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

    	$users = User::all();
    	$organisations = User::all();
    	$events = Event::all();
    	$announcements = Announcement::all();
      return view('admin.users.index', compact("users","organisations","events","announcements"));
        return view('admin.users.index');
    }

    public function getListUserAjax()
    {
        $res = User::select("name,id")
                ->where("name","LIKE","%{$request->term}%")
                ->where("id","%{$request->term}%")
                ->where("id", "!=", Auth::id())
                ->get();
    
        return response()->json($res);
    }
}
