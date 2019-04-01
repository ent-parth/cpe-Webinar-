<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class Restaurant
 * @package Kukd\Repositories
 */
class PermissionsRole extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'permission_role';

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
