<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TrackData;
use Faker\Generator as Faker;

$factory->define(TrackData::class, function (Faker $faker) {
    $lngMin = 123470000;
    $lngMax = 123499999;
    $latMin = 41600000;
    $latMax = 41699999;
    $decimals = 6;
    $divisor = pow(10, $decimals);
    $events = $faker->dateTimeBetween('-30 days', '+1 days');
    return [
        //
        'imei' => '567567567',
        'trackDate' => $events,
        'lat' => mt_rand($latMin, $latMax) / $divisor,
        'lng' => mt_rand($lngMin, $lngMax) / $divisor,
    ];
});
