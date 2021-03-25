<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attendance;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {
    $events = $faker->dateTimeBetween('-30 days', '+30 days');
    return [
        //
        'date'=>$events->format('Y-m-d'),
        // 'startTime'=>
    ];
});
