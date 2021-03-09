<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('schoolId')->nullable();
            $table->string('gender')->nullable();
            $table->string('nation')->nullable();
            $table->unsignedBigInteger('cardNum')->nullable()->unique();
            $table->json('familyAddress')->nullable();
            $table->json('residenceAddress')->nullable();
            $table->string('fatherName')->nullable();
            $table->string('fatherPhone')->nullable();
            $table->string('fatherJob')->nullable();
            $table->string('introduce')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->timestamp('statusFrom')->nullable();
            $table->timestamp('statusTo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['schoolId']);
            $table->dropColumn(['gender']);
            $table->dropColumn(['nation']);
            $table->dropColumn(['cardNum']);
            $table->dropColumn(['familyAddress']);
            $table->dropColumn(['residenceAddress']);
            $table->dropColumn(['fatherName']);
            $table->dropColumn(['fatherPhone']);
            $table->dropColumn(['fatherJob']);
            $table->dropColumn(['introduce']);
            $table->dropColumn(['birthday']);
            $table->dropColumn(['status']);
            $table->dropColumn(['statusFrom']);
            $table->dropColumn(['statusTo']);
        });
    }
}
