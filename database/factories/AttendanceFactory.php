<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attendance;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {
<<<<<<< HEAD
        $events = $faker->dateTimeBetween('-30 days', '+1 days');
        return [
                //
                'date' => $events->format('Y-m-d'),
                // 'startTime'=>
                'startTime' => date('H:i', rand(28800, 32400)),
                'endTime' => date('H:i', rand(61200, 68400)),
                'schoolId' => 1,
                'gradeId' => 1,
                'lessonId' => 1,
                'userId' => rand(25, 43),
        ];
=======
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
        'userId'=>rand(25,43),
    ];
>>>>>>> 3160d4aba44716f652875b3f1c21848d3a0c4f82
});
