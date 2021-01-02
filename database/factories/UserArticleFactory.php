<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\DataAccess\Eloquent\ArticleUser;

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

$factory->define(ArticleUser::class, function (Faker $faker) {
    return [];
});
