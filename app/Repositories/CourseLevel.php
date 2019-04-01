<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class CourseLevel
 * @package App\Repositories
 */
class CourseLevel extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'course_levels';

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
