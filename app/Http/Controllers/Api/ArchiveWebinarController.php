<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use App\Models\Webinar;
use Carbon\Carbon;
use DB;

class ArchiveWebinarController extends Controller
{

	/**
     * Define the API response
     */
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }

    /**
     * Archieved webinar Controller listing
     *
     * @var string
     */
    
	public function index(Request $request) {
		try {
			$archivedWebinars = Webinar::select('webinars.id','webinars.title','webinars.cpa_credit', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.webinar_transcription','webinars.description','webinars.subject_area','webinars.course_level','webinars.pre_requirement','webinars.advance_preparation','who_should_attend','webinars.faq_1','webinars.faq_2','webinars.faq_3','webinars.faq_4','webinars.faq_5','webinars.recorded_date','webinars.start_time', 'webinars.end_time','webinars.tag', 'webinars.created_at','webinars.created_by', 'webinars.status', DB::raw('CONCAT(speakers.first_name, " ",speakers.last_name) as speaker_name'),'webinars.video','webinars.documents','webinars.time_zone', 'companies.name', DB::raw('COUNT(webinar_like.id) as favorites_count'), 'webinars.view_count', 'speakers.about_speaker', 'webinars.Instructional_method', 'webinars.learning_objectives', 'webinars.image')
			->leftJoin('course_levels','course_levels.id','=','webinars.course_level')//courselevel id comaa seperate pdya chhe
			->leftJoin('courses','courses.course_level_id','=','course_levels.id')
			->leftjoin('user_types','user_types.id','=','webinars.who_should_attend') 
			->leftjoin('speakers','speakers.id','=','webinars.created_by')
			->leftjoin('companies','companies.id','=','speakers.company_id') 
			->leftJoin('tags','tags.id','=','webinars.tag')
			->leftJoin('webinar_like', 'webinar_like.webinar_id', '=', 'webinars.id') 
			->where('webinars.webinar_type','=', config('constants.WEBINAR_TYPE.ARCHIVED'))
			->active()->orderby('start_time', 'ASC')->paginate(config('constants.API.DEFAULT_PAGE'));

			if ($archivedWebinars->count() > 0) {
	            foreach($archivedWebinars as $key => $row) {
	                $webinarList[$key] = [
	                    'id' => $row->id,
	                    'title' => !empty($row->title) ? $row->title : "",
	                    'speaker_name' => !empty($row->speaker_name) ? $row->speaker_name : "",
	                    'company_name' => !empty($row->name) ? $row->name : "",
	                    'duration' => !empty($row->presentation_length) ? $row->presentation_length . " minutes" : "0 minutes",
	                    'date' => !empty($row->recorded_date) ? $row->recorded_date : "",
	                    'fee' => !empty($row->fee) ? $row->fee : 0,
	                    'video' => !empty($row->vimeo_url) ? $row->vimeo_url : "",
	                    'cpa_credit' => !empty($row->cpa_credit) ? $row->cpa_credit : "",
	                    'subject_area' => !empty($row->subject_area) ? $row->subject_area : "",
	                    'course_level' => !empty($row->course_level) ? $row->course_level : "",
	                    'advance_preparation' => !empty($row->advance_preparation) ? $row->advance_preparation : "",
	                    'who_should_attend' => !empty($row->who_should_attend) ? $row->who_should_attend : "",
	                    'time_zone' => !empty($row->time_zone) ? $row->time_zone : "",
	                    'course_description' => !empty($row->description) ? $row->description : "",
	                    'favorites_count' => !empty($row->favorites_count) ? $row->favorites_count : "",
	                    'time' => Carbon::parse($row->start_time)->format('g:i A'),
	                    'view_count' => !empty($row->view_count) ? $row->view_count : "",
	                    'thumb_image' => !empty($row->image) ? env("APP_URL").'/uploads/webinar_image/'.$row->image : "",
	                    'rating_of_webinar' => "",
	                    'Instructional_method' => !empty($row->Instructional_method) ? $row->Instructional_method : "",
	                    'prerequisite' => "",
	                    'handout_material' => "",
	                    'learning_objectives' => !empty($row->learning_objectives) ? $row->learning_objectives : "",
	                    'FAQ' => "",
	                    'about_speaker' => !empty($row->about_speaker) ? $row->about_speaker : "",
	                    'rating_review' => "",
	                    // 'number_of_speaker' => !empty($row->total_speaker) ? $row->total_speaker : 0,
	                    // 'number_of_webinar' => !empty($row->total_webinar) ? $row->total_webinar : 0,
	                ];
	            }
	        }
		 	return $this->APIResponse->respondWithMessageAndPayload([
                            'webinars' => !empty($webinarList) ? $webinarList : [],
                                ]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }	 
}
