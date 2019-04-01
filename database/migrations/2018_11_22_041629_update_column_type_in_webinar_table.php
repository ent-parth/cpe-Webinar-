<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnTypeInWebinarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('webinars', 'time'))
        {
            Schema::table('webinars', function($table) {
                $table->dropColumn('time');
            });
        }
        Schema::table('webinars', function($table) {
            $table->time('time')->after('date');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('webinars', 'time'))
        {
            Schema::table('webinars', function($table) {
                $table->dropColumn('time');
            });
        }
        Schema::table('webinars', function($table) {
            $table->string('time',10)->after('date');
        });
    }
}
