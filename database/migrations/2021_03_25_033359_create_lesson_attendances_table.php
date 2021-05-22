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
            $table->unsignedBigInteger('schoolId');
            $table->unsignedBigInteger('gradeId');
            $table->unsignedBigInteger('lessonId');
            $table->LONGTEXT('resultArr');
            $table->unsignedBigInteger('postId');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('gradeId')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('lessonId')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
            $table->integer('resultNormal')->default(0);
            $table->integer('resultLate')->default(0);
            $table->integer('resultMiss')->default(0);
            $table->integer('resultRest')->default(0);
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
