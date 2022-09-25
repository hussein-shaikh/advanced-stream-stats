<?php

namespace App\Http\Controllers;

use App\Models\packages;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            $packages = packages::all();
            return view('welcome')->with("packages", $packages);
        }
        return redirect()->route('home');
    }

    public function dashboard(Request $request)
    {
        $checkSubscription = Subscriptions::where("user_id", $request->user()->id)->where("is_active", 1)->whereNull("deleted_at")->first();
        $packages = packages::all();
        return view("dashboard.index")->with("subscription", $checkSubscription)->with("packages", $packages);
    }
}
