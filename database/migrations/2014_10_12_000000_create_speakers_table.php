<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeakersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speakers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact_no', 25);
            $table->string('avatar', 255);
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->string('zipcode', 10);
            $table->text('expertise')->nullable();
            $table->text('about_speaker')->nullable();
            $table->text('about_company')->nullable();
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->enum('status', ['active','inactive','delete'])->default('inactive');
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
        Schema::dropIfExists('speakers');
    }
}
