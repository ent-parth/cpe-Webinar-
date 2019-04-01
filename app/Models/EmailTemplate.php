<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'description', 'subject', 'slug', 'template_for', 'template_text', 'keywords', 'status'
    ];

    public function scopeNotDeleted($query)
    {
        return $query->where('status', '<>', config('constants.ADMIN_CONST.STATUS_DELETE'));
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', config('constants.ADMIN_CONST.STATUS_ACTIVE'));
    }

    public function setKeywordsAttribute($value)
    {
        $this->attributes['keywords'] = serialize($value);
    }

    public function getKeywordsAttribute($value)
    {
        return unserialize($value);
    }

    public static function getEmailTemplate($slug = null)
    {
        return EmailTemplate::active()->select('subject', 'slug', 'template_text', 'status')->where('slug', $slug)->first();
    }
}
