<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CommonHelper;

class Team extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name' , 'last_name', 'email', 'designation', 'avatar', 'description', 'status', 'created_by', 'modified_by'
    ];

    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Upload the logo image and get its name
     * 
     * @param type $logo
    */
    public function setAvatarAttribute($avatar)
    {
        if (isset($avatar) && !empty($avatar)) {
            $this->attributes['avatar'] = CommonHelper::saveImage(config('constants.IMAGE_PATH.TEAM_AVATAR'), $avatar);
        } else {
            $this->attributes['avatar'] = $this->avatar;
        }
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
