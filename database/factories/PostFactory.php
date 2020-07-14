<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->word,
        'content' => $faker->paragraph,
        'user_id' => App\User::find(1),
        'slug' => Str::slug($faker->unique()->word, '-'),
    ];
});
