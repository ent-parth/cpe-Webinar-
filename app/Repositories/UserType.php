<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class CourseLevel
 * @package App\Repositories
 */
class UserType extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'user_types';

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
