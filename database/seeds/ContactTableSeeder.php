<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'id' => 1,
            'userId' => 3,
            'contactUserId' => 1,
            'roomId' => NULL,
            'new_msg_count' => 0,
            'last_message' => NULL,
            'last_time' => NULL,
            'last_sender' => NULL,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('contacts')->insert([
            'id' => 2,
            'userId' => 4,
            'contactUserId' => 1,
            'roomId' => NULL,
            'new_msg_count' => 0,
            'last_message' => NULL,
            'last_time' => NULL,
            'last_sender' => NULL,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('contacts')->insert([
            'id' => 3,
            'userId' => 5,
            'contactUserId' => 1,
            'roomId' => NULL,
            'new_msg_count' => 0,
            'last_message' => NULL,
            'last_time' => NULL,
            'last_sender' => NULL,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('contacts')->insert([
            'id' => 4,
            'userId' => 6,
            'contactUserId' => 1,
            'roomId' => NULL,
            'new_msg_count' => 0,
            'last_message' => NULL,
            'last_time' => NULL,
            'last_sender' => NULL,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('contacts')->insert([
            'id' => 5,
            'userId' => 7,
            'contactUserId' => 1,
            'roomId' => NULL,
            'new_msg_count' => 0,
            'last_message' => NULL,
            'last_time' => NULL,
            'last_sender' => NULL,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('contacts')->insert([
            'id' => 6,
            'userId' => 8,
            'contactUserId' => 1,
            'roomId' => NULL,
            'new_msg_count' => 0,
            'last_message' => NULL,
            'last_time' => NULL,
            'last_sender' => NULL,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
    }
}
