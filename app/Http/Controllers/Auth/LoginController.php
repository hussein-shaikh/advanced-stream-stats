<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\packages;
use App\Models\Subscriptions;
use App\Providers\RouteServiceProvider;
use Braintree\Subscription;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
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
        return view('auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
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

            $checkSubscription = Subscriptions::where("user_id", $user->id)->where("is_active", 1)->whereNull("deleted_at")->first();

            if (!empty($checkSubscription)) {
                return abort(403, "You are already subscribed to our package, unsubscribe existing subscription for updating new pack");
            }

            $this->redirectTo = route("payment-init", ["amount" => Crypt::encrypt($checkPackageIfExists->amount), "package_id" => Crypt::encrypt($pId)]);
        }
    }
}
