<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Video;
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

$factory->define(Video::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'details' => $faker->sentence,
        'is_free' => rand(0, 100) > 25 ? true : false,
        'vimeo_id' => rand(420716503, 690121123),
        'is_visible' => true,
        'is_active' => true,
        'duration' => rand(5, 10).':'.rand(0, 60),
    ];
});

if (env('SEED_WITH_MEDIA') == true) {
    $factory->afterCreating(Video::class, function ($video, $faker) {
        $video->addMediaFromUrl('https://placeimg.com/1200/600/'.Str::random(10))
              ->toMediaCollection('social');
    });
}
