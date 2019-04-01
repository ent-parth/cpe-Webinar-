<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdministratorResetPasswordToken;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Storage;
use Session;

class Administrator extends Authenticatable {

    use Notifiable;
	use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'first_name', 'last_name', 'email', 'password', 'avatar', 'status', 'contact_no', 'created_by', 'modified_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function sendPasswordResetNotification($token) {
        $administrator = $this->select('id', 'first_name', 'last_name', 'email')->where('email', Session::get('email'))->first();
        $this->notify(new AdministratorResetPasswordToken($token, 'reset-your-password', $administrator));
    }

    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarUrlAttribute() {
        $imagePath = config('constants.IMAGE_PATH.AVATAR') . $this->attributes['avatar'];

        $disk = Storage::disk(config('constants.IMAGE_PATH.DRIVER'));
        if (isset($this->attributes['avatar']) && !empty($this->attributes['avatar']) && $disk->exists($imagePath)) {
            return Storage::url(config('constants.IMAGE_PATH.AVATAR') . $this->attributes['avatar']);
        } else {
            return Storage::url(config('constants.IMAGE_PATH.GENERAL_IMAGE') . config('constants.DEFAULT_IMAGE_NAME.AVATAR'));
        }
    }

    public function getAvatarNameAttribute() {
        return "{$this->avatar}";
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

    /**
     *
     * @param type $query
     * @return type Illuminate\Support\Collection
     */
    public static function getAdministratorPermission($administratorId = null) {
        return Administrator::with('permissions')->findOrFail($administratorId)->toArray();
    }
}
