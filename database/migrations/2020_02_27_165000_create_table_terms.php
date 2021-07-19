<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( !Schema::hasTable('warranty') ) {
            Schema::create('warranty', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';
                $table->bigIncrements('id');
                $table->text('name')->nullable();
                $table->date('birthday')->nullable();
                $table->string('no')->nullable();
                $table->text('street')->nullable();
                $table->integer('province')->nullable();
                $table->integer('district')->nullable();
                $table->integer('subdistrict')->nullable();
                $table->integer('zipcode')->nullable();
                $table->string('email')->nullable();
                $table->string('telephone')->nullable();
                $table->string('film')->nullable();
                $table->date('installation_date')->nullable();
                $table->text('body_no')->nullable();
                $table->text('register_no')->nullable();
                $table->text('car')->nullable();
                $table->text('content_TH')->nullable();
                $table->text('content_EN')->nullable();
                $table->dateTime('created')->nullable();
                $table->timestamp('updated');
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
        Schema::dropIfExists('warranty');
    }
}
