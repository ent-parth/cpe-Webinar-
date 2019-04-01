<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class CompanyPasswordReset
 * @package App\Repositories
 */
class CompanyPasswordReset extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'companies_password_resets';

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
