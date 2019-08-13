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
        Schema::create('articles', function (Blueprint $table) {
            $table->string('article_id')->unique();
            $table->text('title');
            $table->text('description');
            $table->longtext('content');
            $table->string('score')->default("N");
            $table->string('author')->nullable();
            $table->dateTime('published_on');
            $table->string('source');
            $table->text('url')->nullable();
            $table->text('picture_link')->nullable();
            $table->boolean('is_tutorial')->default(false);
            $table->timestamps();
        });
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
