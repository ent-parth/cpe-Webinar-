<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class WebinarSelfstudyVideoDuration
 * @package App\Repositories
 */
class WebinarSelfstudyVideoDuration extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'webinar_selfstudy_video_duration';

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
