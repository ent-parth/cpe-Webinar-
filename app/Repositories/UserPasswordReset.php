<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class UserPasswordReset
 * @package App\Repositories
 */
class UserPasswordReset extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'user_password_reset';

    /**
     * $timestamps false to avoid auto insert of default date]
     *
     * @var boolean
     */
    public $timestamps = false;

    protected $guarded = ['id'];

    /**
     * @return Eloquent\Relations\HasOne
     */
    
    
}
