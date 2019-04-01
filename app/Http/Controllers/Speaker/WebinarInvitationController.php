<?php
namespace App\Http\Controllers\Speaker;
use App\Http\Controllers\Controller;
use Auth;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\Webinar;
use App\Repositories\UserType;
use App\Repositories\Speakers;
use App\Repositories\SpeakerInvitation;
use App\Repositories\Notifications;
use App\Repositories\Administrators;
use App\Repositories\Courses;
use App\Repositories\CourseLevel;
use App\Repositories\WebinarCoOrganizer;
use App\Repositories\Tag;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use File;

class WebinarInvitationController extends Controller{

    /**
     * Speaker Controller listing
     *
     * @var string
     */
    
	public function index(Request $request){

		$webinarInvitation = SpeakerInvitation::select('speaker_invitation.id','speaker_invitation.webinar_id','speaker_invitation.speaker_id','speaker_invitation.status','webinars.title', 'webinars.description','webinars.webinar_type','webinars.recorded_date','webinars.start_time', 'webinars.end_time', 'webinars.created_at', 'webinars.status as webinarStatus','webinars.id as webinarId','webinar_co_organizer.joinLink')
												->leftJoin('webinars','webinars.id','=','speaker_invitation.webinar_id')
												//->leftJoin('webinar_co_organizer','webinars.id','=','webinar_co_organizer.webinar_id')
												->leftJoin('webinar_co_organizer', function($join){
													$join->on('webinar_co_organizer.webinar_id', '=', 'webinars.id');
													$join->on('webinar_co_organizer.speaker_id', '=', 'speaker_invitation.speaker_id');
												});
		
		// For status filter			
        $status = $request->input('status');
        if ($status != '') {
        	$webinarInvitation = $webinarInvitation->where('speaker_invitation.status', '=', $status);
        }
		
		// For date filter			
        $recorded_date = $request->input('recorded_date');
        if ($recorded_date != '') {
        	$webinarInvitation = $webinarInvitation->where('webinars.recorded_date', '>=', $recorded_date);
        }
		
        // For text input filter
        if ($request->input('title') != '') {
			$searchStr =  $request->input('title');
			$searchStr = '%' . $searchStr . '%';
		    $webinarInvitation = $webinarInvitation->where('webinars.title', 'LIKE', $searchStr);
		}
		
		$webinarInvitation = $webinarInvitation->where('speaker_invitation.speaker_id',Auth::guard('speaker')->user()->id)->orderby('speaker_invitation.id', 'desc')->groupby('speaker_invitation.id')->paginate(env('PAGINATION'));
		$webinarInvitation =	$webinarInvitation->appends(request()->query());
		//echo "<pre>"; print_r(Auth::guard('speaker')->user()->id); exit;
		
		$statusList = StatusHelper::getStatusesList();
        
		if ($request->ajax()) {
			return Response::json(View('speaker/webinar-invitation/index-ajax', compact('webinarInvitation','statusList'))->render());
		}
		
        return view('speaker.webinar-invitation.index', compact('webinarInvitation','statusList'));
    }


	
	

    /**
	* View Live Webinars status 
	 * @param Request $request
     * @return type
     * @throws NotFoundException
     */
	 
