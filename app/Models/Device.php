<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{

    protected $fillable = [
        'id', 'user_id', 'device_id', 'device_token', 'device_name', 'platform', 'is_login'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
