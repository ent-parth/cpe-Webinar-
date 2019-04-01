<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
     * Get the all country list.
     * 
     * @return type
     */
    public static function getCountry()
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

    public function city()
    {
        return $this->hasMany(City::class);
    }

    public function state()
    {
        return $this->hasMany(State::class);
    }

    static function getCountryArray() {
        return Country::select('id', 'name')->active()->get()->toArray();
    }
}
