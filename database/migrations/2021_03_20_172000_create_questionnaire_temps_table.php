<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_temps', function (Blueprint $table) {
            $table->id();
            $table->char('temTitle')->nullable();
            $table->char('title')->nullable();
            $table->char('description')->nullable();
            $table->char('imgUrl')->nullable();
            $table->LONGTEXT('content')->nullable();
            $table->TinyInteger('temType');
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger('tempId');
            // $table->foreign('tempId')->references('id')->on('templates')->onDelete('cascade');
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
        Schema::dropIfExists('questionnaire_temps');
    }
}
