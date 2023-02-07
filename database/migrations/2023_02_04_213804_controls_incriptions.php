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
        Schema::create('controls_incriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incription_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();

            $table->foreign('incription_id')->references('id')->on('incriptions');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controls_incriptions');
    }
};
