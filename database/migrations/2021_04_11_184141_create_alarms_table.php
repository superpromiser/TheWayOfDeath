<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->string('type');
            $table->LONGTEXT('content');
            $table->unsignedBigInteger('guestId')->nullable();
            $table->foreign('guestId')->references('id')->on('guests')->onDelete('cascade');
            $table->unsignedBigInteger('returnTeamId')->nullable();
            $table->foreign('returnTeamId')->references('id')->on('return_teams')->onDelete('cascade');
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
        Schema::dropIfExists('alarms');
    }
}
