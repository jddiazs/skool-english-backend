<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable($value = false);
            $table->string('slug', 255)->nullable($value = false)->unique();
            $table->boolean('status')->default(true);
            $table->string('author', 255)->nullable($value = true);
            $table->longText('description')->nullable($value = true);
            $table->bigInteger('created_by')->unsigned()->nullable($value = true);
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('video_url', 255)->nullable($value = true);
            $table->bigInteger('video_attach_id')->nullable($value = true);
            $table->bigInteger('audio_attach_id')->nullable($value = true);
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
        Schema::dropIfExists('courses');
    }
}
