<?php

namespace App\Features\Operations\Purging\Controllers;

use App\Giveaway;
use App\Http\Controllers\Controller;
use App\PaddleLog;
use App\Subscriber;
use App\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class PurgeController extends Controller
{
    public function __construct()
    {
        // Add your middleware, if needed.
    }

    /**
     * Purges a user from the database and from all its related tables data.
     *
     * @param  Request $request
     * @param  \App\User    $user
     *
     * @return Response
     */
    public function purge(User $user)
    {
        if ($user) {
            /**
             * Impacted tables:
             * activity_log
             * paddle_log
             * users
             * videos_completed.
             */
            $activityLogUserData = Activity::forSubject($user);
            $paddleLogData = PaddleLog::firstWhere('email', $user->email);
            $activityPaddleLogData = Activity::forSubject($paddleLogData ?? new PaddleLog());
            $videosCompletedData = $user->videosCompleted();
            $subscriberData = Subscriber::where('email', $user->email);
            $giveAwayData = Giveaway::where('email', $user->email);

            // Delete associated user data.
            $rows1 = $activityLogUserData->forceDelete();
            $rows2 = $activityPaddleLogData->forceDelete();
            $rows3 = optional($paddleLogData)->forceDelete() ?? 0;
            $rows4 = $videosCompletedData->detach();
            $rows5 = $user->forceDelete();
            $rows6 = $subscriberData->forceDelete();
            $rows7 = $giveAwayData->forceDelete();

            return response('activity_log: '.($rows1 + $rows2).' paddle_log:'.$rows3.' videos_completed:'.$rows4.' users:'.$rows5.' subscribers:'.$rows6.' giveaway:'.$rows7);
        } else {
            return response('User unknown.');
        }
    }
}
