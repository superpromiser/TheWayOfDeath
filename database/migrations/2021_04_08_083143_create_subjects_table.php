<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('schoolId');
            $table->foreign('schoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->unsignedBigInteger('sessionId');
            $table->foreign('sessionId')->references('id')->on('sessions')->onDelete('cascade');
            $table->string('subjectOrderName');
            $table->string('subjectOrderType');
            $table->char('startTime');
            $table->char('endTime');
            $table->date('subjectStartDate');
            $table->boolean('isActived')->default(false);
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
        Schema::dropIfExists('subjects');
    }
}
