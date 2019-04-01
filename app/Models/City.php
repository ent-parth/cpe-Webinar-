<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'country_id', 'state_id', 'name', 'status', 'created_by', 'modified_by'
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
        return $query->where('cities.status', '<>', config('constants.STATUS.STATUS_DELETE'));
    }

    public static function getCity($id = null)
    {
        return City::active()->where('state_id', '=', $id)->pluck('name', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    static function getCityArray($id = null) {
        return City::select('id', 'name')->active()->where('state_id', '=', $id)->get()->toArray();
    }
}
