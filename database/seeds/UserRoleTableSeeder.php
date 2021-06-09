<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'id' => 1,
            'roleName' => 'admin',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('user_roles')->insert([
            'id' => 2,
            'roleName' => 'manager',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('user_roles')->insert([
            'id' => 3,
            'roleName' => 'teacher',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('user_roles')->insert([
            'id' => 4,
            'roleName' => 'parent',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('user_roles')->insert([
            'id' => 5,
            'roleName' => 'student',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('user_roles')->insert([
            'id' => 6,
            'roleName' => 'employee',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
        DB::table('user_roles')->insert([
            'id' => 7,
            'roleName' => 'banzhuren',
            'created_at' => '2021-06-07 00:13:23',
            'updated_at' => '2021-06-07 00:13:23'
        ]);
    }
}
