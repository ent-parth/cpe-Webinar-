<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\permissionRequest;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Permissions;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use File;
use CommonHelper;
use Redirect;

class PermissionController extends Controller
{
   
     /**
     * permission listing
     *
     * @var string
     */
	 
	  public function index(Request $request){ 
        $permission = Permissions::select('id','name','display_name','description', 'created_at','updated_at', 'status');
        
        // For status filter            
        $status = $request->input('status');
        if ($status != '') {
            $permission = $permission->where('status', '=', $status);
        }else{
            $permission = $permission->where('status', '!=', 'delete');
        }
		
        // For text input filter
        if ($request->input('name') != '') {
            $searchStr =  $request->input('name');
            $searchStr = '%' . $searchStr . '%';
            $permission = $permission->where('name', 'LIKE', $searchStr);
        }
        
        $permission = $permission->orderby('id', 'desc')->paginate(env('PAGINATION'));
        $permission = $permission->appends(request()->query());
       // echo "<pre>"; print_r($permission); exit;
        
        $statusList = StatusHelper::getStatusesList();
        
        if ($request->ajax()) {
            return Response::json(View('backEnd/permission/index-ajax', compact('permission','statusList'))->render());
        }
        
        return view('backEnd.permission.index', compact('permission','statusList'));
    }
    
    
    /**
     * Get create permission view
     *
     * @param $request
     * 
     * @return view
     */
    public function create() {
        return view('backEnd.permission/add');
    }
	
	 /**
     *  Store permission
     *
     * @param $request
     * 
     * @return view
     */

    public function store(Request $request) {
		$admin = Auth::guard('administrator')->user()->id;
        try {
			$name = $request->input('name'); 
          	$display_name = $request->input('display_name'); 
			$description = $request->input('description');
			$status = $request->input('status');
			$created_at =  Carbon::now();
            
            
            $addArray = ['name'=>$name,
						 'display_name'=>$display_name,
						 'description'=>$description,
                         'status'=>'active',
                         'created_at'=>$created_at,
                         ];
                           
            $createdData = Permissions::create($addArray);
            
            if($createdData){
            //$request->session()->flash('success', __('permission has been added successfully.'));
             
             return redirect('/permission');

             //Route::get('/selfystudy-permission/edit/{id}/documents
                
             //   return redirect()->route('speaker.self_study_permission').$request->input('uri');
            }
            $request->session()->flash('error', __('permission could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('permission could not be saved. Please, try again.'));
        }
    }
     
    
    /**
     * Get permission information edit view
     *
     * @param $id
     * 
     * @return view
     */
    public function edit($id) {
        try{
            if(is_numeric($id) && !empty($id)){
               
                $permission_edit = Permissions::select('id','name','display_name','description', 'created_at','updated_at', 'status')->where('id','=',$id)->first();
    
                if ($permission_edit) {
                    return view('backEnd.permission.edit',compact('permission_edit'));
                }else{
                    $request->session()->flash('error', __('permission not available. Please, try again.'));
                    return redirect()->route('/permission').$request->input('uri');
                }
            }else{
                $request->session()->flash('error', __('permission could not be load. Please, try again.'));
                return redirect()->route('/permission').$request->input('uri');
            }
        } catch (Exception $ex) {
            abort(404);
        }   
    }
    
    
     /**
     * update permission data
     *
     * @param $request
     * 
     * @return view
     */
    public function update(Request $request) { 
	$admin = Auth::guard('administrator')->user()->id;
        try {
            $id = $request->input('id');
           $name = $request->input('name'); 
          	$display_name = $request->input('display_name'); 
			$description = $request->input('description');
			$status = $request->input('status');
			$updated_at =  Carbon::now();
            
            
            $editArray = ['name'=>$name,
						'display_name'=>$display_name,
                        'status'=>'active',
						'description'=>$description,
                        'updated_at'=>$updated_at,
                      
                        ];
            $updateData = Permissions::where('id',$id)->update($editArray);

 
            if($updateData){
                $request->session()->flash('success', __('Self Study permission has been update successfully.'));
                return redirect()->route('permission',$request->input('uri'));
            }
            $request->session()->flash('error', __('permission could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('permission could not be saved. Please, try again.'));
        }
    }
	
	
	
    /**
     * Delete permission  
     *
     * @param $request
     * 
     * @return ajax
     */
     
    public function destroy($id,Request $request){
        try {
            if(is_numeric($id) && !empty($id)){
                $deleteArray = ['status' => 'delete'];
                
                $delete = Permissions::where('id', '=', $id)->update($deleteArray);
                if($delete){
                    $request->session()->flash('success', __('Self study permission has been deleted successfully.'));
                } else {
                    $request->session()->flash('error', __('Self study permission can not be deleted. Please try again.'));
                }
                return redirect()->route('permission').$request->input('uri');
            }else{
                $request->session()->flash('error', __('Self study permission can not be deleted. Please try again.'));
                 return redirect()->route('permission').$request->input('uri');
            }   
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Self study permission can not be deleted. Please try again.'));
        }
    }
	
	/**
     * Update the status
     *
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
    public function statusUpdate($id,$status,Request $request) {
		
			if($status=='inactive'){
				$update_active = Permissions::where('id', '=', $id)->update(['status' => 'active']);
				 $request->session()->flash('success', __('Permissions status updated successfully.'));
			
			 }elseif($status == 'active'){
				$update_inactive = Permissions::where('id', '=', $id)->update(['status' => 'inactive']);
				 $request->session()->flash('success', __('Permissions status updated successfully.'));
			 }
        return redirect()->back();
    }
    

    
}
