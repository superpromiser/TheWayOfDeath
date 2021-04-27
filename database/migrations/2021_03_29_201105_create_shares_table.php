<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->LONGTEXT('content');
            $table->enum('publishType', ['pub', 'pvt', 'spec'])->default('pub');
            $table->json('specUsers')->nullable();
            $table->unsignedBigInteger('postId');
            $table->tinyInteger('schoolId');
            $table->tinyInteger('lessonId')->nullable();
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
        Schema::dropIfExists('shares');
    }
}
