<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class CompanyLike
 * @package App\Repositories
 */
class CompanyLike extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'company_like';

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
