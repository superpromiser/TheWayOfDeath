<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->Date('checkInDate');
            $table->char('checkAttendanceType');
            $table->char('checkType');
            $table->unsignedBigInteger('studentId');
            $table->char('signal');
            $table->DateTime('startTime');
            $table->char('reason');
            $table->char('hospital');
            $table->unsignedBigInteger('userId');
            $table->foreign('studentId')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('check_ins');
    }
}
