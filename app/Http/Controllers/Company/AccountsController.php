<?php
namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\WebinarRequest;
use App\Helpers\StatusHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Repositories\CompanyUser;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use DateTime;
use DateTimeZone;
use File;
use CommonHelper;

class AccountsController extends Controller{
	
	
	/**
     * Company Dashboard Controller
     *
     * @var string
     */
    
	public function dashboard(Request $request){
		return view('company.accounts.dashboard', compact(''));	
	}
    
	
	/**
     * edit company profile
     *
     * @param $id
     * 
     * @return view
     */
    public function edit(Request $request) {
		$id = Auth::guard('company')->user()->id;
		try{
			if(is_numeric($id) && !empty($id)){
				$companyDetail = CompanyUser::where('id',Auth::guard('company')->user()->id)->where('status','active')->first();
				$expMonth = '';
				$expYear = '';	
				if(!empty($companyDetail->card_expiry_date)){
					$expdate = explode('/',$companyDetail->card_expiry_date);
					$expMonth = $expdate[0];
					$expYear = $expdate[1];	
				}
				return view('company.accounts.edit_profile', compact('companyDetail','expMonth','expYear'));
			}else{
				$request->session()->flash('error', __('cant find company detail, Please try again.'));
				return redirect()->route('company.dashboard');
			}
        } catch (Exception $ex) {
            abort(404);
        }	
	}
	
	
	 /**
     * update webinar data
     *
     * @param $request
     * 
     * @return view
     */
    public function update(Request $request) { 
		try {
			$company_name = $request->input('company_name');
			$logo = $request->file('logo');
			$name = $request->input('name');
			$person_email = $request->input('person_email');
			$phone = $request->input('phone');
			$phone_ext = $request->input('phone_ext');
			$mobile = $request->input('mobile');
			$designation = $request->input('designation');
			$website = $request->input('website');
			$about_company = $request->input('about_company');
			$credit_card_number = $request->input('credit_card_number');
			$name_on_card = $request->input('name_on_card');
			$card_expiry_date = $request->input('card_expiry_month').'/'.$request->input('card_expiry_year');
			$card_cvv = $request->input('card_cvv');
			$updated_at = Carbon::now();
			
			//Store webinar documents
			$destinationPath = "uploads/company_logo/";
			if (!file_exists($destinationPath)) {
				mkdir($destinationPath, 0777, true);
			}
			
			$companyDetail	= CompanyUser::select('id','logo')->where('id',Auth::guard('company')->user()->id)->where('status','active')->first();
			if($logo != ''){
				if(!empty($companyDetail)){
					$logoSize = $logo->getSize();
					$logoName = str_replace(' ','-',time().$logo->getClientOriginalName());
					$logoExt = strtolower($logo->getClientOriginalExtension());
					$logoAllowedExt = 'xyz,jpg,png,gif,jpeg';
					if($logoSize < 81920099999999) { //800kb
						if(strpos($logoAllowedExt,$logoExt) == true){
							//Delete old documents and store new documents
							$DeleteUrl = public_path('uploads/company_logo/'.$companyDetail->logo);
							File::delete($DeleteUrl);
							//Store new file in syatem
							$logo->move($destinationPath,$logoName);
							$logoURL = $logoName;
						}else{
							$request->session()->flash('error', __('Please upload valid file. Format should be: jpg, png, gif, jpeg.'));
							return redirect()->back();
							$logoURL = $companyDetail->logo;
						}
					}else{
						$request->session()->flash('error', __('Uploaded file size should be less than 800kb.'));
						return redirect()->back();
						$logoURL = $companyDetail->logo;	
					}
				}	
			}else{
				$logoURL = $companyDetail->logo;
			}
			
			
			$editArray = ['company_name'=>$company_name,
						'name'=>$name,
						'person_email'=>$person_email,
						'phone'=>$phone,
						'phone_ext'=>$phone_ext,
						'mobile'=>$mobile,
						'designation'=>$designation,
						'website'=>$website,
						'logo'=>$logoURL,
						'about_company'=>$about_company,
						'credit_card_number'=>$credit_card_number,
						'name_on_card'=>$name_on_card,
						'card_expiry_date'=>$card_expiry_date,
						'card_cvv'=>$card_cvv,
						'updated_at'=>$updated_at,
						];
			$updateData = CompanyUser::where('id',Auth::guard('company')->user()->id)->where('status','active')->update($editArray);
		    if($updateData){
				$request->session()->flash('success', __('Company information has been update successfully.'));
                return redirect()->route('company-edit');
            }else{
            	$request->session()->flash('error', __('Thare was some issue in update company information, Please try again.'));
				return redirect()->route('company-edit');
			}
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Company information could not be update, Please try again.'));
			return redirect()->route('company-edit');
        }
	}
		
}
