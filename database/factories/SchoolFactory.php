<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\School;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
    return [
        //
        'schoolName'=>'test',
        'code'=>123123,
        'phoneNum'=>1123456789,
        'zipCode'=>19378,
        'head'=>'kiral',
        'address'=>'{"province":"120000","city":"120200","region":"120223","detail":"address"}',
        'introduce'=>'test introduce',
    ];
});
