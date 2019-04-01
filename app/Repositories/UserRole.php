<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class UserRole
 * @package App\Repositories
 */
class UserRole extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'role_user';

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
    

    /**
     * Get the restaurant's live_date and make it less ugly :)
     *
     * @param $date
     * @param string $format
     * @return bool|string
     */
    
}
