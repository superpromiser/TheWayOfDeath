<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        /**
        * userRole seeder.
        */
        $this->call(UserRoleTableSeeder::class);

        /**
        * user seeder.
        */
        $this->call(UserTableSeeder::class);

        /**
        * school, grade, lesson seeder.
        */
        $this->call(SchoolTableSeeder::class);
        
        /**
        * stuff seeder.
        */
        $this->call(SecondUserTableSeeder::class);
        
        /**
        * timetable seeder.
        */
        $this->call(TimeTableSeeder::class);
        
    }
}
