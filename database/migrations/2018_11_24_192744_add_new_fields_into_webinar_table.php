<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsIntoWebinarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::table('webinars', function($table) 
        {
            $table->enum('admin_status', ['None','Approved','Reject'])->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    public function down()
    {
        Schema::table('webinars', function($table) 
        {
            $table->dropColumn('admin_status');
        });
    }
}
