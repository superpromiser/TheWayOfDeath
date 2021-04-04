<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerVotingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_votings', function (Blueprint $table) {
            $table->id();
            $table->String('answerData');
            // $table->unsignedBigInteger('answerId');
            $table->unsignedBigInteger('postId');
            $table->unsignedBigInteger('userId');
            // $table->foreign('answerId')->references('id')->on('answers')->onDelete('cascade');
            $table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
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
        Schema::dropIfExists('answer_votings');
    }
}
