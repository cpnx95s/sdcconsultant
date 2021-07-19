<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Menu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_menu')) {
            
            Schema::create('tb_menu',function(Blueprint $table){
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';
                $table->bigIncrements('id');
                $table->bigInteger('_id')->nullable();
                $table->char('name',255)->nullable();
                $table->text('url',255)->nullable();
                $table->text('icon',255)->nullable();
                $table->bigInteger('sort')->nullable();
                $table->enum('status',['on','off'])->nullable();
                $table->char('position',100)->nullable();
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
        Schema::dropIfExists('tb_menu');
    }
}
