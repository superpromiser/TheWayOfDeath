<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
        * sesson table
        */
        DB::table('sessions')->insert([
            'id' => 1,
            'userId' => 3,
            'schoolId' => 1,
            'sessionName' => '2021~2022',
            'created_at' => '2021-06-09 05:34:57',
            'updated_at' => '2021-06-09 05:34:57',
            'sessionDate' => '2021-06-09',
        ]);
        
        /**
        * subject table
        */
        DB::table('subjects')->insert([
            'id' => 1,
            'userId' => 3,
            'schoolId' => 1,
            'sessionId' => 1,
            'subjectOrderName' => '1课',
            'subjectOrderType' => '课程',
            'startTime' => '08:00',
            'endTime' => '08:45',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:39:25',
            'updated_at' => '2021-06-09 05:39:25',
        ]);
        DB::table('subjects')->insert([
            'id' => 2,
            'userId' => 3,
            'schoolId' => 1,
            'sessionId' => 1,
            'subjectOrderName' => '2课',
            'subjectOrderType' => '课程',
            'startTime' => '09:00',
            'endTime' => '09:45',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:39:25',
            'updated_at' => '2021-06-09 05:39:25',
        ]);
        DB::table('subjects')->insert([
            'id' => 3,
            'userId' => 3,
            'schoolId' => 1,
            'sessionId' => 1,
            'subjectOrderName' => '3课',
            'subjectOrderType' => '课程',
            'startTime' => '10:00',
            'endTime' => '10:45',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:39:25',
            'updated_at' => '2021-06-09 05:39:25',
        ]);
        DB::table('subjects')->insert([
            'id' => 4,
            'userId' => 3,
            'schoolId' => 1,
            'sessionId' => 1,
            'subjectOrderName' => '4课',
            'subjectOrderType' => '课程',
            'startTime' => '11:00',
            'endTime' => '11:45',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:39:25',
            'updated_at' => '2021-06-09 05:39:25',
        ]);
        DB::table('subjects')->insert([
            'id' => 5,
            'userId' => 3,
            'schoolId' => 1,
            'sessionId' => 1,
            'subjectOrderName' => '5课',
            'subjectOrderType' => '课程',
            'startTime' => '12:00',
            'endTime' => '12:45',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:39:25',
            'updated_at' => '2021-06-09 05:39:25',
        ]);
        DB::table('subjects')->insert([
            'id' => 6,
            'userId' => 3,
            'schoolId' => 1,
            'sessionId' => 1,
            'subjectOrderName' => '6课',
            'subjectOrderType' => '课程',
            'startTime' => '13:00',
            'endTime' => '13:45',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:39:25',
            'updated_at' => '2021-06-09 05:39:25',
        ]);
        

        /**
        * schedule_settings table
        */
        DB::table('schedule_settings')->insert([
            'id' => 1,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '数学',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_settings')->insert([
            'id' => 2,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '物理',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_settings')->insert([
            'id' => 3,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '化学',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_settings')->insert([
            'id' => 4,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '生物学',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_settings')->insert([
            'id' => 5,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '文学',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_settings')->insert([
            'id' => 6,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '历史',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_settings')->insert([
            'id' => 7,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '地理',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_settings')->insert([
            'id' => 8,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '音乐',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_settings')->insert([
            'id' => 9,
            'userId' => 3,
            'gradeId' => 1,
            'schoolId' => 1,
            'subjectName' => '运动型',
            'isActived' => 0,
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);

        /**
        * schedule_teachers table
        */
        DB::table('schedule_teachers')->insert([
            'id' => 1,
            'userId' => 3,
            'scheduleSettingId' => 1,
            'subjectName' => '数学',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_teachers')->insert([
            'id' => 2,
            'userId' => 3,
            'scheduleSettingId' => 2,
            'subjectName' => '物理',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_teachers')->insert([
            'id' => 3,
            'userId' => 3,
            'scheduleSettingId' => 3,
            'subjectName' => '化学',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_teachers')->insert([
            'id' => 4,
            'userId' => 3,
            'scheduleSettingId' => 4,
            'subjectName' => '生物学',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_teachers')->insert([
            'id' => 5,
            'userId' => 3,
            'scheduleSettingId' => 5,
            'subjectName' => '文学',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_teachers')->insert([
            'id' => 6,
            'userId' => 3,
            'scheduleSettingId' => 6,
            'subjectName' => '历史',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_teachers')->insert([
            'id' => 7,
            'userId' => 3,
            'scheduleSettingId' => 7,
            'subjectName' => '地理',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_teachers')->insert([
            'id' => 8,
            'userId' => 3,
            'scheduleSettingId' => 8,
            'subjectName' => '音乐',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
        DB::table('schedule_teachers')->insert([
            'id' => 9,
            'userId' => 3,
            'scheduleSettingId' => 9,
            'subjectName' => '运动型',
            'teacherId' => 5,
            'teacherName' => 'teacher1',
            'schoolId' => 1,
            'lessons' => '["1-1班级"]',
            'created_at' => '2021-06-09 05:49:33',
            'updated_at' => '2021-06-09 05:49:33',
        ]);
    }
}
