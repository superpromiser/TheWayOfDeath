<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodayDutiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('today_duties', function (Blueprint $table) {
            $table->id();
            $table->json('userList');
            $table->date('dutyDate');
            $table->unsignedBigInteger('schoolId');
            $table->unsignedBigInteger('lessonId');
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('postId');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('lessonId')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('today_duties');
    }
}
