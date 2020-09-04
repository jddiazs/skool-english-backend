<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('unit_id')->unsigned()->nullable($value = true);
            $table->foreign('unit_id')->references('id')->on('units');
            $table->bigInteger('course_id')->unsigned()->nullable($value = true);
            $table->foreign('course_id')->references('id')->on('courses');
            $table->bigInteger('slide_id')->unsigned();
            $table->foreign('slide_id')->references('id')->on('slides');
            $table->bigInteger('from_user_id')->unsigned();
            $table->foreign('from_user_id')->references('id')->on('users');
            $table->bigInteger('to_user_id')->unsigned()->nullable($value = true);
            $table->foreign('to_user_id')->references('id')->on('users');
            $table->text('messages');
            $table->unsignedBigInteger('parent_id')->nullable($value = true);
            $table->string('status', 255)->nullable($value = true);
            $table->string('from_user_name', 255)->nullable($value = true);
            $table->string('to_user_name', 255)->nullable($value = true);
            $table->timestamps();
 
            $table->foreign('parent_id')
                ->references('id')
                ->on('messages')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
