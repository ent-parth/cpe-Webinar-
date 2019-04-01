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
use App\Repositories\Courses;
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

class ArchivedWebinarController extends Controller{

    /**
     * Archived WebinarControlle listing
     *
     * @var string
     */
    
	public function index(Request $request){
		$archived_webinars = Webinar::select('id','title', 'fee','webinar_type','recorded_date','start_time', 'end_time', 'created_at', 'status','time_zone');
		
		// For status filter			
        $status = $request->input('status');
        if ($status == 'active') {
        	$archived_webinars = $archived_webinars->where('webinars.webinar_type', '=', 'archived');
        	$archived_webinars = $archived_webinars->where('webinars.status', '=', 'active');
        
        }elseif($status == 'inactive'){
		   $webinars = $archived_webinars->where('webinars.webinar_type', '=', 'archived');
           $archived_webinars = $archived_webinars->where('webinars.status', '=', 'inactive');
		}elseif($status == 'draft'){
    		$archived_webinars = $archived_webinars->where('webinars.webinar_type', '=', 'live');
           // $archived_webinars = $archived_webinars->where('webinars.status', '=', 'active');

		}
		



		// For date filter			
        $recorded_date = $request->input('recorded_date');
        if ($recorded_date != '') {
        	$archived_webinars = $archived_webinars->where('recorded_date', '>=', $recorded_date);
        }
		
		
        // For text input filter
        if ($request->input('title') != '') {
			$searchStr =  $request->input('title');
			$searchStr = '%' . $searchStr . '%';
		    $archived_webinars = $archived_webinars->where('title', 'LIKE', $searchStr);
		}
		
		$archived_webinars = $archived_webinars->where('end_time', '<=', Carbon::now())->where('status', '=','active')->orderby('start_time', 'asce')->paginate(env('PAGINATION'));
		$archived_webinars =	$archived_webinars->appends(request()->query());
		
		
			$statusList = StatusHelper::getArchiveStatusesList();
        
		if ($request->ajax()) {
			return Response::json(View('speaker/archived-webinars/index-ajax', compact('archived_webinars','statusList'))->render());
		}
		
        return view('speaker.archived-webinars.index', compact('archived_webinars','statusList'));
    }

    	/**
	* View Archive Webinars status 
	 * @param Request $request
     * @return type
     * @throws NotFoundException
     */
	 
	 public function view(Request $request, $id){
		 $id = decrypt($id);
		  $LiveWebinarsView = Webinar::select('webinars.id','webinars.cpa_credit','webinars.title','webinars.image','webinars.learning_objectives','webinars.Instructional_method', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.webinar_transcription','webinars.description','webinars.subject_area','webinars.course_level','webinars.pre_requirement','webinars.advance_preparation','who_should_attend','webinars.faq_1','webinars.faq_2','webinars.faq_3','webinars.faq_4','webinars.faq_5','webinars.recorded_date','webinars.start_time', 'webinars.end_time','webinars.tag', 'webinars.created_at','webinars.created_by', 'webinars.status','speakers.first_name','speakers.last_name','webinars.video','webinars.documents','webinars.time_zone')
		 ->leftJoin('course_levels','course_levels.id','=','webinars.course_level')//courselevel id comaa seperate pdya chhe
		 ->leftJoin('courses','courses.course_level_id','=','course_levels.id')
		 ->leftjoin('user_types','user_types.id','=','webinars.who_should_attend') 
		 ->leftjoin('speakers','speakers.id','=','webinars.created_by') 
		 ->leftJoin('tags','tags.id','=','webinars.tag')
		 ->where('webinars.id','=', $id)
		 ->first();
		  //dd($SelfStudyWebinarsView);
		   return view('speaker.archived-webinars.view', compact('LiveWebinarsView'));
	 }
	
	
	
 
		
}
