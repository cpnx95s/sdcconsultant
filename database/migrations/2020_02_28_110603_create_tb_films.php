<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFilms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_films', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name_th')->nullable();
            $table->text('name_en')->nullable();
            $table->text('caption_th')->nullable();
            $table->text('caption_en')->nullable();
            $table->text('image')->nullable();
            $table->bigInteger('sort')->nullable();
            $table->enum('status',['on','off'])->default('on');
            $table->dateTime('created')->nullable();
            $table->timestamp('updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_films');
    }
}
