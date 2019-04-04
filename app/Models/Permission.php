<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'parent_id', 'name', 'display_name', 'permission_key', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '=', config('constants.STATUS.STATUS_ACTIVE'));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
    
    public function administrators()
    {
        return $this->belongsToMany(Administrator::class)->withTimestamps();
    }

    /**
     * Parent relation on self table
     * 
     * @return type
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Child relation
     * 
     * @return type
     */
    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public static function getPermission()
    {
        return Permission::active()
                        ->orderBy('name', 'ASC')
                        ->get()->toArray();
    }

    public static function getPermissionList()
    {
        return Permission::active()->orderBy('name', 'ASC')->get()->toArray();
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('status', '<>', config('constants.STATUS.STATUS_DELETE'));
    }
}
