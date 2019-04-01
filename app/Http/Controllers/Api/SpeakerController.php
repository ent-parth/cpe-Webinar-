<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use App\Models\Speaker;
use App\Models\Company;
use App\Http\Requests\Api\SpeakerFollowUnfollowRequest;
use App\Http\Requests\Api\SpeakerLikeDislikeRequest;
use Carbon\Carbon;
use App\Repositories\SpeakerFollow;
use App\Repositories\SpeakerLike;
use DB;

class SpeakerController extends Controller
{

    /**
     * Define the API response
     */
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }

    /**
     * Speaker List
     * 
     * @param Request $request
     * @return type
     */
    public function index()
    {
        try {
            $user = !empty(auth('api')->user()->id) ? auth('api')->user()->id : 0;
            $speakers = Speaker::select('speakers.id', 'first_name', 'last_name', 'company_id', 'email', 'contact_no', 'avatar', 'expertise', 'about_speaker', 'state_id', 'city_id', DB::raw('COUNT(speaker_follow.user_id) AS follower_count'), DB::raw('(CASE WHEN speaker_follow.user_id = ' . $user . ' THEN 1 END) AS user_id'))->with('company', 'state', 'city')
            ->leftJoin('speaker_follow', function($query) {
                $query->on('speaker_follow.speaker_id', '=', 'speakers.id');
            })
            ->groupBy('speakers.id')->active()->get();
			if ($speakers->count() > 0) {
                foreach($speakers as $key => $row) {
                    if (!empty(auth('api')->user()->id)) {
    					//$checkUserFollow = SpeakerFollow::select('id')->where([['speaker_id', '=', $row->id], ['user_id','=', auth('api')->user()->id]])->count();
    					$checkUserFavorite = SpeakerLike::select('id')->where([['speaker_id', '=', $row->id], ['user_id','=', auth('api')->user()->id]])->count();
					} else {
                        $checkUserFavorite = $checkUserFollow = 0;
                    }
                    $speakerList[$key] = [
                        'id' => $row->id,
                        'name' => !empty($row->full_name) ? $row->full_name : "",
                        'email' => !empty($row->email) ? $row->email : "",
                        'contact_no' => !empty($row->contact_no) ? $row->contact_no : "",
                        'logo' => asset($row->avatar_url),
                        'expertise' => !empty($row->expertise) ? $row->expertise : "",
                        'about_speaker' => !empty($row->about_speaker) ? $row->about_speaker : "",
                        'company' => !empty($row->company->name) ? $row->company->name : "",
                        'state' => !empty($row->state->name) ? $row->state->name : "",
                        'city' => !empty($row->city->name) ? $row->city->name : "",
						'favorite_unfavorite_status' => $checkUserFavorite == 0 ? 'No':'Yes',
						'follow_unfollow_status' => !empty($row->user_id) ? 'Yes':'No',
                        'follower_count' => !empty($row->follower_count) ? $row->follower_count : 0
                    ];
                }
            }
            return $this->APIResponse->respondWithMessageAndPayload([
                            'speakers' => !empty($speakerList) ? $speakerList : [],
                                ]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Speaker detail
     * 
     * @param Request $request
     * @return type
     */
    public function detail(Request $request)
    {
        try {
            $speaker = Speaker::select('speakers.id', 'first_name', 'last_name', 'company_id', 'email', 'contact_no', 'avatar', 'expertise', 'about_speaker', 'state_id', 'city_id', 'speaker_follow.user_id')->with('company', 'state', 'city')
				->leftJoin('speaker_follow', function($query) {
					$query->on('speaker_follow.speaker_id', '=', 'speakers.id')->where('speaker_follow.user_id', !empty(auth('api')->user()->id) ? auth('api')->user()->id : 0);
				})
				->active()
				->where('speakers.id', '=', $request->id)
				->first();
			
            if(!empty($speaker)){
            	if (!empty(auth('api')->user()->id)) {
					$checkFollow = SpeakerFollow::select('id')->where('speaker_id', '=', $speaker->id)->count();
					$checkUserFollow = SpeakerFollow::select('id')->where('speaker_id', '=', $speaker->id)->where('user_id','=', auth('api')->user()->id)->count();
					$checkUserFavorite = SpeakerLike::select('id')->where('speaker_id', '=', $speaker->id)->where('user_id','=', auth('api')->user()->id)->count();
				 }else{
					$checkFollow = '';
					$checkUserFollow = '';
					$checkUserFavorite = '';
				 }
					
                $speakerData = [
                    'id' => $speaker->id,
                    'name' => !empty($speaker->full_name) ? $speaker->full_name : "",
                    'email' => !empty($speaker->email) ? $speaker->email : "",
                    'contact_no' => !empty($speaker->contact_no) ? $speaker->contact_no : "",
                    'logo' => asset($speaker->avatar_url),
                    'expertise' => !empty($speaker->expertise) ? $speaker->expertise : "",
                    'about_speaker' => !empty($speaker->about_speaker) ? $speaker->about_speaker : "",
                    'favourite' => !empty($row->user_id) ? 1 : 0,
                    'company' => !empty($speaker->company->name) ? $speaker->company->name : "",
                    'state' => !empty($speaker->state->name) ? $speaker->state->name : "",
                    'city' => !empty($speaker->city->name) ? $speaker->city->name : "",
					'follower_count' => !empty($checkFollow ) ? $checkFollow : "0",
					'favorite_unfavorite_status' => $checkUserFavorite == 0 ? 'No':'Yes',
					'follow_unfollow_status' => $checkUserFollow == 0 ? 'No':'Yes',
                ];
            }
            return $this->APIResponse->respondWithMessageAndPayload([
                            'speaker' => !empty($speakerData) ? $speakerData : [],
                                ]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * store follow user wise 
     *
     * @param $request
     * @return response
     */
    public function followUnfollow(SpeakerFollowUnfollowRequest $request) {
        try {
            $checkFollow = SpeakerFollow::select('id')->where([['speaker_id', '=', $request->speaker_id], ['user_id','=', auth('api')->user()->id]])->count();
            if($checkFollow == '0') {
                $created_at = Carbon::now();
                $speakerInsert = ['speaker_id'=> $request->speaker_id,
                                'user_id'=> auth('api')->user()->id,
                                'created_at'=>$created_at
                              ];
                $followInser = SpeakerFollow::create($speakerInsert);
                return $this->APIResponse->respondWithMessage(__('Speaker follow successfully.'));
            } else {
                SpeakerFollow::where([['speaker_id', '=', $request->speaker_id], ['user_id','=', auth('api')->user()->id]])->delete();
                return $this->APIResponse->respondWithMessage(__('Speaker unfollow successfully.'));
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
	
	
	/**
     * store webinar like or dislike
     *
     * @param $request
     * @return response
     */
    public function likeDislike(SpeakerLikeDislikeRequest $request) {
        try {
            $checkFollow = SpeakerLike::select('id')->where([['speaker_id', '=', $request->speaker_id], ['user_id','=', auth('api')->user()->id]])->count();
            if($checkFollow == '0') {
                $created_at = Carbon::now();
                $speakerInsert = ['speaker_id'=> $request->speaker_id,
                                'user_id'=> auth('api')->user()->id,
                                'created_at'=>$created_at
                              ];
                $followInser = SpeakerLike::create($speakerInsert);
                return $this->APIResponse->respondWithMessage(__('Speaker like successfully.'));
            } else {
                SpeakerLike::where([['speaker_id', '=', $request->speaker_id], ['user_id','=', auth('api')->user()->id]])->delete();
                return $this->APIResponse->respondWithMessage(__('Speaker dislike successfully.'));
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
	
	
	
	 /**
     * Get my favorite speaker list
     *
     * @param $request
     * @return response
     */
    public function myFavorite(Request $request) {
        try {
            $speaker = SpeakerLike::select('speaker_like.speaker_id','speaker_like.user_id', 'speakers.first_name', 'speakers.last_name', 'speakers.company_id', 'speakers.email', 'speakers.contact_no', 'speakers.avatar', 'speakers.expertise', 'speakers.about_speaker', 'companies.name as CompanyName', 'states.name as stateName', 'cities.name as cityName', 'companies.logo')
            						->leftJoin('speakers', function($query) {
                						$query->on('speakers.id', '=', 'speaker_like.speaker_id');
            						})
									->leftJoin('companies', function($query) {
                						$query->on('companies.id', '=', 'speakers.company_id');
            						})
									->leftJoin('states', function($query) {
                						$query->on('states.id', '=', 'speakers.state_id');
            						})
									->leftJoin('cities', function($query) {
                						$query->on('cities.id', '=', 'speakers.city_id');
            						})
									->where('speaker_like.user_id', '=', auth('api')->user()->id)->where('speakers.status', '=', config('constants.STATUS.STATUS_ACTIVE'))->get();
			if (count($speaker)>0) {
                $speakerModel = new Speaker;
                $companyModel = new Company;
				 foreach($speaker as $key => $row) {
                    $checkFollow = SpeakerFollow::select('id')->where([['speaker_id', '=', $row->speaker_id]])->count();
					$checkUserFollow = SpeakerFollow::select('id')->where([['speaker_id', '=', $row->speaker_id], ['user_id','=', auth('api')->user()->id]])->count();
					$checkUserFavorite = SpeakerLike::select('id')->where([['speaker_id', '=', $row->speaker_id], ['user_id','=', auth('api')->user()->id]])->count();

					$myFavoriteSpeakerList[$key] = [
											'speaker_name' => (!empty($row->first_name) &&  !empty($row->last_name)) ? $row->first_name.' '.$row->last_name : "",
											'company_name' => !empty($row->CompanyName) ? $row->CompanyName : "",
											'area_of_expertise' => "",
											'speaker_id' => !empty($row->speaker_id) ? $row->speaker_id : "",
                                            'speaker_image' => asset($speakerModel->getAvatarUrlAttribute($row->avatar)),
                                            'logo' => asset($companyModel->getLogoUrlAttribute($row->logo)),
											'email' => !empty($row->email) ? $row->email : "",
											'speaker_mobile_no' => !empty($row->contact_no) ? $row->contact_no : "",
											'about_speaker' => !empty($row->about_speaker) ? $row->about_speaker : "",
											'no_of_followers_count' => !empty($row->total_webinar) ? $row->total_webinar : 0,
											'state' => !empty($row->stateName) ? $row->stateName : "",
											'city' => !empty($row->cityName) ? $row->cityName : "",
											'rating' => "",
											'followers' => !empty($checkFollow) ? $checkFollow : "",
											'favorite_unfavorite_status' => $checkUserFavorite == 0 ? 'No':'Yes',
											'follow_unfollow_status' => $checkUserFollow == 0 ? 'No':'Yes',
										];
                }
				
		    }
            return $this->APIResponse->respondWithMessageAndPayload([
                            'my_favorite_speaker' => !empty($myFavoriteSpeakerList) ? $myFavoriteSpeakerList : [],
                                ]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
}
