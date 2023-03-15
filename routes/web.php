<?php

use App\Facades\WebsiteCheckout;
use App\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get(
    'videos/{video}',
    '\App\Features\Videos\Controllers\VideosController@play'
)->name('videos.play')
->middleware('can-interact');

Auth::routes(['register' => false, 'confirm' => false, 'verify' => false]);

Route::get(
    'videos',
    '\App\Features\Videos\Controllers\VideosController@index'
)->name('videos');

Route::get('/ppp', function () {
    session()->forget('website-checkout');
    session()->forget('website-paylink');

    return redirect(route('welcome', ['ppp' => 1]));
})->name('welcome.ppp');

Route::post(
    'videos/completed/{video}',
    '\App\Features\Videos\Controllers\VideosController@completed'
)->name('videos.completed')
->middleware('can-interact');

Route::redirect('/home', '/videos');

Route::get(
    'videos/download/{video}',
    '\App\Features\Videos\Controllers\VideosController@download'
)->name('videos.download')
->middleware('can-interact', 'signed');

/*
 * Extremely important to have a throttle for the paylink since
 * hackers might try to charge cards in a bulk way.
 * This way it will block the user from trying again.
 * 3 requests per minute should be enough.
 */
Route::get('/paylink', function () {
    return redirect(WebsiteCheckout::make()->payLink());
})->name('checkout.paylink')
->middleware('throttle:3,1');

Route::get('/paylink-half', function () {
    session()->forget('website-checkout');
    session()->forget('website-paylink');

    return redirect(WebsiteCheckout::make()->payLinkHalf());
})->name('checkout.paylink.half')
->middleware('throttle:3,1');

Route::get('/webhook/download', function () {
    return response('Purchase successful. Thank you for buying the Mastering Nova course!. Hope you enjoy it as much as I did making it for you. Let me know if any issues!', 200);
});

Route::get(
    '/',
    '\App\Features\Welcome\Controllers\WelcomeController@index'
)->name('welcome');

Route::get(
    '/payment-options',
    '\App\Features\Welcome\Controllers\WelcomeController@options'
)->name('welcome.options');

Route::post(
    '/',
    '\App\Features\Welcome\Controllers\WelcomeController@subscribe'
)->name('welcome.subscribed');

/*
 * Purge user email from the database.
 * Cleans tables directly.
 */
Route::get(
    '/operations/purge/{user}',
    '\App\Features\Operations\Purging\Controllers\PurgeController@purge'
)->name('operations.purge');

/*
 * Allows the newsletter giveaway prize
 */
Route::get(
    '/giveaway/newsletter',
    '\App\Features\GiveAway\Newsletter\Controllers\NewsletterController@form'
)->name('giveaway.newsletter.form');

Route::post(
    '/giveaway/newsletter',
    '\App\Features\GiveAway\Newsletter\Controllers\NewsletterController@subscribe'
)->name('giveaway.newsletter.subscribe');

// Creates a user
Route::get('/create/user/{name}/{email}/{password}', function ($name, $email, $password) {
    User::create([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password), ]);
});

// Updates an user password
Route::get('/operations/change/password/{email}/{password}', function ($email, $password) {
    $results = User::where('email', $email)
                   ->update(['password' => bcrypt($password)]);

    return response('Total updated records: ' . $results);
});
