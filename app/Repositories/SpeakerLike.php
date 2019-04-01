<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class SpeakerLike
 * @package App\Repositories
 */
class SpeakerLike extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'speaker_like';

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
