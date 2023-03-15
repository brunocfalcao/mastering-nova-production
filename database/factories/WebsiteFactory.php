<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Website;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Website::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
    ];
});

if (env('SEED_WITH_MEDIA') == true) {
    $factory->afterCreating(Website::class, function ($chapter, $faker) {
        $chapter->addMediaFromUrl('https://placeimg.com/1200/600/'.Str::random(10))
            ->toMediaCollection('social');

        $chapter->addMediaFromUrl('https://placeimg.com/1500/1200/'.Str::random(10))
            ->toMediaCollection('headers');

        $chapter->addMediaFromUrl('https://placeimg.com/1500/1200/'.Str::random(10))
            ->toMediaCollection('headers');

        $chapter->addMediaFromUrl('https://placeimg.com/1500/1200/'.Str::random(10))
            ->toMediaCollection('headers');
    });
}
