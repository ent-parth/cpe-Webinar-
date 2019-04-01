<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\SpeakerResetPasswordToken;
use App\Helpers\CommonHelper;
use Storage;
use Session;

class Speaker extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'first_name', 'last_name', 'email', 'password', 'avatar', 'status', 'contact_no', 'country_id', 'state_id', 'city_id', 'zipcode', 'expertise', 'about_speaker', 'about_company', 'created_by', 'modified_by' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }

    public function sendPasswordResetNotification($token) {
        $speaker = $this->select('id', 'first_name', 'last_name', 'email')->where('email', Session::get('email'))->first();
        $this->notify(new SpeakerResetPasswordToken($token, 'reset-your-password', $speaker));
    }

    public function getAvatarUrlAttribute() {
        $imagePath = config('constants.IMAGE_PATH.SPEAKER_AVATAR') . $this->attributes['avatar'];

        $disk = Storage::disk(config('constants.IMAGE_PATH.DRIVER'));
        if (isset($this->attributes['avatar']) && !empty($this->attributes['avatar']) && $disk->exists($imagePath)) {
            return Storage::url(config('constants.IMAGE_PATH.SPEAKER_AVATAR') . $this->attributes['avatar']);
        } else {
            return Storage::url(config('constants.IMAGE_PATH.GENERAL_IMAGE') . config('constants.DEFAULT_IMAGE_NAME.AVATAR'));
        }
    }

    /**
     * Upload the logo image and get its name
     * 
     * @param type $logo
    */
    public function setAvatarAttribute($avatar)
    {
        if (isset($avatar) && !empty($avatar)) {
            $this->attributes['avatar'] = CommonHelper::saveImage(config('constants.IMAGE_PATH.SPEAKER_AVATAR'), $avatar);
        } else {
            $this->attributes['avatar'] = $this->avatar;
        }
    }
    
    /**
     * Hash password by bcrypt before save in database.
     *
     * @param type $password
     */
	public function setPasswordAttribute($password)
	{
	   if (isset($password)) {
	       $this->attributes['password'] = bcrypt($password);
	   }
	}

	/**
	 *
	 * @param type $query
	 * @return type Illuminate\Support\Collection
	 */
	public function scopeActive($query) {
	    return $query->where('status', '=', config('constants.STATUS.STATUS_ACTIVE'));
	}

	public function scopeNotDeleted($query) {
	    return $query->where('status', '<>', config('constants.STATUS.STATUS_DELETE'));
	}

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
