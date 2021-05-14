<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('contactUserId')->nullable();
            $table->unsignedBigInteger('roomId')->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contactUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('roomId')->references('id')->on('chat_rooms')->onDelete('cascade');
            $table->unsignedBigInteger('new_msg_count')->default('0');
            $table->string('last_message',1000)->nullable();
            $table->char('last_time')->nullable();
            $table->unsignedBigInteger('last_sender')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
