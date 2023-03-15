<?php

namespace App\Features\Videos\Controllers;

use App\Chapter;
use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class VideosController extends Controller
{
    public function __construct()
    {
        // Add your middleware, if needed.
    }

    public function index()
    {
        // Get first playable video.
        if (Auth::guest()) {
            $lastSeenVideo = Video::free()->first();
        } else {
            // Get last video seen, or if not, then first video.
            $lastSeenVideo = Video::where('id', DB::table('videos_completed')
                 ->select('video_id')
                 ->where('user_id', Auth::id())
                 ->orderBy('id', 'desc')
                 ->value('video_id'))
                 ->firstOr(function () {
                     return Video::where('id', 1)->first();
                 });
        }

        return flame(['chapters' => Chapter::all(), 'playable' => $lastSeenVideo]);
    }

    public function play(Request $request, Video $video)
    {
        return flame(['chapters' => Chapter::all(), 'playable' => $video]);
    }

    public function completed(Request $request, Video $video)
    {
        Auth::user()->videosCompleted()->attach($video);

        return redirect()->route('videos.play', ['video' => $video->next->id]);
    }

    public function download(Request $request, Video $video)
    {
        // -- AUTHORIZE ACCOUNT
        $application_key_id = '4ca917bf6def'; // Obtained from your B2 account page
        $application_key = '0025f4fb2cccdbd45517b2c40896b6f79801f84a35'; // Obtained from your B2 account page
        $credentials = base64_encode($application_key_id.':'.$application_key);
        $url = 'https://api.backblazeb2.com/b2api/v2/b2_authorize_account';

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->withBasicAuth($application_key_id, $application_key)
          ->get($url);

        if ($response->failed()) {
            return response('There was an error trying to download this video.', 403);
        }

        $authorizationData = $response->json();

        $download_url = $authorizationData['downloadUrl'];
        $api_url = $authorizationData['apiUrl']; // From b2_authorize_account call
        $auth_token = $authorizationData['authorizationToken']; // From b2_authorize_account call
        $bucket_id = '341c8a09f1c7ebaf764d0e1f'; // The bucket that files can be downloaded from
        $valid_duration = 1800; // The number of seconds the authorization is valid for
        $file_name_prefix = 'Mastering Nova - '; // The file name prefix of files the download authorization will allow

        $data = ['bucketId' => $bucket_id,
                      'validDurationInSeconds' => $valid_duration,
                      'fileNamePrefix' => $file_name_prefix, ];

        // -- GET DOWNLOAD AUTHORIZATION TOKEN

        $response = Http::withHeaders([
            'Authorization' => $auth_token,
            'Accept' => 'application/json',
        ])->post($api_url.'/b2api/v2/b2_get_download_authorization', $data);

        if ($response->failed()) {
            return response('There was an error trying to download this video.', 403);
        }

        $downloadData = $response->json();

        return redirect($authorizationData['downloadUrl'].'/file/MASTERING-NOVA/'.$video->filename.'?Authorization='.$downloadData['authorizationToken']);
    }
}
