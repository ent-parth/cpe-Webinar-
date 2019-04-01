<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class WebinarLike
 * @package App\Repositories
 */
class WebinarLike extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'webinar_like';

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
