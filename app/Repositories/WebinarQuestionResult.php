<?php namespace App\Repositories;

use Illuminate\Database\Eloquent;
use DateTime;

/**
 * Class WebinarQuestionResult
 * @package App\Repositories
 */
class WebinarQuestionResult extends DatabaseRepository
{

    /**
     * @var string
     */
    protected $table = 'webinar_question_result';

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
