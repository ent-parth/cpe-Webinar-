<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebinarDocumentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinar_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('webinar_id');
            $table->string('document', 255);
            $table->string('document_type', 255);
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
        Schema::dropIfExists('webinar_documents');
    }
}
