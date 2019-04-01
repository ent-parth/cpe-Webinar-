<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebinarDocuments extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'webinar_id' , 'document', 'document_type', 'status','created_by','modified_by','created_at','updated_at'
    ];

    
}
