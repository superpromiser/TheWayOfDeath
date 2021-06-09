<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'systemBot',
            'avatar' => '/asset/img/bot/bot1.png',
            'phoneNumber' => 99999999999,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'schoolId' => 0,
            'roleId' => 1,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('users')->insert([
            'name' => '李飞鸿',
            'phoneNumber' => 67306674,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'schoolId' => 1,
            'roleId' => 1,
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
    }
}
