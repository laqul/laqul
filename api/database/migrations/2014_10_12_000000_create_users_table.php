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
            $table->uuid('client_id')->index();
            $table->string('name');
            $table->string('email')->index();
            $table->string('avatar', 100)->default('default_avatar.jpg');
            $table->string('password');
            $table->string('timezone', 50);
            $table->boolean('active')->default(true);
            $table->unique(['client_id', 'email']);
            $table->softDeletes();
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
