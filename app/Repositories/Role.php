<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\EntrustRole;
/**
 * Class Role
 * @package Role
 */
class Role extends EntrustRole
{
	use EntrustUserTrait;
    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * $timestamps false to avoid auto insert of default date]
     *
     * @var boolean
     */
    public $timestamps = false;

    protected $guarded = ['id'];
  
}
