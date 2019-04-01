<?php
namespace App\Http\Controllers\Speaker;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\WebinarRequest;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Webinar;
use App\Repositories\UserType;
use App\Repositories\WebinarQuestions;
use App\Repositories\CourseLevel;
use App\Repositories\Tag;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use DateTime;
use DateTimeZone;
use File;
use Redirect;

class WebinarQuestionsController extends Controller{

    /**
     * Webinar Question listing
     *
     * @var string
     */
    
    public function index(Request $request){
        $WebinarQuestions = WebinarQuestions::select('webinar_questions.id','webinar_questions.webinar_id', 'webinar_questions.type','webinar_questions.time','webinar_questions.question','webinar_questions.option_a','webinar_questions.option_b', 'webinar_questions.option_c', 'webinar_questions.option_d','webinar_questions.answer', 'webinar_questions.status','webinar_questions.created_at','webinar_questions.updated_at','webinar_questions.added_by','webinar_questions.updated_by','webinars.title')
											->leftjoin('webinars','webinars.id','=','webinar_questions.webinar_id');
		
        // For status filter            
        $status = $request->input('status');
        if ($status != '') {
            $WebinarQuestions= $WebinarQuestions->where('webinar_questions.status', '=', $status);
        }else{
            $WebinarQuestions= $WebinarQuestions->where('webinar_questions.status', '!=', 'delete');
        }
		
		// For Type filter            
        $status = $request->input('type');
        if ($status != '') {
            $WebinarQuestions= $WebinarQuestions->where('webinar_questions.type', '=', $status);
        }
		// For Text Filter (1)
		 $searchStr = $request->input('question');
        if ($searchStr != '') {
            $searchStr = '%' . $searchStr . '%';
		    $WebinarQuestions = $WebinarQuestions->where('webinar_questions.question', 'LIKE', $searchStr);
	    }
		// For Text Filter (2)  
		 $searchStr = $request->input('webinar_id');
        if ($searchStr != '') {
            $searchStr = '%' . $searchStr . '%';
		    $WebinarQuestions = $WebinarQuestions->where('webinars.title', 'LIKE', $searchStr);
	    }
		
        $WebinarQuestions= $WebinarQuestions->where('webinar_questions.added_by',Auth::guard('speaker')->user()->id)->orderby('id', 'desc')->paginate(env('PAGINATION'));
        $WebinarQuestions= $WebinarQuestions->appends(request()->query());
        $statusList = StatusHelper::getStatusesList();
		
        if ($request->ajax()) {
            return Response::json(View('speaker/webinar_questions/index-ajax', compact('WebinarQuestions','webinars','statusList'))->render());
        }
        return view('speaker.webinar_questions/index', compact('WebinarQuestions','webinars','statusList'));
    }
    
    
    /**
     * Create Webinar Question View
     *
     * @param $request
     * 
     * @return view
     */
    public function create() {
        $webinars = Webinar::select('id','title')
                            ->where('status','!=','delete')
							->where('webinar_type','=','self_study')
                            ->orderBy('title', 'ASC')
                            ->get();
                         
        $statusList = StatusHelper::getStatusesList();                                      
        return view('speaker/webinar_questions/add',compact('webinars','statusList'));
    }
	
