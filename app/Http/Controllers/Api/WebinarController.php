<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Repositories\WebinarLike;
use App\Http\Requests\Api\WebinarLikeDislikeRequest;
use Carbon\Carbon;
use DB;
class WebinarController extends Controller
{

    /**
     * Define the API response
     */
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }

    /**
     * Tag List
     * 
     * @param Request $request
     * @return type
     */
    public function index()
    {
        try {
            $webinars = Webinar::select('webinars.id', DB::raw('CONCAT(speakers.first_name, " ",speakers.last_name) as name'), 'webinars.title', 'webinars.duration', 'webinars.recorded_date', 'webinars.cpa_credit', 'webinars.fee','webinars.start_time', 'webinars.end_time')
                ->with('company:id,name')
                /*->leftJoin('webinar_like', function($query) {
                    $query->on('webinar_like.webinar_id', '=', 'webinars.id')->where('webinar_like.user_id', auth('api')->user()->id);
                })*/
                ->leftJoin('speakers','speakers.id','=','webinars.created_by')
                ->active()->orderBy('webinars.id', 'DESC')->paginate(config('constants.API.DEFAULT_PAGE'));
                if ($webinars->count() > 0) {
                    foreach($webinars as $key => $row) {
                        $webinarList[$key] = [
                            'id' => $row->id,
                            'title' => !empty($row->title) ? $row->title : "",
                            'name' => !empty($row->name) ? $row->name : "",
                            'duration' => !empty($row->duration) ? $row->duration : "",
                            'recorded_date' => !empty($row->recorded_date) ? $row->recorded_date : "",
                            'cpa_credit' => !empty($row->cpa_credit) ? $row->cpa_credit : "",
                            'fee' => !empty($row->fee) ? $row->fee : "",
                            'start_time' => !empty($row->start_time) ? $row->start_time : "",
                            'end_time' => !empty($row->end_time) ? $row->end_time : "",
                        ];
                    }
                }
            return $this->APIResponse->respondWithMessageAndPayload([
                            'webinar' => !empty($webinarList) ? $webinarList : [],
                                ]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Company detail
     * 
     * @param Request $request
     * @return type
     */
    public function detail(Request $request)
    {
        try {
            $company = Company::select('companies.id', 'companies.name', 'website', 'contact_number', 'companies.description', 'logo', DB::raw('count(speakers.id) as total_speaker'), DB::raw('count(webinars.id) as total_webinar'))
            ->leftJoin('speakers', function($join) {
                    $join->on('companies.id', '=', 'speakers.company_id')->where('speakers.status', '=', config('constants.STATUS.STATUS_ACTIVE'));
            })->leftJoin('webinars', function($join) {
                    $join->on('webinars.created_by', '=', 'speakers.id')->where('webinars.status', '=', config('constants.ADMIN_CONST.STATUS_ACTIVE'));
            })
            ->active()->groupBy('companies.id')->where('companies.id', '=', $request->id)->first();
            if (!empty($company)) {
                $companyData = [
                    'id' => $company->id,
                    'name' => !empty($company->name) ? $company->name : "",
                    'website' => !empty($company->website) ? $company->website : "",
                    'contact_number' => !empty($company->contact_number) ? $company->contact_number : "",
                    'logo' => asset($company->logo_url),
                    'description' => !empty($company->description) ? $company->description : "",
                    'number_of_speaker' => !empty($company->total_speaker) ? $company->total_speaker : 0,
                    'number_of_webinar' => !empty($company->total_webinar) ? $company->total_webinar : 0,
                ];
            }

            return $this->APIResponse->respondWithMessageAndPayload([
                            'company' => !empty($companyData) ? $companyData : [],
                                ]);
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
    public function likeDislike(WebinarLikeDislikeRequest $request) {
        try {
            $checkFollow = WebinarLike::select('id')->where([['webinar_id', '=', $request->webinar_id], ['user_id','=', auth('api')->user()->id]])->count();
            if($checkFollow == '0') {
                $created_at = Carbon::now();
                $speakerInsert = ['webinar_id'=> $request->webinar_id,
                                'user_id'=> auth('api')->user()->id,
                                'created_at'=>$created_at
                              ];
                $followInser = WebinarLike::create($speakerInsert);
                return $this->APIResponse->respondWithMessage(__('Webinar like successfully.'));
            } else {
                WebinarLike::where([['webinar_id', '=', $request->webinar_id], ['user_id','=', auth('api')->user()->id]])->delete();
                return $this->APIResponse->respondWithMessage(__('Webinar dislike successfully.'));
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
	
	
	
	 /**
     * Get my favorite webinar list
     *
     * @param $request
     * @return response
     */
    public function myFavorite(Request $request) {
        try {
            $webinar = WebinarLike::select('webinar_like.webinar_id','webinar_like.user_id', 'webinars.title','webinars.start_time', 'webinars.duration', 'webinars.image', 'webinars.end_time','webinars.recorded_date','webinars.webinar_type','webinars.time_zone', 'webinars.cpa_credit', 'webinars.fee','speakers.first_name','speakers.last_name','speakers.company_id', 'speakers.avatar', 'companies.name as CompanyName', 'companies.logo', 'webinars.view_count', DB::raw('COUNT(wl.id) as favorites_count'))
                ->leftJoin('webinar_like as wl', function($query) {
                    $query->on('wl.webinar_id', '=', 'webinar_like.webinar_id');
                })            
				->leftJoin('webinars', function($query) {
					$query->on('webinars.id', '=', 'webinar_like.webinar_id');
				})
				->leftJoin('speakers', function($query) {
					$query->on('speakers.id', '=', 'webinars.created_by')->where('webinars.added_by','=','speaker');
				})
				->leftJoin('companies', function($query) {
					$query->on('companies.id', '=', 'speakers.company_id');
				})
                ->groupBy('webinar_like.webinar_id')
				->where('webinar_like.user_id', '=', auth('api')->user()->id)->where('webinars.status','=',config('constants.STATUS.STATUS_ACTIVE'))->get();

			if (count($webinar)>0) {
				 foreach($webinar as $key => $row) {
                    $myFavoriteWebinarList[$key] = [
						'webinat_title' => (!empty($row->title)) ? $row->title : "",
						'webinat_id' => !empty($row->webinar_id) ? $row->webinar_id : "",
						'speaker_name' => (!empty($row->first_name) &&  !empty($row->last_name)) ? $row->first_name.' '.$row->last_name : "",
						'company_name' => !empty($row->CompanyName) ? $row->CompanyName : "",
						'webinar_duration_min' => $row->webinar_type == 'live'  ? number_format((strtotime($row->end_time) - strtotime($row->start_time))/3600,2) : "",
						'date' => !empty($row->start_time) ? date('d/m/Y',strtotime($row->start_time)) : date('d/m/Y',strtotime($row->recorded_date)),
						'time' => !empty($row->start_time) ? date('h:m A',strtotime($row->start_time)).' + '.$row->time_zone : date('h:m A',strtotime($row->recorded_date)).' + '.$row->time_zone,
						'credit_no' => !empty($row->cpa_credit) ? $row->cpa_credit : "0",
						'view_number' => !empty($row->view_count) ? $row->view_count : 0,
						'thumb_image' => !empty($row->image) ? env("APP_URL").'/uploads/webinar_image/'.$row->image : "",
						'fee' => !empty($row->fee) ? $row->fee : "Free",
                        'favorites_count' => !empty($row->favorites_count) ? $row->favorites_count : 0,
					];
                }
				
		    }
            return $this->APIResponse->respondWithMessageAndPayload([
                            'my_favorite_webinar' => !empty($myFavoriteWebinarList) ? $myFavoriteWebinarList : [],
                                ]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
	}
}
