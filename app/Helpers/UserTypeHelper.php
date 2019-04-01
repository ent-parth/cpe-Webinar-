<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class UserTypeHelper
{

    /**
     * status
     *
     * @var array
     */
    protected static $_status = [
        'cpa' => [
            'value' => 'cpa',
            'displayName' => 'CPA',
            'color' => '#fff',
            'class' => "badge badge-info",
        ],
        'enrolled agent' => [
            'value' => 'enrolled agent',
            'displayName' => 'Enrolled Agent',
            'color' => '#fff',
            'class' => 'badge badge-secondary'
        ],
        'bookkeeper' => [
            'value' => 'bookkeeper',
            'displayName' => 'Bookkeeper',
            'color' => '#fff',
            'class' => 'badge badge-success'
        ],
        'attorney' => [
            'value' => 'attorney',
            'displayName' => 'Attorney',
            'color' => '#fff',
            'class' => 'badge badge-success'
        ],
        'cfo' => [
            'value' => 'cfo',
            'displayName' => 'CFO',
            'color' => '#fff',
            'class' => 'badge badge-success'
        ],
        'business owner' => [
            'value' => 'business owner',
            'displayName' => 'Business Owner',
            'color' => '#fff',
            'class' => 'badge badge-success'
        ],
        'other' => [
            'value' => 'other',
            'displayName' => 'Other',
            'color' => '#fff',
            'class' => 'badge badge-success'
        ]
    ];

    /**
     * Returns the list of statuses in key:value pair
     *
     * @return array Array of Statuses
     */
    public static function getStatusesList()
    {
        $status = (new Collection(self::$_status))->pluck('displayName', 'value')->toArray();

        return $status;
    }

    /**
     * Returns user type for given id.
     *
     * @param int $value User type
     * @return string Display name of status
     */
    public static function getUserType($value = null)
    {
        if ($value === null) {
            return "";
        }

        $status = self::__getStatus($value);

        if ($status) {
            return $status['displayName'];
        }

        return '';
    }

    /**
     * Returns status color for given id.
     *
     * @param int $value Status ID
     * @return string Color code of status
     */
    public static function getStatusClass($value = null)
    {
        if ($value === null) {
            return "";
        }

        $status = self::__getStatus($value);

        if ($status) {
            return $status['class'];
        }

        return '';
    }

    /**
     * Returns status data
     *
     * @param int $value Status value
     * @return null|array Status array or null if not exists
     */
    private static function __getStatus($value = null)
    {
        return isset(self::$_status[$value]) ? self::$_status[$value] : null;
    }

}
