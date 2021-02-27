<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCarBrand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( !Schema::hasTable('tb_car_brand') ) {
            Schema::create('tb_car_brand', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name_th')->nullable();
                $table->string('name_en')->nullable();
                $table->text('caption_th')->nullable();
                $table->text('caption_en')->nullable();
                $table->text('image')->nullable();
                $table->bigInteger('sort')->nullable();
                $table->enum('status',['on','off'])->default('on');
                $table->dateTime('created')->nullable();
                $table->timestamp('updated')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_car_brand');
    }
}
