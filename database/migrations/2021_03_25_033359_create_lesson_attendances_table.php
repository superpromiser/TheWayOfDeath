<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_attendances', function (Blueprint $table) {
            $table->id();
            $table->date('attendanceDay');
            $table->char('attendanceTime');
            $table->unsignedBigInteger('lessonId');
            $table->LONGTEXT('resultArr');
            // $table->char('attendanceResult');
            // $table->char('studentName');
            // $table->char('other');
            $table->foreign('lessonId')->references('id')->on('lessons')->onDelete('cascade');
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
        Schema::dropIfExists('lesson_attendances');
    }
}
