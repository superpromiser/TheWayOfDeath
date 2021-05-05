<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('lessonId');
            $table->foreign('lessonId')->references('id')->on('lessons')->onDelete('cascade');
            $table->unsignedBigInteger('schoolId');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->unsignedBigInteger('teacherId')->nullable();
            $table->foreign('teacherId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('leaderId')->nullable();
            $table->foreign('leaderId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('postId')->nullable();
            $table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
            $table->string('name');
            $table->string('avatar')->default('/');
            $table->json('member');
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
        Schema::dropIfExists('return_teams');
    }
}
