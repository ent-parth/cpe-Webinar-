<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{

    public $table = 'contactus';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'subject', 'description', 'status', 'created_by', 'modified_by'
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
