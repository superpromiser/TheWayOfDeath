<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->id();
            $table->char('subjectName');
            $table->char('homeworkType');
            $table->longText('content');
            $table->char('deadline')->nullable();
            $table->char('monitorName')->nullable();
            $table->boolean('parentCheck')->nullable();
            $table->tinyInteger('schoolId');
            $table->tinyInteger('lessonId');
            $table->unsignedBigInteger('userId');
            $table->json('viewList')->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('postId')->nullable();
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
        Schema::dropIfExists('homeworks');
    }
}
