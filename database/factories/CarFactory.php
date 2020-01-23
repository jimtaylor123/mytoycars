<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Car;
use App\User;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'name' => $faker->name,
        'colour' => $faker->colorName,
        'value' => '10.99',
        'photoUrl' => $faker->url,
    ];
});
