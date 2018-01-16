<?php

use Faker\Generator as Faker;

$factory->define(Pine\Translatable\Tests\Translatable::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'body' => $faker->sentences(2, true),
    ];
});
