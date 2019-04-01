<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Users;
use App\Repositories\TagUser;
use App\Repositories\Tag;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use DateTime;
use DateTimeZone;
use File;
use CommonHelper;
use Redirect;

class UsersController extends Controller
{

   /**
     * Users listing
     *
     * @var string
     */
    
    public function index(Request $request){
        $Users = Users::select('id','first_name','last_name', 'email','contact_no','firm_name','country_id','state_id','city_id','zipcode','time_zone','user_type_id','designation','ptin_number','created_at','updated_at','modified_by','remember_token', 'status');
        
        // For status filter            
        $status = $request->input('status');
        if ($status != '') {
            $Users = $Users->where('status', '=', $status);
        }else{
            $Users = $Users->where('status', '!=', 'delete');
        }
		  //For event auction type filter
		$email = $request->input('email');
		if($email != '') {
			$email = '%' . $request->input('email') . '%';
			$Users = $Users->where('email', 'LIKE', $email);
		} 
		
		$firm_name = $request->input('firm_name');
		if($firm_name != '') {
			$firm_name = '%' . $request->input('firm_name') . '%';
			$Users = $Users->where('firm_name', 'LIKE', $firm_name);
		} 
      
		
		// For text input filter
		$name = $request->input('name');
        if ($name != '') {
            $searchStr = '%' . $name . '%';
			$Users = $Users->where(DB::raw('concat(first_name," ",last_name)'), 'LIKE', $searchStr);	
        }
		
        $Users = $Users->orderby('id', 'desc')->paginate(env('PAGINATION'));
        $Users = $Users->appends(request()->query());
       // echo "<pre>"; print_r($Users); exit;
        
        $statusList = StatusHelper::getStatusesList();
        
        if ($request->ajax()) {
            return Response::json(View('backEnd/users/index-ajax', compact('Users','statusList'))->render());
        }
        
        return view('backEnd.users.index', compact('Users','statusList'));
    }
	
    /**
     * Delete Users  
     *
     * @param $request
     * 
     * @return ajax
     */
     
    public function destroy($id,Request $request){
		$id = decrypt($id);
        try {
            if(is_numeric($id) && !empty($id)){
                $deleteArray = ['status' => config('constants.STATUS.STATUS_DELETE'),'modified_by' => Auth::guard('administrator')->user()->id];
                
                $delete = Users::where('id', '=', $id)->update($deleteArray);
                if($delete){
                    $request->session()->flash('success', __('Users has been deleted successfully.'));
                } else {
                    $request->session()->flash('error', __('Users can not be deleted. Please try again.'));
                }
                return redirect()->route('series').$request->input('uri');
            }else{
                $request->session()->flash('error', __('Users can not be deleted. Please try again.'));
                 return redirect()->route('series').$request->input('uri');
            }   
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Users can not be deleted. Please try again.'));
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
				$update_active = Users::where('id', '=', $id)->update(['status' => 'active']);
			 	$request->session()->flash('success', __('User status updated successfully.'));
			 }elseif($status == 'active'){
				$update_inactive = Users::where('id', '=', $id)->update(['status' => 'inactive']);
				$request->session()->flash('success', __('User status updated successfully.'));
			 }
			
        return redirect()->back();
    }
	
	/**
     * User View
     *
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
	   public function view(Request $request, $id){
		   $id = decrypt($id);
		   $Users_view = Users::select('users.id','users.first_name','users.last_name', 'users.email','users.contact_no','users.firm_name','users.country_id','users.state_id','users.city_id','users.zipcode','users.time_zone','users.user_type_id','users.designation','users.ptin_number','users.updated_at','users.modified_by','users.remember_token','users.created_at', 'users.status','user_types.name','countries.name as country','states.name as state','cities.name as city')
		   						->leftjoin('user_types','user_types.id','=','users.user_type_id')
								->leftjoin('countries','users.country_id','=','countries.id')
								->leftjoin('states','users.state_id','=','states.id')
								->leftjoin('cities','users.city_id','=','cities.id')
		   						->where('users.id','=',$id)
								->first();
		   
			$tag_query = Tag::select('tags.id','tags.tag')
							   ->leftjoin('tag_user','tag_user.tag_id','=','tags.id')
							   ->where('tag_user.user_id','=',$id)
							   ->get();
		   
		    return view('backEnd.users.view', compact('Users_view','tag_query'));
	   }
}
