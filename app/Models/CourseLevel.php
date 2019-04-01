<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLevel extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'status', 'created_by', 'modified_by'
    ];

    /**
     * Get the only active records
     * 
     * @param type $query
     * @return type Illuminate\Support\Collection
     */
    public function scopeActive($query)
    {
        return $query->where('status', '=', config('constants.STATUS.STATUS_ACTIVE'));
    }

    /**
     * Get the all Course Level list.
     * 
     * @return type
     */
    public static function getCourseLevel()
    {
        return CourseLevel::active()->pluck('name', 'id');
    }

    /**
     * Get the not deleted records
     * 
     * @param type $query
     * @return type
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('status', '<>', config('constants.STATUS.STATUS_DELETE'));
    }
}
