<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Content;
use Faker\Generator as Faker;

$factory->define(Content::class, function (Faker $faker) {
    return [
        //
        'title'=>'问卷',
        'color'=>'lime darken-4',
        'detail'=>'detail',
        'imgUrl'=>'/asset/img/icon/问卷 拷贝.png',
        'path'=>'questionnaire'
    ];
});
