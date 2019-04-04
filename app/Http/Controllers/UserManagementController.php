<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Permission;
use App\Repositories\Users;
use App\Repositories\Administrators;
use App\Repositories\Speakers;
use App\Repositories\Role;
use Auth; 
use Response;
use Redirect;
use DB;  

class UserManagementController extends Controller
{
      /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'access_management';

    function userList(){  
        $data = array();
        $activeSidebarSubMenu = 'user_management';
        $data['data'] = DB::select('select id,first_name,last_name,email from administrators where status = "active"');
        $data['data_for'] = "list_view";
        return view('backEnd.access_management.UserManagement',$data);
    }  

    function addAdministratorFrm($id = 0){
        $data['roles'] = DB::select("select * from roles "); 
        if($id == 0){ 
            $data['data_for'] = "add_admin";
            config(['app.name' => __('Add Administrator')]);
        }else{
            $data['info'] = DB::select("select * from administrators where id= '".$id."' "); 
            $data['data_for'] = "edit_admin"; 
            $data['selected_role'] = DB::select("select * from role_user where user_id= '".$id."' "); 
            config(['app.name' => __('Edit Administrator')]);
        } 
        return view('backEnd.access_management.addNewAdmin',$data); 
    }

    function saveAdministratorFrm(Request $request,$id = 0){
      
       if(array_key_exists("id",$request->post())){     
           $uid = $request->post('id'); 
           $role_id = $request->post('role_id');
           $requestData = array(
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'), 
                'status' => $request->post('status'),  
                'contact_no' => $request->post('contact_no'), 
                'created_by' => Auth::guard('administrator')->user()->id
           );

            Administrator::where('id',$request->post('id'))->update($requestData); 
 
            // update Role user
            DB::update("update role_user set role_id = ".$role_id." where user_id = ".$uid." "); 
            $request->session()->flash('success', __('User has been updated successfully.')); 
        }else{ 

            $requestData = array(
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'), 
                'password' => $request->post('password'),
                'status' => $request->post('status'),  
                'contact_no' => $request->post('contact_no'), 
                'created_by' => Auth::guard('administrator')->user()->id
            );
            $administrator = Administrator::create($requestData);
            
            // Add Role user 
            $roleid = $request->post('role_id');
            DB::insert("insert into role_user (user_id,role_id) values('".$administrator->id."','".$roleid."')"); 
            $request->session()->flash('success', __('User has been added successfully.')); 
        }
        return redirect('user_management');
    } 

    function role_form($id = 0){ 
        $data = array();
        $data['permission_list'] = DB::select("select * from permissions where status= 'active' ");  
        if($id == 0){
            $data['data_for'] = "add_role";
        }else{
            $data['data_for'] = "edit_role"; 
            $permissions_ids = DB::select("select permissions_id from permission_role where role_id=".$id." ");  
            $data['res'] = DB::select("select * from roles where id= ".$id." ");  
            $data['permissions_id'] = array();
            $i = 0;
            if(!empty($permissions_ids)){ 
                foreach($permissions_ids as $pi){
                    $data['permissions_id'][$i++] = $pi->permissions_id;
                } 
            }
        } 
        return view('backEnd.access_management.RoleManagement',$data);
    }

    function saverole(Request $request,$id = 0){ 

        $display_name = $request->post('display_name');
        $name = $request->post('name'); 
        $sort = $request->post('sort'); 
        $status = $request->post('status');
         
        if(array_key_exists('id',$request->post())){
            $id = $request->post('id');
            DB::update("update roles set display_name='".$display_name."', name='".$name."', sort='".$sort."', status='".$status."' where id=".$id." ");
            DB::delete("delete from permission_role where role_id=".$id."");

            if($request->post('associated_permission') != "all"){
                if(array_key_exists('permission',$request->post())){
                    foreach($request->post('permission') as $pr){ 
                        DB::insert("insert into permission_role (permissions_id,role_id,user_id) values ('".$pr."','".$id."',0)");
                    }  
                } 
            } 
            $request->session()->flash('success', __('Role updated successfully.'));
        }else{ 
            DB::table('roles')->insert([
                'display_name' => $display_name,
                'name' => $name,
                'sort' => $sort,
                'status' => $status
            ]);
            $id = DB::getPdo()->lastInsertId();
           
            $request->session()->flash('success', __('Role added successfully.')); 
        }
        return redirect('role_list');
    }

    function removeRole($id = 0){           
        DB::delete("delete from role_user where role_id=".$id.""); 
        DB::delete("delete from permission_role where role_id=".$id."");
        DB::delete("delete from roles where id = '".$id."' ");
        return redirect('role_list'); 
    }

    function rolelist(){ 
        $data = array(); 
        $data = DB::table("roles")->paginate(10);   
        return view('backEnd.access_management.RoleList',['paginator'=> $data]);  
    }

    function permission_list(){
        $activeSidebarSubMenu = 'permission_management'; 
        $data = DB::table("permissions")->paginate(10);   
        return view('backEnd.access_management.PermissionList',['paginator'=> $data]);    
    }

    function permissionFrm($id = 0){
        if($id == 0){
            config(['app.name' => __('Add Permission')]);
            $data['act'] = "add_permission"; 
        }else{ 
            config(['app.name' => __('Edit Permission')]);
            $data['act'] = "edit_permission";
            $data['permission'] = DB::select('select * from permissions where id = '.$id.' ');
        }
        return view('backEnd.access_management.addNewpermission',$data);
    }

    function savePermission(Request $request,$id = 0){

        $requestData = [
            'name' => $request->post('name'),
            'display_name' => $request->post('display_name'),
            'status' => $request->post('status'),  
            'sort'=> $request->post('sort'),  
        ];
        if(array_key_exists('id',$request->post())){    
            Permission::where('id',$request->post('id'))->update($requestData); 
            $request->session()->flash('success', __('Permission updated successfully.'));
        }else{
            $Permission = Permission::create($requestData);
            $request->session()->flash('success', __('Permission added successfully.'));
        }
        return redirect('permission_management');  
    }
 
    function removeAdministrator($id){  
        DB::delete('delete from administrators where id = '.$id.' ');
        DB::delete('delete from role_user where user_id = '.$id.' '); 
        return redirect('user_management');  
    }

    function removePermission($id = 0){
        DB::delete('delete from permissions where id = '.$id.' '); 
        DB::delete('delete from permission_role where permissions_id = '.$id.' '); 
        return redirect('permission_management'); 
    }
}

