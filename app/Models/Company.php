<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CommonHelper;
use Storage;

class Company extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','person_name','person_contact_number','email', 'name', 'logo', 'website', 'contact_number', 'description', 'status', 'country_id', 'state_id', 'city_id', 'created_by', 'modified_by'
    ];


    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function getLogoUrlAttribute($logo = null) {
        if ($logo === null) {
            $logo = !empty($this->attributes['logo']) ? $this->attributes['logo'] : '';
        }

        $imagePath = config('constants.IMAGE_PATH.COMPANY_LOGO') . $logo;

        $disk = Storage::disk(config('constants.IMAGE_PATH.DRIVER'));
        if (isset($logo) && !empty($logo) && $disk->exists($imagePath)) {
            return Storage::url(config('constants.IMAGE_PATH.COMPANY_LOGO') . $logo);
        } else {
            return Storage::url(config('constants.IMAGE_PATH.GENERAL_IMAGE') . config('constants.DEFAULT_IMAGE_NAME.AVATAR'));
        }
    }

    /**
     * Upload the logo image and get its name
     * 
     * @param type $logo
    */
    public function setLogoAttribute($logo)
    {
        if (isset($logo) && !empty($logo)) {
            $this->attributes['logo'] = CommonHelper::saveImage(config('constants.IMAGE_PATH.COMPANY_LOGO'), $logo);
        } else {
            $this->attributes['logo'] = $this->logo;
        }
    }
    


    /**
     *
     * @param type $query
     * @return type Illuminate\Support\Collection
     */
    public function scopeActive($query)
    {
        return $query->where('companies.status', '=', config('constants.STATUS.STATUS_ACTIVE'));
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('companies.status', '<>', config('constants.STATUS.STATUS_DELETE'));
    }

    public static function getCompany()
    {
        return Company::active()->pluck('name', 'id');
    }

    public function speaker()
    {
        return $this->hasMany(Speaker::class);
    }
    static function getCompanyArray() {
        return Company::select('id', 'name')->get()->toArray();
    }
}
