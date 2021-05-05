<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contentId');
            $table->unsignedBigInteger('userId');
            $table->char('tempTitle')->nullable();
            $table->char('description')->nullable();
            // $table->char('imgUrl');
            $table->tinyInteger('tempType');
            $table->json('content')->nullable();
            $table->tinyInteger('schoolId');
            $table->tinyInteger('lessonId')->nullable();
            $table->foreign('contentId')->references('id')->on('contents')->onDelete('cascade');
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
        Schema::dropIfExists('templates');
    }
}
