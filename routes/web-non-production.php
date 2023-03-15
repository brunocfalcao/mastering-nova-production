<?php

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// 68618190-chre064887bf4ff-73176d78a7
Route::get('/test-checkout/{checkout}', function (string $checkout) {
    $event = PaddleLog::firstWhere('checkout_id', $checkout);

    /*
    $event->passthrough = stripcslashes($event->passthrough);
    $event->payload = stripcslashes($event->payload);
    $event->save();
    */

    if (blank($event)) {
        return response("Checkout it unknown ({$checkout}).");
    }

    // Delete user from the $event.
    User::where('email', $event->email)->forceDelete();
    event(new PaymentSucceeded($event->toArray(), request()));

    return response('Checkout test process client email - '.$event->email);
});

// Test emails.
Route::get('email/thank-you', function () {
    $user = User::firstWhere('email', 'bruno.falcao@live.com');
    $checkout = new \StdClass();
    $checkout->receipt_url = 'https://www.publico.pt';
    $token = '12345abgrfh';

    // Send "thank you email".
    Mail::to($user->email)
    ->send(new ThankYouForPurchasing($user->email, $checkout->receipt_url, $token));
});

// Get a bcrypt password.
Route::get('password/{password}', function ($password) {
    return bcrypt($password);
});

// Test an upload to the backblaze bucket.
Route::get('bucket', function () {
    Storage::disk('b2')->put('filename.txt', 'My important content');
});

// Dumps a phpinfo.
Route::get('phpinfo', function () {
    phpinfo();
});

Route::get('sms', function () {
    // Send SMS Notification.
    Notification::route('nexmo', '41789654141')
        ->notify(new SendSMSNotification());
});
