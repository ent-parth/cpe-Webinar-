<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;
use Zizaco\Entrust\EntrustPermission;


/**
 * Class Permissions
 * @package App\Repositories
 */
class Permissions extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'permissions';

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
