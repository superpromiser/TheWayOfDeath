<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homework_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('homeworkId');
            $table->unsignedBigInteger('userId');
            $table->longText('content');
            $table->char('homeworkType');
            $table->tinyInteger('schoolId');
            $table->tinyInteger('lessonId')->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('homeworkId')->references('id')->on('homeworks')->onDelete('cascade');
            $table->char('rating')->nullable();
            $table->longText('teacherAnswer')->nullable();
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
        Schema::dropIfExists('homework_results');
    }
}
