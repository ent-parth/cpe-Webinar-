<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use App\Models\Speaker;
use App\Models\Company;
use App\Http\Requests\Api\CompanyLikeDislikeRequest;
use App\Repositories\CompanyLike;
use Carbon\Carbon;
use DB;
class CompanyController extends Controller
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
    public function index(Request $request)
    {
        try {

            $companies = Company::select('companies.id', 'companies.name', 'website', 'contact_number', 'companies.description', 'companies.country_id', 'companies.state_id', 'companies.city_id', 'logo', DB::raw('count(speakers.id) as total_speaker'), DB::raw('count(webinars.id) as total_webinar'), 'company_like.user_id')
				->leftJoin('speakers', function($join) {
						$join->on('companies.id', '=', 'speakers.company_id')->where('speakers.status', '=', config('constants.STATUS.STATUS_ACTIVE'));
				})->leftJoin('webinars', function($join) {
						$join->on('webinars.created_by', '=', 'speakers.id')->where('webinars.status', '=', config('constants.ADMIN_CONST.STATUS_ACTIVE'));
				})->leftJoin('company_like', function($query) {
                    $query->on('company_like.company_id', '=', 'companies.id')->where('company_like.user_id', !empty(auth('api')->user()->id) ? auth('api')->user()->id : 0);
                })->with('country:id,name', 'state:id,name', 'city:id,name')
				->active()->groupBy('companies.id');
			if (!empty($request->name)) {
				$companies->where('companies.name', "LIKE", "%" . $request->name . "%");
			}
			$companies = $companies->get();
            if ($companies->count() > 0) {
                foreach($companies as $key => $row) {
                    $companyList[$key] = [
                        'id' => $row->id,
                        'name' => !empty($row->name) ? $row->name : "",
                        'website' => !empty($row->website) ? $row->website : "",
                        'contact_number' => !empty($row->contact_number) ? $row->contact_number : "",
                        'logo' => asset($row->logo_url),
                        'description' => !empty($row->description) ? $row->description : "",
                        'number_of_speaker' => !empty($row->total_speaker) ? $row->total_speaker : 0,
                        'number_of_webinar' => !empty($row->total_webinar) ? $row->total_webinar : 0,
                        'favourite_unfavorite_status' => !empty($row->user_id) ? 1 : 0,
                        'country' => !empty($row->country->name) ? $row->country->name : "",
                        'state' => !empty($row->state->name) ? $row->state->name : "",
                        'city' => !empty($row->city->name) ? $row->city->name : ""
                    ];
                }
            }
            return $this->APIResponse->respondWithMessageAndPayload([
                            'company' => !empty($companyList) ? $companyList : [],
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
            $company = Company::select('companies.id', 'companies.name', 'website', 'contact_number', 'companies.description', 'companies.country_id', 'companies.state_id', 'companies.city_id', 'logo', DB::raw('count(speakers.id) as total_speaker'), DB::raw('count(webinars.id) as total_webinar'), 'company_like.user_id')
            ->leftJoin('speakers', function($join) {
                    $join->on('companies.id', '=', 'speakers.company_id')->where('speakers.status', '=', config('constants.STATUS.STATUS_ACTIVE'));
            })->leftJoin('webinars', function($join) {
                    $join->on('webinars.created_by', '=', 'speakers.id')->where('webinars.status', '=', config('constants.ADMIN_CONST.STATUS_ACTIVE'));
            })->leftJoin('company_like', function($query) {
                $query->on('company_like.company_id', '=', 'companies.id')->where('company_like.user_id', !empty(auth('api')->user()->id) ? auth('api')->user()->id : 0);
            })->with('country:id,name', 'state:id,name', 'city:id,name')
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
                    'favourite_unfavorite_status' => !empty($company->user_id) ? 1 : 0,
                    'country' => !empty($company->country->name) ? $company->country->name : "",
                        'state' => !empty($company->state->name) ? $company->state->name : "",
                        'city' => !empty($company->city->name) ? $company->city->name : ""
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
    public function likeDislike(CompanyLikeDislikeRequest $request) {
        try {
            $checkFollow = CompanyLike::select('id')->where([['company_id', '=', $request->company_id], ['user_id','=', auth('api')->user()->id]])->count();
            if($checkFollow == '0') {
                $created_at = Carbon::now();
                $speakerInsert = ['company_id'=> $request->company_id,
                                'user_id'=> auth('api')->user()->id,
                                'created_at'=>$created_at
                              ];
                $followInser = CompanyLike::create($speakerInsert);
                return $this->APIResponse->respondWithMessage(__('Company like successfully.'));
            } else {
                CompanyLike::where([['company_id', '=', $request->company_id], ['user_id','=', auth('api')->user()->id]])->delete();
                return $this->APIResponse->respondWithMessage(__('Company dislike successfully.'));
            }
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
	
	/**
     * Get my favorite company list
     *
     * @param $request
     * @return response
     */
    public function myFavorite(Request $request) {
        try {
            $company = CompanyLike::select('company_like.company_id','company_like.user_id', 'companies.name','companies.logo','companies.website','companies.contact_number','companies.description',DB::raw('count(speakers.id) as total_speaker'), DB::raw('count(webinars.id) as total_webinar'), 'speakers.avatar')
				->leftJoin('companies', function($query) {
					$query->on('companies.id', '=', 'company_like.company_id');
				})->leftJoin('speakers', function($join) {
						$join->on('companies.id', '=', 'speakers.company_id')->where('speakers.status', '=', config('constants.STATUS.STATUS_ACTIVE'));
				})->leftJoin('webinars', function($join) {
						$join->on('webinars.created_by', '=', 'speakers.id')->where('webinars.status', '=', config('constants.ADMIN_CONST.STATUS_ACTIVE'));
				})->where('company_like.user_id', '=', auth('api')->user()->id)->where('companies.status', '=', config('constants.STATUS.STATUS_ACTIVE'))
                ->groupBy('companies.id')->get();
            //echo "<pre>"; print_r($company[0]->company_id); exit;
            if ($company[0]->company_id !='') {
                $speakerModel = new Speaker;
                $companyModel = new Company;
				 foreach($company as $key => $row) {
					$checkCompanyFavorite = CompanyLike::select('id')->where([['company_id', '=', $row->company_id], ['user_id','=', auth('api')->user()->id]])->count();
                    $myFavoriteCompanyList[$key] = [
											'company_name' => (!empty($row->name)) ? $row->name : "",
                                            'speaker_image' => asset($speakerModel->getAvatarUrlAttribute($row->avatar)),
                                            'logo' => asset($companyModel->getLogoUrlAttribute($row->logo)),
											'about_company' => !empty($row->description) ? $row->description : "",
											'company_website' => !empty($row->website) ? $row->website : "",
											'no_of_speaker' => !empty($row->total_speaker) ? $row->total_speaker : 0,
											'no_of_webinar' => !empty($row->total_webinar) ? $row->total_webinar : 0,
											'company_mobile' => !empty($row->contact_number) ? $row->contact_number : "",
											'company_id' => !empty($row->company_id) ? $row->company_id : 0,
											'favorite_unfavorite_status' => $checkCompanyFavorite == 0 ? 'No':'Yes',
											'state' => "",
											'city' => "",
										];
                }
				
		    }
            return $this->APIResponse->respondWithMessageAndPayload([
            	'my_favorite_company' => !empty($myFavoriteCompanyList) ? $myFavoriteCompanyList : [],
            ]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
}
