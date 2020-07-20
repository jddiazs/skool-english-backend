<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('unit_id')->unsigned()->nullable($value = true);
            $table->foreign('unit_id')->references('id')->on('units');
            $table->bigInteger('course_id')->unsigned()->nullable($value = true);
            $table->foreign('course_id')->references('id')->on('courses');
            $table->bigInteger('user_id')->unsigned()->nullable($value = true);
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('slide_id')->unsigned()->nullable($value = true);
            $table->foreign('slide_id')->references('id')->on('slides');
            $table->text('response_user')->nullable($value = true);
            $table->string('status', 255)->nullable($value = true);
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
        Schema::dropIfExists('slide_users');
    }
}
