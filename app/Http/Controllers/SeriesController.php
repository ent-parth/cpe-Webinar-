<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\SeriesRequest;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Series;
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

class SeriesController extends Controller{

    /**
     * Series listing
     *
     * @var string
     */
    
    public function index(Request $request){
        $Series = Series::select('id','name','created_by', 'created_at','updated_at','updated_by', 'status');
        
        // For status filter            
        $status = $request->input('status');
        if ($status != '') {
            $Series = $Series->where('status', '=', $status);
        }else{
            $Series = $Series->where('status', '!=', 'delete');
        }
		
        // For text input filter
        if ($request->input('name') != '') {
            $searchStr =  $request->input('name');
            $searchStr = '%' . $searchStr . '%';
            $Series = $Series->where('name', 'LIKE', $searchStr);
        }
        
        $Series = $Series->orderby('id', 'desc')->paginate(env('PAGINATION'));
        $Series = $Series->appends(request()->query());
        
        $statusList = StatusHelper::getStatusesList();
        
        if ($request->ajax()) {
            return Response::json(View('backEnd/selfstudy-Series/index-ajax', compact('Series','statusList'))->render());
        }
        
        return view('backEnd.series.index', compact('Series','statusList'));
    }
    
    
    /**
     * Get create Series view
     *
     * @param $request
     * 
     * @return view
     */
    public function create() {
        return view('backEnd.series/add');
    }
	
	 /**
     *  Store Series
     *
     * @param $request
     * 
     * @return view
     */

    public function store(Request $request) {
		$admin = Auth::guard('administrator')->user()->id;
        try {
            $name = $request->input('name');
			$description = $request->input('description');
			$status = $request->input('status');
			$created_at =  Carbon::now();
            
            $addArray = ['name'=>$name,
						'description'=>$description,
                        'status'=>'active',
                        'created_at'=>$created_at,
                        'created_by'=>$admin
                        ];
                           
            $createdData = Series::create($addArray);
            if($createdData){
            	//$request->session()->flash('success', __('Series has been added successfully.'));
            	return redirect('/series');
             	//Route::get('/selfystudy-Series/edit/{id}/documents
             	//return redirect()->route('speaker.self_study_Series').$request->input('uri');
            }
            $request->session()->flash('error', __('Series could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Series could not be saved. Please, try again.'));
        }
    }
     
    
    /**
     * Get Series information edit view
     *
     * @param $id
     * 
     * @return view
     */
    public function edit($id) {
        try{
            if(is_numeric($id) && !empty($id)){
                $Series = Series::select('id','name', 'description', 'created_by', 'created_at','updated_at','updated_by', 'status')->where('id','=',$id)->first();
                if ($Series) {
                    return view('backEnd.series.edit',compact('Series'));
                }else{
                    $request->session()->flash('error', __('series not available. Please, try again.'));
                    return redirect()->route('/series').$request->input('uri');
                }
            }else{
                $request->session()->flash('error', __('series could not be load. Please, try again.'));
                return redirect()->route('/series').$request->input('uri');
            }
        } catch (Exception $ex) {
            abort(404);
        }   
    }
    
    
     /**
     * update Series data
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
			$description = $request->input('description');
			$status = $request->input('status');
			$updated_by = $admin;
			$updated_at =  Carbon::now();
            
            $editArray = ['name'=>$name,
						'description'=>$description,
                        'status'=>'active',
                        'updated_at'=>$updated_at,
                        'updated_by'=>$updated_by,
                        ];
            $updateData = Series::where('id',$id)->update($editArray);
 
            if($updateData){
                $request->session()->flash('success', __('Series has been update successfully.'));
                return redirect()->route('series',$request->input('uri'));
            }
            $request->session()->flash('error', __('Series could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Series could not be saved. Please, try again.'));
        }
    }
	
	
    /**
     * Delete Series  
     *
     * @param $request
     * 
     * @return ajax
     */
     
    public function destroy($id,Request $request){
        try {
            if(is_numeric($id) && !empty($id)){
                $deleteArray = ['status' => config('constants.STATUS.STATUS_DELETE'),'updated_by' => Auth::guard('administrator')->user()->id];
                $delete = Series::where('id', '=', $id)->update($deleteArray);
                if($delete){
                    $request->session()->flash('success', __('Series has been deleted successfully.'));
                } else {
                    $request->session()->flash('error', __('Series can not be deleted. Please try again.'));
                }
                return redirect()->route('series').$request->input('uri');
            }else{
                $request->session()->flash('error', __('Series can not be deleted. Please try again.'));
                 return redirect()->route('series').$request->input('uri');
            }   
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Series can not be deleted. Please try again.'));
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
			$update_active = Series::where('id', '=', $id)->update(['status' => 'active']);
			$request->session()->flash('success', __('Series status updated successfully.'));
		}elseif($status == 'active'){
			$update_inactive = Series::where('id', '=', $id)->update(['status' => 'inactive']);
			$request->session()->flash('success', __('Series status updated successfully.'));
		}
        return redirect()->back();
    }
	   
}
