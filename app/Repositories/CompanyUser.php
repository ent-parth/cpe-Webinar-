<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class CompanyUser
 * @package App\Repositories
 */
class CompanyUser extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'company_user';

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
