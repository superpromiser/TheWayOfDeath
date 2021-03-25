<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attendance;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {
    $events = $faker->dateTimeBetween('-30 days', '+1 days');
    return [
        //
        'date'=>$events->format('Y-m-d'),
        // 'startTime'=>
        'startTime'=>date('H:i', rand(28800,32400)),
        'endTime'=>date('H:i', rand(61200,68400)),
        'userId'=>rand(7,10),
    ];
});
