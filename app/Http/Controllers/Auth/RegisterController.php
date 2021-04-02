<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:255'],
            'prenom'    => ['required', 'string', 'max:255'],
            'username'  => 'required|string|max:20|unique:users',
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'terms'     => ['required'],
        ]);
    }
    public function showRegistrationForm()
    {
        $roles_exception = ['super-admin','admin', 'banker', 'user'];
        $roles = Role::whereNotIn('name', $roles_exception)->pluck('name','id');
        return view('auth.register', compact("roles"));
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->prenom = $data['prenom'];
        $user->email = $data['email'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        //dd($data);

        $user->save();
        return $user;
        /* return User::create([
            'name' => $data['name'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]); */
    }

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        return '/dashboard';
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $role = $request->role;//We get the picked role
        event(new Registered($user = $this->create($request->all())));
        $user->assignRole("membre");//We assign the role to the user
        //We need to prepare the data to apply to the default credit amount to assign to the user
        $role = $user->roles->first();
        $free_credit_amount = $role != null ? intval($role->free_credit) : 0;
        $paid_credit_amount = $role != null ? intval($role->paid_credit) : 0;

        $pivot_field        = ['free_currency' => $free_credit_amount, 'paid_currency' => $paid_credit_amount ];
        $user->setUserCurrency(1 , $pivot_field);

        $this->guard()->login($user);
        
        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }
}
