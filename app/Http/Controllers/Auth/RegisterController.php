<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\packages;
use Exception;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            "is_active"=>1
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        if ($request->has("package_id")) {
            try {
                $pId = Crypt::decrypt($request->package_id);
            } catch (Exception $e) {
                return $e->getMessage();
            }
            $checkPackageIfExists = packages::where("id", $pId)->first();
            if (empty($checkPackageIfExists)) {
                return "Invalid package id";
            }
        }
        return view('auth.register');
    }

    protected function registered(Request $request, $user)
    {
        if ($request->has("package_id")) {

            try {
                $pId = Crypt::decrypt($request->package_id);
            } catch (Exception $e) {
                return redirect()->route("home")->withErrors(["Package Id Invalid"]);
            }

            $checkPackageIfExists = packages::where("id", $pId)->first();
            if (empty($checkPackageIfExists)) {

                return redirect()->route("home")->withErrors(["Package Id Invalid"]);
            }
            $this->redirectTo = route("payment-init", ["amount" => Crypt::encrypt($checkPackageIfExists->amount), "package_id" => Crypt::encrypt($pId)]);
        }
    }
}
