<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplatesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('description');
            $table->string('subject');
            $table->string('slug');
            $table->tinyInteger('template_for')->nullable();
            $table->longText('template_text');
            $table->longText('keywords');
            $table->tinyInteger('status')->comment('0 => InActive, 1 => Active, 2 => Delete')->default(config('constants.ADMIN_CONST.STATUS_ACTIVE'));
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
        Schema::dropIfExists('email_templates');
    }
}
