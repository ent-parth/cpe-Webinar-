<?php

namespace App\Helpers;

use Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Administrator;

class PermissionHelper
{

    /**
     * Get the permission from cache
     * Permission not available in cache so get the permission from database
     * 
     * @param type $key permission key
     * @return boolean
     */
    public static function getPermission($key = null, $test = null)
    {
        if (isset($key) && !empty($key)) {
            $administratorId = explode("_", $key);
            if (Cache::has($key)) {
                return self::permissionDecode(Cache::get($key));
            } else {
                $permissionData = Administrator::getAdministratorPermission($administratorId[count($administratorId) - 1]);
                return self::addCache($key, $permissionData);
            } 
        }

        return false;
    }

    /**
     * Add the new permission in cache
     * 
     * @param type $key permission key
     * @param type $permissionData permission data
     * @return boolean
     */
    public static function addCache($key = null, $permissionData = null)
    {
        if (isset($key) && !empty($key) && !empty($permissionData)) {
            // Delete the old cache
            self::deleteCache($key);
            $permissionData = array_column($permissionData['permissions'], 'permission_key', 'id');
            $data = self::permissionEncode($permissionData);
            Cache::put($key, $data, config('constants.ADMINISTRATOR_PERMISSION.CACHE_EXPIRE_TIME'));

            return self::getPermission($key);
        }

        return false;
    }

    /**
     * Delete the cache
     * 
     * @param type $key permission key
     * @return boolean
     */
    public static function deleteCache($key = null)
    {
        if (isset($key) && !empty($key)) {
            if (Cache::has($key)) {
                Cache::forget($key);

                return true;
            }
        }

        return false;
    }

    /**
     * Decode the json data
     * 
     * @param type $value permission data
     * @return type
     */
    public static function permissionDecode($value)
    {
        return json_decode($value, true);
    }

    /**
     * Encode the permission array
     * 
     * @param type $value permission array
     * @return type
     */
    public static function permissionEncode($value)
    {
        return json_encode($value);
    }

    /**
     * Check the user permission
     * 
     * @param type $permissionKey
     * @return boolean
     */
    public static function hasAccess($permissionKey = null)
    {
        return true;
        // Get the current login user role id.
//         $id = Auth::guard('administrator')->user()->role_id;
        if (Auth::guard('administrator')->check()) {
            $id = Auth::guard('administrator')->user()->role_id;
        } else {
            return true;
        }
        $accessPermission = self::getPermission(config('constants.ADMINISTRATOR_PERMISSION.ADMINISTRATOR_PERMISSION_KEY') . Auth::guard('administrator')->user()->id); // Get the permission in cache.

        if (config('constants.ADMIN_CONST.SUPER_ADMIN') === $id) {
            return true;
        }

        if (empty($permissionKey) || empty($accessPermission)) {
            return false;
        }

        if (is_array($permissionKey) && count(array_intersect($permissionKey, $accessPermission)) !== 0) {
            return true;
        }

        if (in_array($permissionKey, $accessPermission)) {
            return true;
        }

        return false;
    }
}
