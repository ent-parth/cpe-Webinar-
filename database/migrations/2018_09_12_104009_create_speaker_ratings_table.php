<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeakerRatingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speaker_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->float('ratings', 2, 2);
            $table->tinyInteger('status')->comment('0 => InActive, 1 => Active, 2 => Delete')->default(config('constants.ADMIN_CONST.STATUS_ACTIVE'));
            $table->integer('created_by');
            $table->integer('modified_by');
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
        Schema::dropIfExists('speaker_ratings');
    }
}
