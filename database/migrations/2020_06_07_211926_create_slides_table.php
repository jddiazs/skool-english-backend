<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('content');
            $table->string('type', 255)->nullable($value = true);
            $table->boolean('status')->default(true);
            $table->bigInteger('unit_id')->unsigned()->nullable($value = true);
            $table->foreign('unit_id')->references('id')->on('units');
            $table->bigInteger('course_id')->unsigned()->nullable($value = true);
            $table->foreign('course_id')->references('id')->on('courses');
            $table->bigInteger('created_by')->unsigned()->nullable($value = true);
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('slides');
    }
}
