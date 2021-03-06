<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\DataAccess\Eloquent\Site;

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

$factory->define(Site::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'feed_url' => $faker->url,
        'source_url' => $faker->url,
        'crawlable' => true,
        'type' => 'rss',
    ];
});
