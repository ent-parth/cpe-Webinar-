<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Traits\ManagePermission;
use App\Helpers\PermissionHelper;
use App\Helpers\StatusHelper;

class RoleController extends Controller
{

    use ManagePermission;

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Roles';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'settings';

    /**
     * Active sidebar sub-menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'roles';

    /**
     * Show role listing
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => 'Roles']);

        return view('backEnd.roles.index', compact('statusList'));
    }

    /**
     * Returns the Roles list
     *
     * @throws NotFoundException When invalid request
     */
    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'name',
			2 => 'display name',
            3 => 'status',
        ];

        $start = !empty($request->input('start')) ? intval($request->input('start')) : 1;
        $limit = intval($request->input('length'));

        $page = intval(($start / $limit) + 1);
        $columnValue = !empty($request->input('order.0.column')) ? $request->input('order.0.column') : 0;
        $columnName = !empty($columnArr[$columnValue]) ? $columnArr[$columnValue] : 'created_at';
        $columnOrderBy = !empty($request->input('order.0.dir')) ? $request->input('order.0.dir') : 'desc';

        $this->getCurrentPageNo($page);
        $searchData = [];
        $requestData = ['name'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        if (!empty($request->status)) {
            $searchData[] = ['status', $request->status];
        }

        $roleData = Role::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);

        try {
            $roles = $roleData->paginate($limit);
            $paginationCount = $roles->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.roles.json.get_list', compact('roles', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    /**
     * Returns the Role add form
     *
     * @throws NotFoundException When invalid request
     */
    public function add()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => 'Add | Roles']);

        return view('backEnd.roles.add', compact('statusList'));
    }

    /**
     * Create new role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $requestData = [
                'name' => $request->name,
				'display_name' => $request->display_name,
				'description' => $request->description,
				'status' => $request->name,
                'created_by' => Auth::guard('administrator')->user()->id
            ];

            $role = Role::create($requestData);
            if ($role) {
				//now add user role
				$userRole = [
					'user_id' => Auth::guard('administrator')->user()->id,
					'role_id' => $role->id
				];
				$roleUser = RoleUser::create($userRole);
				
                $request->session()->flash('success', 'Role has been added successfully.');
				return redirect()->route('roles');
            } else {
                $request->session()->flash('error', 'Role could not be saved. Please, try again.');
            }
        } catch (Exception $ex) {
            return response()->view('admin.errors.404');
        }
    }

    /**
     * Remove the specified resource from storage.
     *     
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $role = Role::notDeleted()->findOrFail($request->id);
            $role->status = config('constants.STATUS.STATUS_DELETE');
            $role->updated_by = Auth::guard('administrator')->user()->id;
            if ($role->save()) {
                //$this->deleteRolePermission($request->id);
                $data = ['success' => 'Role has been deleted successfully.'];
            } else {
                $data = ['error' => 'Role can not be deleted. Please try again.'];
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *     
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $role = Role::notDeleted()->findOrFail($request->id);
            config(['app.name' => 'Edit | Roles']);

            return view('backEnd.roles.edit', compact('role', 'statusList'));
        } catch (Exception $ex) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request     
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request)
    {
        $role = Role::notDeleted()->findOrFail($request->id);

        $updateData = $request->all();
        $updateData['updated_by'] = Auth::guard('administrator')->user()->id;
        if ($role) {
            if ($role->update($updateData)) {
                $request->session()->flash('success', 'Role has been updated successfully.');

                return redirect('/roles');
            } else {
                $request->session()->flash('error', 'Role could not be updated. Please, try again.');
            }
        }
    }

    /**
     * Show the permission interface
     * Show the selected role permission
     *  
     * @param type $id role id
     * @return type
     */
    public function createPermissions($id = null)
    {
        $selectRolePermission = [];
        // Get the all permission
        $permission = Permission::getPermission();
        // Get the all role wise permission
 
        $selectRolePermission = PermissionHelper::getPermission(config('constants.ROLE_PERMISSION.ROLE_PERMISSION_KEY') . $id);
        config(['app.name' => 'Manage Permission']);
        
        return view('backEnd.roles.createPermissions', compact('permission', 'selectRolePermission'));
    }

    /**
     * Save the role wise permission
     * 
     * @param Request $request
     * @return type
     */
    public function storePermission(Request $request)
    {
        try {
            $roleId = $request->id;
            $permissionId = $request->permission_key;
            if (!empty($roleId) && !empty($permissionId)) {
                // Save the permission in database and
                // Save the role wise permission in cache
                $saveRolePermission = $this->saveRolePermission($roleId, $permissionId);
                if ($saveRolePermission) {
                    $request->session()->flash('success', 'Permission has been added successfully.');

                    return redirect()->route('roles');
                }
            }
            $request->session()->flash('error', 'Permission could not be saved. Please, try again.');

            return redirect()->route('create.permission');
        } catch (Exception $ex) {
            return response()->view('admin.errors.404');
        }
    }

}
