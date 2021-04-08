<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('scheduleSettingId');
            $table->foreign('scheduleSettingId')->references('id')->on('schedule_settings')->onDelete('cascade');
            $table->unsignedBigInteger('teacherId');
            $table->foreign('teacherId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('schoolId');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->json('lessons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_teachers');
    }
}
