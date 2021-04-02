<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('startTime')->nullable(9,0,0);
            $table->time('endTime')->nullable(20,0,0);
            $table->char('type')->nullable();
            $table->unsignedBigInteger('schoolId');
            $table->unsignedBigInteger('gradeId');
            $table->unsignedBigInteger('lessonId');
            $table->unsignedBigInteger('userId');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('gradeId')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('lessonId')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('attendances');
    }
}
