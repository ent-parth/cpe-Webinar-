<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class SpeakerFollow
 * @package App\Repositories
 */
class SpeakerFollow extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'speaker_follow';

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
