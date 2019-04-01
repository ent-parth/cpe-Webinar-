<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAndDeleteNewFieldsIntoWebinar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webinars', function($table) {
            $table->dropColumn('hours');
            $table->dropColumn('minute');
            $table->string('time',10)->after('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webinars', function($table) {
            $table->string('minute', 255)->after('hours');
            $table->text('faq')->after('minute');
        });

    }
}
