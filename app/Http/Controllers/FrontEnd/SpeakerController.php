<?php
namespace App\Http\Controllers\FrontEnd;
use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Models\Speaker;
use App\Models\Company;
use App\Models\Country;

class SpeakerController extends BaseController
{
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Speaker';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function signup(Request $request){
        $sucess_msg = "";
        $requestData = $request->all();
        if(count($requestData))
        {
            if (empty($requestData['company_id'])) 
            {
                $company = Company::create($requestData['companies']);
                $requestData['company_id'] = $company->id;
            }
            unset($requestData['companies']);
            $speaker = Speaker::create($requestData);
            if ($speaker) 
            {
                $request->session()->flash('success', __('Speaker register successfully.'));
                return redirect()->route('frontend.speaker.signup');
            }
        }

        $statusList = StatusHelper::getStatusesList();
        $companyList = Company::getCompany();
        $countries = Country::getCountry();
        $title = "Speaker Signup";
        return view('frontEnd.speaker.signup.index',compact('statusList', 'companyList', 'countries', 'title','sucess_msg'));
    }

}