<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendlyLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('friendly_links')){
            Schema::create('friendly_links', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');

                $table->string('name');
                $table->string('tag',25);
                $table->text('link');
                $table->string('target',18)->nullable();
                $table->boolean('show')->default(true); //1显示 0不显示
                $table->integer('order')->default(0); //ASC

                $table->timestamps();
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
        Schema::dropIfExists('friendly_links');
    }
}
