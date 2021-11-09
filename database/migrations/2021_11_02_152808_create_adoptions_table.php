<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoptions', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('listed_by');
            $table->unsignedBigInteger('adopted_by')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('listed_by')->references('id')->on('users');
            $table->foreign('adopted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adoptions');
    }
}
