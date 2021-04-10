<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->LONGTEXT('avatar');
            $table->unsignedBigInteger('cardNum');
            $table->string('phoneNumber');
            $table->string('memberName');
            $table->string('memberPhone');
            $table->unsignedBigInteger('memberSchoolId')->nullable();
            $table->foreign('memberSchoolId')->references('id')->on('schools')->onDelete('cascade');
            $table->unsignedBigInteger('memberGradeId')->nullable();
            $table->foreign('memberGradeId')->references('id')->on('grades')->onDelete('cascade');
            $table->unsignedBigInteger('memberLessonId')->nullable();
            $table->foreign('memberLessonId')->references('id')->on('lessons')->onDelete('cascade');
            $table->dateTime('meetingDate');
            $table->string('meetingReason');
            $table->enum('status', ['pending', 'allow', 'deny'])->default('pending');
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
        Schema::dropIfExists('guests');
    }
}
