<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regnames', function (Blueprint $table) {
            $table->id();
            $table->char('title');
            $table->char('startTime');
            $table->char('endTime');
            $table->json('viewList');
            $table->json('inputTypeList');
            $table->boolean('checkFlag');
            $table->LONGTEXT('content');
            $table->tinyInteger('schoolId');
            $table->tinyInteger('lessonId');
            $table->unsignedBigInteger('postId');
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
        Schema::dropIfExists('regnames');
    }
}
