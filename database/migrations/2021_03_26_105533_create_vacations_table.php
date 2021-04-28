<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->char('studentName');
            $table->char('teacherName');
            $table->string('startTime');
            $table->string('endTime');
            $table->string('reason');
            $table->boolean('reasonFlag');
            $table->boolean('isHeat');
            $table->string('painDesc')->nullable();
            $table->char('status')->default('pending');
            $table->unsignedBigInteger('postId');
            $table->unsignedBigInteger('studentId');
            $table->unsignedBigInteger('schoolId');
            $table->unsignedBigInteger('lessonId');
            $table->unsignedBigInteger('teacherId');
            $table->foreign('studentId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('lessonId')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('teacherId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
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
        Schema::dropIfExists('vacations');
    }
}
