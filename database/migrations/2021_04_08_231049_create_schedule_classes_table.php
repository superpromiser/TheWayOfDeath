<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('schoolId');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->unsignedBigInteger('gradeId');
            $table->foreign('gradeId')->references('id')->on('grades')->onDelete('cascade');
            $table->unsignedBigInteger('lessonId');
            $table->foreign('lessonId')->references('id')->on('lessons')->onDelete('cascade');
            $table->LONGTEXT('scheduleData');
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
        Schema::dropIfExists('schedule_classes');
    }
}
