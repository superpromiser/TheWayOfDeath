<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecognitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recognitions', function (Blueprint $table) {
            $table->id();
            $table->char('type');
            $table->string('students');
            $table->char('awardTitle');
            $table->char('publishDate');
            $table->string('description');
            $table->char('imgUrl');
            // $table->TinyInteger('classId');
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
        Schema::dropIfExists('recognitions');
    }
}
