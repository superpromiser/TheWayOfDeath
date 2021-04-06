<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voting_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->char('tempTitle');
            $table->char('title');
            $table->char('description');
            $table->char('imgUrl');
            $table->longText('content');
            $table->tinyInteger('schoolId');
            $table->tinyInteger('lessonId')->nullable();
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
        Schema::dropIfExists('voting_temps');
    }
}
