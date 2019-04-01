<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnDatatypeInCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function($table) 
        {
            $table->dropColumn('email');
        });

        Schema::table('companies', function($table) 
        {
            $table->string('email',100)->after('person_contact_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function($table) 
        {
            $table->dropColumn('email');
        });

        Schema::table('companies', function($table) 
        {
            $table->text('email')->after('person_contact_number');
        });
    }
}
