<?php

use Faker\Generator as Faker;
use App\DataAccess\Eloquent\Article;

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

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(30),
        'description' => $faker->text(100),
        'date' => $faker->dateTime(),
        'articleUrl' => $faker->url,
        'sourceUrl' => $faker->url,
        'imageUrl' => $faker->imageUrl(),
        'faviconUrl' => $faker->imageUrl(),
    ];
});
