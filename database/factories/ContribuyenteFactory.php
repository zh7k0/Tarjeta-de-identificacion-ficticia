<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Contribuyente;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Contribuyente::class, function (Faker $faker) {
    return [
        'razon_social' => $faker->name,
        'dig_verificador' => mt_rand(1,9),
        'tipo_contribuyente' => mt_rand(1,2),
        'domicilio' => Str::random(20),
        'giro_id' => function (){
            return factory(App\Giro::class)->create()->id;
        },
        'rut' => mt_rand(75000000, 90000000)
    ];
});
