<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tag', 'user_type', 'status', 'created_by', 'modified_by'
    ];

    public function users()
    {
        return $this->belongsToMany(Administrator::class)->withTimestamps();
    }
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
     * Get the all tag list.
     * 
     * @return type
     */
    public static function getTag()
    {
        return Country::active()->pluck('name', 'id');
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
