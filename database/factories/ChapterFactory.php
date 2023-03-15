<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Chapter;
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

$factory->define(Chapter::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
    ];
});

if (env('SEED_WITH_MEDIA') == true) {
    $factory->afterCreating(Chapter::class, function ($chapter, $faker) {
        $chapter->addMediaFromUrl('https://placeimg.com/1200/600/'.Str::random(10))
                ->toMediaCollection('social');

        $chapter->addMediaFromUrl('https://placeimg.com/1140/1040/'.Str::random(10))
                ->toMediaCollection('featured');
    });
}
