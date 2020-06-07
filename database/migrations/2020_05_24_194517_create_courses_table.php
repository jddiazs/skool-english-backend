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
            $table->string('author', 255);
            $table->longText('description');
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('video_url', 255);
            $table->foreign('video_attach_id', 255)->references('id')->on('attachments');
            $table->foreign('audio_attach_id', 255)->references('id')->on('attachments');
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
