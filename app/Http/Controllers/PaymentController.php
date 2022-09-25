<?php

namespace App\Http\Controllers;

use App\Models\packages;
use App\Models\PaymentDetails;
use App\Models\PaymentLogs;
use App\Models\Subscriptions;
use Braintree\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{

    public function index(Request $request, $amount, $package_id)
    {
        $checkSubscription = Subscriptions::where("user_id", Auth::user()->id)->where("is_active", 1)->whereNull("deleted_at")->first();

        if (!empty($checkSubscription)) {
            return abort(403, "You are already subscribed to our package, unsubscribe existing subscription for updating new pack");
        }
        try {
            $amount = Crypt::decrypt($amount);
            $package_id = Crypt::decrypt($package_id);
        } catch (Exception $e) {
            return redirect()->route("home")->withErrors(["Invalid Request"]);
        }
        if ($amount > 0 && !empty($package_id)) {
            $paymentDetails = PaymentDetails::create(["user_id" => Auth::user()->id, "package_id" => $package_id, "amount" => $amount, "payment_gateway" => config('app.PAYMENT_VIA'), "payment_status" => config("constant.PAYMENT_STATUS.INITIATED")]);


            if ($paymentDetails) {
                PaymentLogs::create(["request" => json_encode($request->all()), "payment_id" => $paymentDetails->id, "request_datetime" => date("Y-m-d H:i:s")]);
                //keeping it dynamic for integrating another payment gateway services
                $config = 'App\\Http\\Services\\' . config('app.PAYMENT_VIA');

                $class = $config::init($request->all());
                return view("payment.index")->with("config", $class)->with('amount', $amount)->with('package_id', Crypt::encrypt($package_id))->with("payment_id", Crypt::encrypt($paymentDetails->id));
            }
            return abort(403, "Something went wrong , Please try again later");
        }
    }

    public function checkout(Request $request)
    {
        if ($request->has('amount') && $request->has("payment_id") && $request->has("package_id")) {
            $getPaymentClass = 'App\\Http\\Services\\' . config('app.PAYMENT_VIA');
            $transact = $getPaymentClass::checkout($request);
            if ($transact["status"]) {
                $status = config("constant.PAYMENT_STATUS.SUCCESS");
                $checkPackageValidty = packages::where("id", Crypt::decrypt($request->package_id))->first();
                Subscriptions::create([
                    "user_id" => Auth::user()->id,
                    "package_id" => Crypt::decrypt($request->package_id), "is_active" => 1, "valid_until" => date("Y-m-d H:i:s", strtotime("+" . $checkPackageValidty->days_validity . " days")),
                    "payment_id" => Crypt::decrypt($request->payment_id)
                ]);
            } else {
                $status = config("constant.PAYMENT_STATUS.FAILED");
            }

            PaymentDetails::where("id", Crypt::decrypt($request->payment_id))->update(["payment_status" => $status]);
            return view("payment.status")->with("response", $transact);
        }
        return abort(403, "Invalid Request");
    }
}
