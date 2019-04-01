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
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email');
            $table->string('password');
            $table->string('contact_no', 25);
            $table->string('firm_name', 255);
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('zipcode', 10);
            $table->integer('timezone_id');
            $table->integer('user_type');
            $table->string('designation', 255)->nullable();
            $table->string('ptin_number', 255)->nullable();
            $table->integer('credit')->nullable();
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->enum('status', ['active','inactive','delete'])->default('active');
            $table->rememberToken();
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
