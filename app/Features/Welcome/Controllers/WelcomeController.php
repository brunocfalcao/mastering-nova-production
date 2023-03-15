<?php

namespace App\Features\Welcome\Controllers;

use App\Chapter;
use App\Http\Controllers\Controller;
use App\Mail\ThankYouForSubscribing;
use App\Subscriber;
use App\Video;
use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use ProtoneMedia\LaravelPaddle\Paddle;

class WelcomeController extends Controller
{
    public function __construct()
    {
        if (app()->environment() == 'production') {
            $this->middleware(['throttle:2,1'])
                 ->only(['subscribe']);
        }
    }

    public function options()
    {
        return flame();
    }

    public function index()
    {
        /*
        dd(Paddle::product()
                 ->createCoupon()
                 ->productId('594915')
                 ->numCoupons(3)
                 ->description('Pre-subscriber Special Discount Coupon')
                 ->couponType('product')
                 ->discountType('percentage')
                 ->discountAmount(10)
                 ->allowedUses(1)
                 ->group('Pre-Subscribers Coupons')
                 ->send());
        */

        return flame([
            'videos' => Video::query(),
            'totalVideos' => Video::all()->count(),
            'website' => Website::first(),
            'chapters' => Chapter::orderBy('index')->get(),
        ]);
    }

    public function subscribe(Request $request)
    {
        // Testing reasons with my email.
        Subscriber::where('email', 'bruno.falcao@live.com')->delete();

        Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|unique:App\Subscriber,email',
        ])->validate();

        Subscriber::create(['email' => $request->input('email')]);

        Mail::to($request->input('email'))
            ->send(new ThankYouForSubscribing());

        return flame([
            'website' => Website::first(),
            'chapters' => Chapter::orderBy('index')->get(),
        ]);
    }
}
