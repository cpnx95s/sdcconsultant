<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_contact')) {
            
            Schema::create('tb_contact',function(Blueprint $table){
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';
                $table->bigIncrements('id');
                $table->char('address',255)->nullable();
                $table->char('phone',255)->nullable();
                $table->char('tel',255)->nullable();
                $table->char('fax',255)->nullable();
                $table->char('email',255)->nullable();
                $table->char('line_id',255)->nullable();
                $table->char('facebook',255)->nullable();
                $table->char('line',255)->nullable();
                $table->char('twitter',255)->nullable();
                $table->char('instagram',255)->nullable();
                $table->longText('map')->nullable();
                $table->longText('image')->nullable();
                $table->longText('qr_code')->nullable();
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
        Schema::dropIfExists('tb_contact');
    }
}
