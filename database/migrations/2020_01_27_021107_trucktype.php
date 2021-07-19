<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Trucktype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_trucktype')) {
            
            Schema::create('tb_trucktype',function(Blueprint $table){
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';
                $table->bigIncrements('id');
                $table->char('name_th',255)->nullable();
                $table->char('name_en',255)->nullable();
                $table->longText('image')->nullable();
                $table->bigInteger('sort')->nullable();
                $table->enum('status',['on','off'])->nullable();
                $table->dateTime('created')->nullable();
                $table->dateTime('updated')->nullable();
                $table->dateTime('deleted')->nullable();
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
        Schema::dropIfExists('tb_category1');
    }
}
