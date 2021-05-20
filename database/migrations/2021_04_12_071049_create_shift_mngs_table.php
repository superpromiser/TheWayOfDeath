<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftMngsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_mngs', function (Blueprint $table) {
            $table->id();
            $table->char('prevName');
            $table->unsignedBigInteger('prevNameId');
            $table->foreign('prevNameId')->references('id')->on('users')->onDelete('cascade');
            $table->char('nextName');
            $table->unsignedBigInteger('nextNameId');
            $table->foreign('nextNameId')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('schoolId');
            $table->tinyInteger('lessonId')->nullable();
            $table->char('scheduleDate');
            $table->string('itemList')->nullable();
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
        Schema::dropIfExists('shift_mngs');
    }
}
