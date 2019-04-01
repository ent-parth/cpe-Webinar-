<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CompanyResetPasswordToken;
use Storage;
use Session;

class Companies extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 
	 /**
     * @var string
     */
    protected $table = 'company_user';
	
	
    protected $fillable = [
        'id', 'email', 'password', 'company_name', 'name', 'person_email', 'phone', 'phone_ext', 'mobile', 'designation', 'website', 'logo', 'about_company', 'credit_card_number', 'name_on_card', 'card_expiry_date', 'card_cvv', 'status',  'created_at', 'updated_at', 'country_id', 'state_id', 'city_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    

    public function sendPasswordResetNotification($token) {
        $company = $this->select('id', 'company_name', 'email')->where('email', Session::get('email'))->first();
        $this->notify(new CompanyResetPasswordToken($token, 'reset-your-password', $company));
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

    
}
