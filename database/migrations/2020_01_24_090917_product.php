<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_product')) {
            
            Schema::create('tb_product',function(Blueprint $table){
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';
                $table->bigIncrements('id');
                $table->bigInteger('category1_id')->nullable();
                $table->bigInteger('category2_id')->nullable();
                $table->char('type',255)->nullable();
                $table->char('name_th',255)->nullable();
                $table->char('name_en',255)->nullable();
                $table->text('caption_th',255)->nullable();
                $table->text('caption_en',255)->nullable();
                $table->longText('detail_th')->nullable();
                $table->longText('detail_en')->nullable();
                $table->longText('image')->nullable();
                $table->text('video',255)->nullable();
                $table->text('percent',255)->nullable();
                $table->decimal('price',10,2)->nullable();
                $table->decimal('discount',10,2)->nullable();
                $table->bigInteger('sort')->nullable();
                $table->enum('status',['on','off'])->nullable();
                $table->enum('new',['on','off'])->nullable();
                $table->enum('recommend',['on','off'])->nullable();
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
        Schema::dropIfExists('tb_product');
    }
}
