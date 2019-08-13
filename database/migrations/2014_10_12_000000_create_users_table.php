<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->boolean('is_admin')->default(false); 
            $table->boolean('can_be_contacted')->default(false); 
            $table->text('sources')->nullable();
            $table->text('categories')->nullable();
            $table->double('reputation')->default(0.5);
            $table->text('custom')->nullable();

            $table->text('information')->nullable();
            $table->text('survey_hexad')->nullable();
            $table->text('survey_media')->nullable();
            $table->text('survey_sus')->nullable();
            $table->text('survey_end')->nullable();

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
        Schema::dropIfExists('users');
    }
}