	public function view(Request $request, $id){
		$id = decrypt($id);
		$LiveWebinarsView = Webinar::select('speaker_invitation.id','webinars.title', 'webinars.fee','webinars.webinar_type','webinars.presentation_length','webinars.webinar_transcription','webinars.image','webinars.learning_objectives','webinars.Instructional_method','webinars.description','webinars.subject_area','webinars.course_level','webinars.pre_requirement','webinars.advance_preparation','who_should_attend','webinars.faq_1','webinars.faq_2','webinars.faq_3','webinars.faq_4','webinars.faq_5','webinars.recorded_date','webinars.start_time', 'webinars.end_time','webinars.tag', 'webinars.created_at','webinars.created_by', 'speaker_invitation.status','speakers.first_name','speakers.last_name','webinars.video','webinars.documents','webinars.time_zone','speaker_invitation.reason')
									->leftJoin('speaker_invitation','speaker_invitation.webinar_id','=','webinars.id')
									->leftJoin('course_levels','course_levels.id','=','webinars.course_level')//courselevel id comaa seperate pdya chhe
									->leftJoin('courses','courses.course_level_id','=','course_levels.id')
									->leftjoin('user_types','user_types.id','=','webinars.who_should_attend') 
									->leftjoin('speakers','speakers.id','=','webinars.created_by') 
									->leftJoin('tags','tags.id','=','webinars.tag')
									->where('speaker_invitation.id','=', $id)
									->first();

										//$webinars = $webinars->where('webinars.end_time', '<=', Carbon::now());


									//dd($SelfStudyWebinarsView);
		return view('speaker.webinar-invitation.view', compact('LiveWebinarsView'));
	 }
	 
	 
	/**
	* Update Invitation status
	 * @param Request $request
     * @return type
     * @throws NotFoundException
     */
	 public function updateStatus(Request $request) {
	 	$id = $request->input('id');
		$status = $request->input('status');
		$reason = $request->input('reason');
		 if(!empty($status)){
		 	if($status  == 'accepted'){
				//$url = 'https://api.getgo.com/oauth/v2/authorize?client_id='.env("GOTO_CONSUMER_KEY").'&response_type=code&state=create&redirect_uri='.env("SPEAKER_URL").'/webinar-invitation/create-co-organizer/'.$id;
				$this->CreateCoOrganizer($id,'create', $status, $reason, $request);
				//return redirect($url); 
			}elseif ($status  == 'rejected') {
				$editArray = ['status'=>$status,
		 				  'reason'=>$reason,
						  'updated_at'=>Carbon::now(),
						];
				$updateData = SpeakerInvitation::where('id',$id)->update($editArray);

				$speaker_invitation_data = SpeakerInvitation::where('id',$id)->first();

				//notification start

				$webinar_data = Webinar::select('id','title','created_by')->where('id','=',$speaker_invitation_data->webinar_id)->first();

				$first_name = Auth::guard('speaker')->user()->first_name;
				$last_name =  Auth::guard('speaker')->user()->last_name;

				$webinar_name =  $webinar_data->title;
				$speaker_id =  $webinar_data->created_by;
				$notification_text = 'Your invitation has been rejected by '.$first_name.' '.$last_name.' for '.$webinar_name;
				$link = 'webinar/speaker_invitation/'.encrypt($id); 

				$data = ['notification_text'=>$notification_text,
				'is_admin'=>'0',
				'user_id'=>$speaker_id,
				'created_at'=>Carbon::now(),
				'link'=>$link,

				];

				Notifications::insert($data);
				//notification end


				$request->session()->flash('success', __('Invitation has been rejected'));
			}	
			return redirect()->route('speaker.webinar-invitation',$request->input('uri'));

		} 
	}
	
	
	/**
	* Create new Co-organizer for webinar. (get webinar id and Speaker id from invitation id)
	 * @param $id
     * @return value
     * @throws NotFoundException
     */
	 public function CreateCoOrganizer($id, $state, $status, $reason, $request) {
		//$code = $request->input('code');
		//$state = $request->input('state');
		
		if(!empty($id) && !empty($state)){
			//for getting token
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.getgo.com/oauth/access_token');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=password&user_id=".env('GOTO_DIRECT_USER')."&password=".env('GOTO_DIRECT_PASSWORD')."&client_id=".env("GOTO_CONSUMER_KEY"));
			curl_setopt($ch, CURLOPT_POST, 1);
			
			$headers = array();
			$headers[] = 'Accept: application/json';
			$headers[] = 'Content-Type: application/x-www-form-urlencoded';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				$request->session()->flash('error', __(curl_error($ch)));
				return redirect()->route('speaker.webinar-invitation',$request->getQueryString());
			} else {
				//curl_close ($ch);
				$decodeData = json_decode($result);
				//dd($decodeData);
				if(!empty($decodeData) && !empty($decodeData->access_token) && !empty($decodeData->organizer_key)){
					 $accessToken = $decodeData->access_token;
					 $organizerKey = $decodeData->organizer_key;
					 			
					//get webinar detail from invitation table
					$getInvitationDetail = SpeakerInvitation::Select('id','webinar_id','speaker_id')->where('id',$id)->first();
					if(!empty($getInvitationDetail)){
						//get data for create webinar.
						$webinarData = Webinar::select('id','title','description','time_zone','start_time','end_time','webinar_key','created_by')->where('id','=',$getInvitationDetail->webinar_id)->first();
						//dd($webinarData);
						if(!empty($webinarData)){
							if($state == 'create'){
								//now you have to create co-organizer for this webinar
								$getSpeakerDetail = Speakers::select('id','first_name','last_name','email')->where('id',Auth::guard('speaker')->user()->id)->first();
								//dd($getSpeakerDetail);
								if(!empty($getSpeakerDetail)){
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, "https://api.getgo.com/G2W/rest/v2/organizers/".$organizerKey."/webinars/".$webinarData->webinar_key."/coorganizers");
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS, "[\n  {\n    \"external\": true,\n    \"organizerKey\": \"".$organizerKey."\",\n    \"givenName\": \"".$getSpeakerDetail->first_name.' '.$getSpeakerDetail->last_name."\",\n    \"email\": \"".$getSpeakerDetail->email."\"\n  }\n]");
									curl_setopt($ch, CURLOPT_POST, 1);
									
									$headers = array();
									$headers[] = "Content-Type: application/json";
									$headers[] = "Accept: application/json";
									$headers[] = "Authorization: ".$accessToken;
									curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									
									$organizerResult = curl_exec($ch);
									//dd($organizerResult);
									if (curl_errno($ch)) {
										$request->session()->flash('error', __(curl_error($ch)));
										//return redirect()->route('speaker.webinar-invitation',$request->input('uri'));
										return redirect()->back();
									}else{
										$coOrganizer = json_decode($organizerResult);
										//dd($coOrganizer);
										//now cretae new co-organizer for this webinar
										if(!empty($coOrganizer) && !isset($coOrganizer->errorCode)){
											$createCoOrganizer = WebinarCoOrganizer::create([
																					'webinar_id' => $webinarData->id,
																					'speaker_id' => Auth::guard('speaker')->user()->id,
																					'memberKey' => $coOrganizer[0]->memberKey,
																					'surname' => $coOrganizer[0]->surname,
																					'givenName' => $coOrganizer[0]->givenName,
																					'joinLink' => $coOrganizer[0]->joinLink,
																					'email' => $coOrganizer[0]->email,
																					'status' => config('constants.STATUS.STATUS_ACTIVE'),
																					'created_by' => Auth::guard('speaker')->user()->id,
																					'created_at' => Carbon::now()
																				 ]);
											//update status for invitation
											$editArray = ['status'=>$status,
														  'reason'=>$reason,
														  'updated_at'=>Carbon::now(),
														];
											$updateData = SpeakerInvitation::where('id',$id)->update($editArray);


											//notification start
											$first_name = Auth::guard('speaker')->user()->first_name;
											$last_name =  Auth::guard('speaker')->user()->last_name;

											$webinar_name =  $webinarData->title;
											$speaker_id =  $webinarData->created_by;
											$notification_text = 'Your invitation has been accpeted by '.$first_name.' '.$last_name.' for '.$webinar_name;
											$link = 'webinar/speaker_invitation/'.encrypt($id); 

											$data = ['notification_text'=>$notification_text,
											'is_admin'=>'0',
											'user_id'=>$speaker_id,
											'created_at'=>Carbon::now(),
											'link'=>$link,

											];

											Notifications::insert($data);
											//notification end

												 
											$request->session()->flash('success', __('Invitation has been accepted and Co-Organizer are added'));
											//return redirect()->route('speaker.webinar-invitation',$request->input('uri'));
											return redirect()->back();
										}elseif(empty($coOrganizer)){
											$request->session()->flash('error', __('Thare was a some issue in create webinar co-organizer'));
											//return redirect()->route('speaker.webinar-invitation',$request->input('uri'));	
											return redirect()->back();
										}else{
											$request->session()->flash('error', __('Cant create webinar co-organizer Error are:'.$coOrganizer->description.' - and Detail are : '.$coOrganizer->Details));
											//return redirect()->route('speaker.webinar-invitation',$request->input('uri'));
											return redirect()->back();
										}
									}
									curl_close ($ch);	
								}else{
									$request->session()->flash('error', __('Thare was a some issue in cretae Co-organizers for this webinar.'));
									//return redirect()->route('speaker.webinar-invitation',$request->input('uri'));	
									return redirect()->back();
								}	
							}
						}else{
							$request->session()->flash('error', __('No data found for webinar. Please try again.'));
							//return redirect()->route('speaker.webinar-invitation',$request->input('uri'));	
							return redirect()->back();
						}
					}else{
						$request->session()->flash('error', __('No Webinar found for this invitation. Please try again.'));
						//return redirect()->route('speaker.webinar-invitation',$request->input('uri'));	
						return redirect()->back();
					}
				}else{
					$request->session()->flash('error', __('There was a some issue in getting token from webinar. Please try again.'));
					//return redirect()->route('speaker.webinar-invitation',$request->input('uri'));	
					return redirect()->back();
				}
			}
		}else{
			$request->session()->flash('error', __('There was a some issue in getting code from webinar. Please try again.'));
			return redirect()->route('speaker.webinar-invitation');	
		}	
	 }
}
