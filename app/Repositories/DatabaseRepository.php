<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DatabaseRepository
 * @package Kukd\Repositories
 */
class DatabaseRepository extends Model
{

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}