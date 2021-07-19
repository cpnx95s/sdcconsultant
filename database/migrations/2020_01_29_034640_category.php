<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Category extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_category')) {
            
            Schema::create('tb_category',function(Blueprint $table){
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';
                $table->bigIncrements('id');
                $table->bigInteger('_id')->nullable();
                $table->char('position',100)->nullable();
                $table->char('type',100)->nullable();
                $table->char('name_th',255)->nullable();
                $table->char('name_en',255)->nullable();
                $table->char('caption_th',255)->nullable();
                $table->char('caption_en',255)->nullable();
                $table->longText('detail_th')->nullable();
                $table->longText('detail_en')->nullable();
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
        Schema::dropIfExists('tb_category');
    }
}
