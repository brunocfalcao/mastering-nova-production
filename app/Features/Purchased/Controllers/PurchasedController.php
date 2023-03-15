<?php

namespace App\Features\Purchased\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchasedController extends Controller
{
    public function __construct()
    {
        // Add your middleware, if needed.
    }

    public function thanks(Request $request, string $checkout)
    {
        if (app()->environment() != 'local') {
            if (! array_key_exists('HTTP_REFERER', $_SERVER)) {
                throw new \Exception('Security error. No HTTP referer.');
            }

            if (! Str::contains($_SERVER['HTTP_REFERER'], 'buy.paddle.com')) {
                throw new \Exception('Security error. This request was not done via Paddle checkout.');
            }
        }

        if (! filled($checkout)) {
            throw new \Exception('Security error. No checkout id found.');
        }

        return flame();
    }
}
