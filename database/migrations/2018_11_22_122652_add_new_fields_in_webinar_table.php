<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsInWebinarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webinars', function($table) {
            $table->date('recorded_date')->after('date');
            $table->date('offered_date')->after('recorded_date');
            $table->string('gov_course_approved_id',100)->after('offered_date');
            $table->text('testimonial')->after('gov_course_approved_id');
            $table->text('learning_objectives')->after('testimonial');
            $table->text('refund_and_cancellations_policy')->after('learning_objectives');
            $table->string('video_file_name',255)->after('refund_and_cancellations_policy');
            $table->string('video_file_type',50)->after('video_file_name');
            $table->string('video_file_original_name',255)->after('video_file_type');
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
            $table->dropColumn('recorded_date');
            $table->dropColumn('offered_date');
            $table->dropColumn('gov_course_approved_id');
            $table->dropColumn('testimonial');
            $table->dropColumn('learning_objectives');
            $table->dropColumn('refund_and_cancellations_policy');
            $table->dropColumn('video_file_name');
            $table->dropColumn('video_file_type');
            $table->dropColumn('video_file_original_name');
        });
        
    }
}
