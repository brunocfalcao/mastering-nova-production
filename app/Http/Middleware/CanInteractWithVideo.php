<?php

namespace App\Http\Middleware;

use App\Nova\Video;
use Closure;
use Illuminate\Support\Facades\Gate;

class CanInteractWithVideo
{
    /**
     * Can this user see this video?
     * - Video is free -> ok.
     * - Video is not free -> User must be logged in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $video = $request->route('video');

        if (Gate::denies('play-video', $video)) {
            if (env('LAUNCHED') == 1) {
                return redirect(route('checkout.paylink'));
            } else {
                return redirect(route('welcome'));
            }
        }

        return $next($request);
    }
}
