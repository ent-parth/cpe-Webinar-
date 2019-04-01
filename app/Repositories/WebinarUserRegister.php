<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class WebinarUserRegister
 * @package App\Repositories
 */
class WebinarUserRegister extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'webinar_user_register';

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
