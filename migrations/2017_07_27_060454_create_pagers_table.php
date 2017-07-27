<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('pagers')){
            Schema::create('pagers', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');

                $table->string('name', 255);
                $table->text('content')->nullable();
                $table->string('tag', 25)->nullable()->unique();
                $table->text('additional')->nullable();

                $table->string('keyword')->nullable();
                $table->string('description')->nullable();

                $table->string('template')->nullable();
                $table->integer('category_id')->nullable();

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
        Schema::dropIfExists('pagers');
    }
}
