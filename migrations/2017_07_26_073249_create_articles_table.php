<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('articles')){
            Schema::create('articles', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('title');
                $table->string('keyword')->nullable();
                $table->string('source')->nullable();
                $table->string('excerpt')->nullable(); //摘要

                $table->text('content')->nullable();
                $table->boolean('recommended')->default(false);
                $table->integer('order')->default(0);
                $table->integer('status')->default(\Module\Content\Models\Article::STATUS_NORMAL);

                $table->dateTime('push_time')->nullable();

                $table->string('pic')->nullable();

                $table->integer('member_id');
                $table->integer('click_count')->default(0);
                $table->integer('comment_count')->default(0);

                $table->string('author')->nullable();

                $table->softDeletes();
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
        Schema::dropIfExists('articles');
    }
}
