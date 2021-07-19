<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Faq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_faq')) {
            
            Schema::create('tb_faq',function(Blueprint $table){
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';
                $table->bigIncrements('id');
                $table->char('question_th',255)->nullable();
                $table->char('question_en',255)->nullable();
                $table->longText('anwser_th')->nullable();
                $table->longText('anwser_en')->nullable();
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
        Schema::dropIfExists('tb_faq');
    }
}
