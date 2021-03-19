<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_settings', function (Blueprint $table) {
            $table->id();
            $table->char('subjectName');
            $table->unsignedBigInteger('subjectId');
            $table->char('teacherName');
            $table->unsignedBigInteger('teacherId');
            $table->char('lessonName');
            $table->unsignedBigInteger('lessonId');
            $table->unsignedBigInteger('schoolId');
            $table->unsignedBigInteger('userId');
            $table->timestamps();

            $table->foreign('subjectId')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacherId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lessonId')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_settings');
    }
}
