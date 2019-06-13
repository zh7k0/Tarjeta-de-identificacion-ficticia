<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Giro;
use Faker\Generator as Faker;

$factory->define(Giro::class, function (Faker $faker) {
    return [
        'nombre' => 'Venta de '.$faker->name
    ];
});
