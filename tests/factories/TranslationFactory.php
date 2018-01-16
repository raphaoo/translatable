<?php

use Faker\Generator as Faker;

$factory->define(Pine\Translatable\Translation::class, function (Faker $faker) {
    return [
        'content' => [
            'title' => $faker->word,
            'body' => $faker->sentences(2, true),
        ],
    ];
});
