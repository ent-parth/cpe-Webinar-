<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'country_id', 'name', 'status', 'created_by', 'modified_by'
    ];

    /**
     *
     * @param type $query
     * @return type Illuminate\Support\Collection
     */
    public function scopeActive($query)
    {
        return $query->where('status', '=', config('constants.STATUS.STATUS_ACTIVE'));
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('states.status', '<>', config('constants.STATUS.STATUS_DELETE'));
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->hasMany(City::class);
    }

    public static function getState($id = null)
    {
        return State::active()->where('country_id', '=', $id)->pluck('name', 'id');
    }

    static function getStateArray($id = null) {
        return State::select('id', 'name')->active()->where('country_id', '=', $id)->get()->toArray();
    }
}
