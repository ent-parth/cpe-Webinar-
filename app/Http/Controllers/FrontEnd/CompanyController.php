<?php
namespace App\Http\Controllers\FrontEnd;
use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Models\Company;

class CompanyController extends BaseController
{
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Company';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function signup(Request $request)
    {
        $sucess_msg = "";
        $requestData = $request->all();
        if(count($requestData))
        {
            $company = Company::create($requestData);
            if ($company) 
            {
                $request->session()->flash('success', __('Company register successfully.'));
                return redirect()->route('frontend.company.signup');
            }
        }
        $statusList = StatusHelper::getStatusesList();
        $title = "Company Signup";
        return view('frontEnd.speaker.signup_compnay.index',compact('statusList','title','sucess_msg'));
    }

}
