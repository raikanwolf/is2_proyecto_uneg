<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('career_id');
            $table->unsignedBigInteger('schedules_id');
            $table->string('course_type');
            $table->integer('credit_units');
            $table->timestamps();

            $table->foreign('professor_id')->references('id')->on('professors');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('career_id')->references('id')->on('careers');
            $table->foreign('schedules_id')->references('id')->on('schedules');
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
};
