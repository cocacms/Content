<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('article_categories')){
            Schema::create('article_categories', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->integer('article_id');
                $table->integer('category_id');
                $table->string('category_tag',25)->nullable();
                $table->primary(['article_id', 'category_id']);
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
        Schema::dropIfExists('article_categories');
    }
}
