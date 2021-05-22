<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => '李飞鸿',
        'phoneNumber' => 67306674,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'schoolId' => 1,
        'roleId' => 1,
    ];
    // return [
    //     'name' => 'systemBot',
    //     'avatar' => '/asset/img/bot/bot1.png',
    //     'phoneNumber'=> 99999999999,
    //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    //     'remember_token' => Str::random(10),
    //     'schoolId' => 0,
    //     'roleId' => 1,
    // ];
});
