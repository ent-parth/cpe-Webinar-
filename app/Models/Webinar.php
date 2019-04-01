<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name' , 'webinar_type', 'description', 'date', 'goto_meeting_code', 'time', 'faq','cpe_credit','status','created_by','modified_by','created_at','updated_at','recorded_date','offered_date','gov_course_approved_id','testimonial','learning_objectives','refund_and_cancellations_policy','video_file_name','video_file_type','video_file_original_name'
    ];

    
    /**
     * Get the only active records
     * 
     * @param type $query
     * @return type Illuminate\Support\Collection
     */
    public function scopeActive($query)
    {
        return $query->where('webinars.status', '=', config('constants.STATUS.STATUS_ACTIVE'));
    }

    /**
     * Get the not deleted records
     * 
     * @param type $query
     * @return type
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('webinars.status', '<>', config('constants.STATUS.STATUS_DELETE'));
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
