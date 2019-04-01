<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class StatusHelper
{

    /**
     * status
     *
     * @var array
     */
    protected static $_status = [
        'active' => [
            'value' => 'active',
            'displayName' => 'Active',
            'color' => '#fff',
            'class' => "badge badge-success",
        ],
        'inactive' => [
            'value' => 'inactive',
            'displayName' => 'Inactive',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ],
        'delete' => [
            'value' => 'delete',
            'displayName' => 'Delete',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ],
		/*'draft' => [
            'value' => 'draft',
            'displayName' => 'Draft',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ]*/
    ];

    protected static $_webinar_type = [
        'archived' => [
            'value' => 'archived',
            'displayName' => 'Active',
            'color' => '#fff',
            'class' => "badge badge-success",
        ],
        'live' => [
            'value' => 'live',
            'displayName' => 'Inactive',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ],
        'delete' => [
            'value' => 'delete',
            'displayName' => 'Delete',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ],
    ];

     protected static $_webinar_status = [
        'archived' => [
            'value' => 'active',
            'displayName' => 'Active',
            'color' => '#fff',
            'class' => "badge badge-success",
        ],
        'live' => [
            'value' => 'inactive',
            'displayName' => 'Inactive',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ],

         'draft' => [
            'value' => 'draft',
            'displayName' => 'Draft',
            'color' => '#fff',
            'class' => 'badge badge-normal'
        ],
        
        'delete' => [
            'value' => 'delete',
            'displayName' => 'Delete',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ],
    ];

    protected static $_admin_status = [
        'None' => [
            'value' => 'None',
            'displayName' => 'None',
            'color' => '#fff',
            'class' => "badge badge-gray",
        ],
        'Approved' => [
            'value' => 'Approved',
            'displayName' => 'Approved',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ],
        'Reject' => [
            'value' => 'Reject',
            'displayName' => 'Rejected',
            'color' => '#fff',
            'class' => 'badge badge-danger'
        ],
    ];

//        'waiting-picup' => [
//            'value' => 'waiting-picup',
//            'displayName' => 'Waiting Picup',
//            'color' => '#fff',
//            'class' => 'badge badge-primary'
//        ],
//        'on-the-way' => [
//            'value' => 'on-the-way',
//            'displayName' => 'On The Way',
//            'color' => '#fff',
//            'class' => 'badge badge-secondary'
//        ],
//        'return' => [
//            'value' => 'return',
//            'displayName' => 'Return',
//            'color' => '#fff',
//            'class' => 'badge bg-purple'
//        ],
//        'delivered ' => [
//            'value' => 'delivered ',
//            'displayName' => 'Delivered',
//            'color' => '#fff',
//            'class' => 'badge badge-info'
//        ]

    /**
     * Returns the list of statuses in key:value pair
     *
     * @return array Array of Statuses
     */
    public static function getStatusesList()
    {
        $status = (new Collection(self::$_status))->pluck('displayName', 'value')->toArray();
        unset($status['delete']);

        return $status;
    }

 public static function getArchiveStatusesList()
    {
        $archivestatus = (new Collection(self::$_webinar_status))->pluck('displayName', 'value')->toArray();
        unset($archivestatus['delete']);

        return $archivestatus;
    }


    /**
     * Returns the list of statuses in key:value pair
     *
     * @return array Array of Statuses
     */
    public static function getAdminStatusList()
    {
        $status = (new Collection(self::$_admin_status))->pluck('displayName', 'value')->toArray();
        return $status;
    }


    /**
     * Returns status name for given id.
     *
     * @param int $value Status ID
     * @return string Display name of status
     */
    public static function getStatus($value = null)
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
     * Returns status name for given id.
     *
     * @param int $value Status ID
     * @return string Display name of status
    */
    public static function getAdminStatus($value = null)
    {
        if ($value === null) 
        {
            return "";
        }
        $status = self::__getAdminStatus($value);
        if ($status) 
        {
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
     * Returns status color for given id.
     *
     * @param int $value Status ID
     * @return string Color code of status
     */
    public static function getAdminStatusClass($value = null)
    {

        if ($value === null) 
        {
            return "";
        }

        $status = self::__getAdminStatus($value);

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


    /**
     * Returns status data
     *
     * @param int $value Status value
     * @return null|array Status array or null if not exists
     */
    private static function __getAdminStatus($value = null)
    {
        return isset(self::$_admin_status[$value]) ? self::$_admin_status[$value] : null;
    }


    public static function jobStatus()
    {
        return collect([
            '' => 'Select Status',
            config('constants.JOBS.WAITING_PICUP') => config('constants.JOBS.WAITING_PICUP_VALUE'),
            config('constants.JOBS.RETURN') => config('constants.JOBS.RETURN_VALUE'),
            config('constants.JOBS.DELIVERED') => config('constants.JOBS.DELIVERED_VALUE'),
            config('constants.JOBS.ON_THE_WAY') => config('constants.JOBS.ON_THE_WAY_VALUE')
        ]);
    }

}
