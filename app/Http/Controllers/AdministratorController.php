<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\StatusHelper;
use App\Http\Requests\AdministratorRequest;
use App\Models\Administrator;
use App\Repositories\Permissions;
use App\Repositories\PermissionsRole;
use App\Repositories\UserRole;
use App\Repositories\Role;
use Carbon\Carbon;


class AdministratorController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Administrator';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'administrators';

    /**
     * Active sidebar sub-menu
     *
     * @var string
     */

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        $roles = [];//Role::notDeleted()->pluck('name', 'id')->toArray();
        config(['app.name' => __('Administrators')]);

        return view('backEnd.administrator.index', compact('statusList', 'roles'));
    }

    /**
     * Returns the administrators list
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
            1 => 'first_name',
            2 => 'email',
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
        $requestData = ['email'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        if (!empty($request->status)) {
            $searchData[] = ['status', $request->status];
        }

        if (!empty($request->role)) {
            $searchData[] = ['role_id', '=', $request->role];
        }

        $administratorsData = Administrator::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);
        if (!empty($request->name)) {
            $administratorsData->where(function ($query) use ($request) {
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$request->name%' ");
            });
        }

        try {
            $administrators = $administratorsData->paginate($limit);
            $paginationCount = $administrators->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.administrator.json.get_list', compact('administrators', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $roleList = [];//Role::notDeleted()->pluck('name', 'id')->toArray();
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Add') . ' | ' . __('Administrators')]);
		$permissions = Permissions::select('id','name','display_name')->where('status','=',1)->orderBy('permissions.name')->get();
        return view('backEnd.administrator.add', compact('roleList', 'statusList','permissions'));
    }

    public function store(Request $request)
    {	
        try {
            $requestData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => $request->status,
                'contact_no' => $request->contact_no,
                'created_by' => Auth::guard('administrator')->user()->id
            ];
			
            $administrator = Administrator::create($requestData);
			
            if ($administrator) {
				//create role
				
				 $valuesRole = ['name'=>$request->input('email'),
								'display_name'=>$request->input('email'),
								'description'=>$request->input('email'),
								'status'=>'active',
								'created_at'=> Carbon::now()]; 
				$role = Role::create($valuesRole);
				$RoleID = $role->id;
				if($RoleID){
					$valuesUserRole = ['user_id'=>$administrator->id,'role_id'=>$RoleID];

					$userRole = UserRole::create($valuesUserRole);
					$userRoleID = $userRole->id;
					if($userRoleID){
						$PermissionsId = $request->input('permission');
						if(!empty($PermissionsId)){
							foreach ($PermissionsId as &$permissionid) {
								 $PermissionsRole = PermissionsRole::create([
									'permissions_id' => $permissionid,
									'role_id' => $RoleID,
									'user_id' => $administrator->id,
								 ]);
								 //Generate Log file
								 $NewId = $PermissionsRole->id;
								 //General::addAdminLog($NewId, 'PermissionRole', 'Add', 'Admin can add PermissionRole');
							}
						}	
					}
				}
				
                //$this->sendMail('administrator', $request->all());
                $request->session()->flash('success', __('User has been added successfully.'));
                return redirect()->route('administrators');
            } else {
                $request->session()->flash('error', __('User could not be saved. Please, try again'));
            }
        } catch (Exception $ex) {
            return response()->view('backEnd.errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   try {
            $administrators = Administrator::notDeleted()->findOrFail($request->id);
            $roleList = [];//Role::notDeleted()->pluck('name', 'id')->toArray();
            $statusList = StatusHelper::getStatusesList();
            config(['app.name' => __('Edit') . ' | ' . __('Administrators')]);
			
			$permissions = Permissions::select('permissions.id','permissions.name','permissions.display_name')->where('status','=',1)->orderBy('permissions.name')->get();
			
			//check user role for permission
			$userRole = UserRole::select('role_user.id','role_user.user_id','role_user.role_id')->where('user_id','=',$request->id)->first();
			//echo "<pre>"; print_r($userRole); exit;
			
			$per_role_id = [];
			if(!empty($userRole)){
				$permissionsroles = PermissionsRole::where('role_id', '=', $userRole->role_id)->where('user_id', '=', $userRole->user_id)->get();
				foreach($permissionsroles as $pr){
					$per_role_id[] = $pr->permissions_id;
				}
			}
			
			

            return view('backEnd.administrator.edit', compact('administrators', 'roleList', 'statusList','per_role_id','permissions'));
        } catch (Exception $ex) {
            abort(404);
        }
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $administrator = Administrator::notDeleted()->findOrFail($request->id);
		$updateData = $request->all();
		
		$updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        if ($administrator) {
            if ($administrator->update($updateData)) {
                // Store Permission in permission table.
                /*if ($request->role_id == config('constants.ADMIN_CONST.SUPER_ADMIN')) {
                    $request->permission_key = [];
                }
                $saveRolePermission = $this->saveRolePermission($administrator->id, $request->permission_key);
                */
				$PermissionsId = $request->input('permission');
				if(!empty($PermissionsId)) {
				$userRole = UserRole::select('role_user.id','role_user.user_id','role_user.role_id')->where('user_id','=',$request->id)->first();
					//Delete old permission and new
					if(!empty($userRole)){
						PermissionsRole::where('role_id', '=', $userRole->role_id)->where('user_id', '=', $userRole->user_id)->delete();
						if(!empty($PermissionsId)){
							//Add or edit Permission on Created Role.
							foreach ($PermissionsId as &$permissionid) {
								$PermissionsRole = PermissionsRole::create([
									'permissions_id' => $permissionid,
									'role_id' => $userRole->role_id,
									'user_id' => $request->id,
								]);
								//Generate Log file
								$NewId = $PermissionsRole->id;
								//General::addAdminLog($NewId, 'PermissionsRole', 'Add', 'Admin Can Add New Permissions Role');
							}
						}
					}
				}
                $request->session()->flash('success', __('User has been updated successfully.'));

                return redirect('/administrators');
            } else {
                $request->session()->flash('error', __('User could not be updated. Please, try again.'));
            }
        }
    }

    public function destroy(Request $request)
    {
        try {
            $administrator = Administrator::notDeleted()->findOrFail($request->id);
            $administrator->modified_by = Auth::guard('administrator')->user()->id;
            $administrator->status = config('constants.STATUS.STATUS_DELETE');
           if ($administrator->save()) {
                $data = ['success' => __('Administrator has been deleted successfully.')];
            } else {
                $data = ['error' => __('Administrator can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Administrator can not be deleted. Please try again.'));
        }
    }

    /**
     * Remove the multiple company.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $administrator = Administrator::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($administrator) {
                    $data = ['success' => 'Administrators has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Administrators can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Administrators can not be deleted. Please try again.'];
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            abort(404);
        }
    }

    /**
     * Update the status
     *
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
    public function statusUpdate(Request $request) {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $administrator = Administrator::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($administrator->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('Administrator status updated successfully.'));
        $flag = ($administrator->update($updateData)) ? 'true' : 'false';

        return redirect()->route('administrators');
    }
}
