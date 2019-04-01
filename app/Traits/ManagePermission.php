<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Administrator;
use Illuminate\Support\Facades\Cache;
use App\Helpers\PermissionHelper;

trait ManagePermission
{

    public function removeAllCache()
    {
        Cache::flush();

        return true;
    }

    /**
     * Save role wise permission
     * 
     * @param type $roleId role id
     * @param type $permissionId permission array id
     * @return boolean
     */
    public function saveRolePermission($administratorId = null, $permissionId = [])
    {
        $administrator = $this->getAdministrators($administratorId);
        if (!empty($administrator)) {
            // Add data into database
            $administrator->permissions()->sync($permissionId);
            $administratorPermission = Administrator::getAdministratorPermission($administratorId);
//            // Create a new cache
            $save = PermissionHelper::addCache(config('constants.ADMINISTRATOR_PERMISSION.ADMINISTRATOR_PERMISSION_KEY') . $administratorId, $administratorPermission);
            return ($save) ? true : false;
        }

        return false;
    }

    /**
     * Get the role instance
     * 
     * @param type $roleId role id
     * @return type
     */
    public function getAdministrators($administratorId = null)
    {
        return Administrator::findorfail($administratorId);
    }

    /**
     * Delete the role wise permission
     * 
     * @param type $roleId role id
     * @return boolean
     */
    public function deleteRolePermission($administratorId = null)
    {
        $administrator = $this->getAdministrators($administratorId);
        if (!empty($administrator)) {
            ($administrator->permissions()->detach()) ? true : false;
        }

        return false;
    }
}
