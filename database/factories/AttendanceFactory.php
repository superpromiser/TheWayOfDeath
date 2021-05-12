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
        'schoolId'=>1,
        'gradeId'=>1,
        'lessonId'=>1,
<<<<<<< HEAD
        'userId'=>rand(6,8),
=======
        'userId'=>rand(25,43),
>>>>>>> 9ebfea3f187b9094a196d4c61d8ce2208406efeb
    ];
});
