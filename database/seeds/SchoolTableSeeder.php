<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        //school
        DB::table('schools')->insert([
            'id' => 1,
            'schoolName' => 'Eschool',
            'code' => 123123123,
            'phoneNum' => 123123123,
            'zipCode' => 123123123,
            'head' => 'headerOfEschool',
            'address' => '{"city": "110100", "detail": "123123123", "region": "110101", "province": "110000"}',
            'introduce' => 'introduce of Eschool',
            'imgUrl' => '/asset/img/login.jpg',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        
        //grades
        DB::table('grades')->insert([
            'id' => 1,
            'gradeName' => '1年级',
            'schoolId' => 1,
            'imgUrl' => '/asset/img/class/2.jpg',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('grades')->insert([
            'id' => 2,
            'gradeName' => '2年级',
            'schoolId' => 1,
            'imgUrl' => '/asset/img/class/4.jpg',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);

        //lessons
        DB::table('lessons')->insert([
            'id' => 1,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23',
            'lessonName' => '1-1班级',
            'imgUrl' => '/asset/img/class/5.jpg',
            'schoolId' => 1,
            'gradeId' => 1,
        ]);
        DB::table('lessons')->insert([
            'id' => 2,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23',
            'lessonName' => '1-2班级',
            'imgUrl' => '/asset/img/class/6.jpg',
            'schoolId' => 1,
            'gradeId' => 1,
        ]);
        DB::table('lessons')->insert([
            'id' => 3,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23',
            'lessonName' => '2-1班级',
            'imgUrl' => '/asset/img/class/7.jpg',
            'schoolId' => 1,
            'gradeId' => 2,
        ]);
        DB::table('lessons')->insert([
            'id' => 4,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23',
            'lessonName' => '2-2班级',
            'imgUrl' => '/asset/img/class/8.jpg',
            'schoolId' => 1,
            'gradeId' => 2,
        ]);
        
    }
}