	 /**
     * Webinar Question store 
     *
     * @param $request
     * 
     * @return view
     */
    public function store(Request $request) {
        try {
			$webinar_id = $request->input('webinar_id');
			$type = $request->input('type');
			$time = $request->input('time');
			$question = $request->input('question');
			$option_a = $request->input('option_a');
			$option_b = $request->input('option_b');
			$option_c = $request->input('option_c');
			$option_d = $request->input('option_d');
			$answer = $request->input('answer');
			$status = 'active';
			$added_by = Auth::guard('speaker')->user()->id;
			$created_at = Carbon::now();
			
			$addArray = ['webinar_id'=>$webinar_id,
						'type'=>$type,
						'time'=>$time,
						'question'=>$question,
						'option_a'=>$option_a,
						'option_b'=>$option_b,
						'option_c'=>$option_c,
						'option_d'=>$option_d,
						'answer'=>$answer,
						'status'=>$status,
						'created_at'=>$created_at,
						'added_by'=>$added_by
						];
			$createdData = WebinarQuestions::create($addArray);
			
				if($createdData){
				 return redirect('webinar-questions/');
				}
					$request->session()->flash('error', __('Webinar Questions could not be saved. Please, try again.'));
				} catch (Exception $exc) {
				$request->session()->flash('error', __('Webinar Questions could not be saved. Please, try again.'));
			}
    }
     
    
    /**
     * Get Webinar Question edit view
     *
     * @param $id
     * 
     * @return view
     */
    public function edit($id) {
		$id = decrypt($id);
		$WebinarQuestionsEdit= WebinarQuestions::select('id','webinar_id', 'type','time','question','option_a','option_b', 'option_c', 'option_d','answer', 'status','created_at','updated_at','added_by','updated_by')->where('id','=',$id)->first();
		
		$webinars = Webinar::select('id','title')
						->where('status','=','active')
						->where('webinar_type','=','self_study')
						->orderBy('title', 'ASC')
						->get();
                         
        $statusList = StatusHelper::getStatusesList(); 
		return view('speaker/webinar_questions/edit',compact('WebinarQuestionsEdit','webinars','statusList'));
			
        }   
   
    
    
     /**
     * update Webinar Question
     *
     * @param $request
     * 
     * @return view
     */
    public function update(Request $request) { 
        try {
			$id = $request->input('id');
			$webinar_id = $request->input('webinar_id');
			$type = $request->input('type');
			$time = $request->input('time');
			$question = $request->input('question');
			$option_a = $request->input('option_a');
			$option_b = $request->input('option_b');
			$option_c = $request->input('option_c');
			$option_d = $request->input('option_d');
			$answer = $request->input('answer');
			$updated_by = Auth::guard('speaker')->user()->id;
			$updated_at = Carbon::now();
			
			$editArray = ['webinar_id'=>$webinar_id,
						'type'=>$type,
						'time'=>$time,
						'question'=>$question,
						'option_a'=>$option_a,
						'option_b'=>$option_b,
						'option_c'=>$option_c,
						'option_d'=>$option_d,
						'answer'=>$answer,
						'updated_at'=>$updated_at,
						'updated_by'=>$updated_by
						];
	
			$updateData = WebinarQuestions::where('id',$id)->update($editArray);
				if($updateData){
					$request->session()->flash('success', __('Webinar Question has been updated successfully.'));
					return redirect()->route('speaker.webinar-questions',$request->input('uri'));
				}
				$request->session()->flash('error', __('Webinar Question could not be saved. Please, try again.'));
				} catch (Exception $exc) {
				$request->session()->flash('error', __('Webinar Question could not be saved. Please, try again.'));
			}
   }
    
    /**
     * Delete Webinar Question  
     *
     * @param $request
     * 
     * @return ajax
     */
     
    public function destroy($id,Request $request){
		$id = decrypt($id);
        try {
			if(is_numeric($id) && !empty($id)){
				$deleteArray = ['status' => config('constants.STATUS.STATUS_DELETE'),'updated_by' => Auth::guard('speaker')->user()->id];
				
				$delete = WebinarQuestions::where('id', '=', $id)->update($deleteArray);
				if($delete){
					$request->session()->flash('success', __('Webinar Questions has been deleted successfully.'));
				} else {
					$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
				}
				return redirect()->route('speaker.webinar-questions').$request->input('uri');
			}else{
				$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
				 return redirect()->route('speaker.webinar-questions').$request->input('uri');
			}   
		} catch (Exception $ex) {
			$request->session()->flash('error', __('Webinar Questions can not be deleted. Please try again.'));
		}
    }
}
