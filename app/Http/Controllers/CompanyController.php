<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CompaniesRequest;
use App\Helpers\StatusHelper;
use App\Models\Company;
use App\Models\Country;
use CommonHelper;
use Carbon\Carbon;
use Exception;

class CompanyController extends Controller {

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Company';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'companies';

    /**
     * Show the company user details
     *
     * @return type
     */
    public function index() {
        config(['app.name' => __('Companies')]);

        return view('backEnd.companies.index');
    }

    /**
     * Show the company listing
     *
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
    public function getList(Request $request) {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'name',
            2 => 'contact_number',
        ];

        $start = !empty($request->input('start')) ? intval($request->input('start')) : 1;
        $limit = intval($request->input('length'));
		
        $page = intval(($start / $limit) + 1);
        $columnValue = !empty($request->input('order.0.column')) ? $request->input('order.0.column') : 0;
        $columnName = !empty($columnArr[$columnValue]) ? $columnArr[$columnValue] : 'companies.created_at';
        $columnOrderBy = !empty($request->input('order.0.dir')) ? $request->input('order.0.dir') : 'desc';

        $this->getCurrentPageNo($page);
        $searchData = [];
        $requestData = ['name', 'contact_number'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        $companyData = Company::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);
        try {
            $companies = $companyData->paginate($limit);
            $paginationCount = $companies->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        return response()->view('backEnd.companies.json.get_list', compact('companies', 'paginationCount', 'limit', 'page'));
    }

    /**
     * Show the company detail form
     *
     * @return type
     */
    public function create() {
        $statusList = StatusHelper::getStatusesList();
        $countries = Country::getCountry();
        config(['app.name' => __('Add') . ' | ' . __('Company')]);

        return view('backEnd.companies.add', compact('statusList', 'countries'));
    }

    /**
     * Save the company and its user
     *
     * @param CompaniesRequest $request
     * @return type
     */
    public function store(CompaniesRequest $request) {
        try {
            // Save company
            $company = Company::create($request->all());
            if ($company) {
                $request->session()->flash('success', __('Company has been added successfully.'));
                return redirect()->route('companies');
            }
            $request->session()->flash('error', __('Company could not be saved. Please try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Company could not be saved. Please try again.'));
            return redirect()->route('companies');
        }
    }

    /**
     * Show the company edit form
     *
     * @param type $id company id
     * @return type
     */
    public function edit($id = null) {
        try {
            $statusList = StatusHelper::getStatusesList();
            $company = Company::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            $countries = Country::getCountry();
            config(['app.name' => ucwords($company->name) . ' | ' . __('Edit') . ' | ' . __('Company')]);

            return view('backEnd.companies.edit', compact('company', 'statusList', 'countries'));
        } catch (Exception $ex) {
            abort(404);
        }
    }

    /**
     * Update the company data
     *
     * @param CompaniesRequest $request
     * @return type
     */
    public function update($id, CompaniesRequest $request) {

        try {
            $company = Company::notDeleted()->findOrFail($id); // active() is fetch the record which status <> deleted.
            $requestData = $request->all();
            $requestData['modified_by'] = Auth::guard('administrator')->user()->id;
            $updateCompany = $company->update($requestData);
            if ($updateCompany) {
                $request->session()->flash('success', __('Company has been updated successfully.'));
                return redirect()->route('companies');
            }
            $request->session()->flash('error', __('Company could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Company could not be updated. Please, try again.'));
        }
    }

    public function view($id = null) {
        try {
            $companies = Company::with(['companyUser' => function($query) {
                    $query->where('user_type', '=', config('constants.COMPANY.COMPANY_OWNER'));
                }])->notDeleted()->findOrFail($id);
            $companyUsers = $companies->companyUser()->first();
            config(['app.name' => ucwords($companies->name) . ' | ' . __('messages.view') . ' | ' . __('messages.company')]);

            return view('backEnd.companies.view', compact('companies', 'companyUsers'));
        } catch (Exception $exc) {
            abort(404);
        }
    }

    /**
     * Soft delete
     *
     * @param Request $request
     * @return type
     */
    public function destroy(Request $request) {
        try {
            $company = Company::notDeleted()->findOrFail($request->id);
            $company->status = config('constants.STATUS.STATUS_DELETE');
            if ($company->save()) {
                $data = ['success' => __('Company has been deleted successfully.')];
            } else {
                $data = ['error' => __('Company can not be deleted. Please try again.')];
            }
            echo json_encode($data);
            //return redirect()->route('companies');
        } catch (Exception $ex) {
            abort(404);
        }
    }

    /**
     * Remove the multiple company.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $company = Company::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($company) {
                    $data = ['success' => 'Companies has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Companies can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Companies can not be deleted. Please try again.'];
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function checkCompanyName(Request $request) {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $searchData = [];
        $searchData[] = ['name', '=', trim($request->name)];
        if (!empty($request->id)) {
            $searchData[] = ['id', '<>', $request->id];
        }
        $data = Company::notDeleted()->where($searchData)->first();
        $flag = !empty($data) ? 'false' : 'true';

        return $flag;
    }

    /**
     * Check the active email
     * check the email exist or not
     *
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
    public function checkEmail(Request $request) {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $searchData = [];
        $searchData[] = ['email', '=', trim($request->email)];
        if (!empty($request->id)) {
            $searchData[] = ['id', '<>', $request->id];
        }
        $data = Company::notDeleted()->where($searchData)->first();
        $flag = !empty($data) ? 'false' : 'true';

        return $flag;
    }

    /**
     * Get the city and area data
     *
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
    public function getCitAreaList(Request $request) {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $data = ($request->name === 'companies[country_id]' ) ? City::getCity($request->id) : Area::getArea($request->id);
        $data['name'] = $request->name;

        return $data;
    }

    /**
     * Update the status
     *
     * @param Request $request
     * @return type
     * @throws NotFoundException
     */
    public function statusUpdate(Request $request) {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $speaker = Company::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($speaker->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');

        $request->session()->flash('success', __('Company status updated successfully.'));
        $flag = ($speaker->update($updateData)) ? 'true' : 'false';

        return redirect('/companies');
    }

    /**
     * Set the email content
     * Sent the email
     *
     * @param type $slug email slug
     * @param type $userData user data
     */
    public function sendMail($slug, $userData) {
        $emailTemplate = EmailTemplate::getEmailTemplate($slug);
        if (!empty($emailTemplate)) {
            $replacementArr['USER_NAME'] = $userData['first_name'] . ' ' . $userData['last_name'];
            $replacementArr['EMAIL'] = $userData['email'];
            $replacementArr['URL'] = env('APP_URL');
            $replacementArr['PASSWORD'] = $userData['password'];
            $emailContent = CommonHelper::replaceEmailContent($emailTemplate->template_text, $replacementArr);
            Mail::to($userData['email'])->send(new CommonMail($emailContent, 'Welcome to Mycpa'));
        }

        return false;
    }

    /**
     * Set the Compmany Subscription Plan
     *
     * @param type $companyId Company Id
     * @param type $companySubscriptionPlanId Company Subscription Plan Id
     */
    public function saveCompanySubscriptionPlan($companyId = null, $companySubscriptionPlanId = null) {

        if (!empty($companyId) && !empty($companySubscriptionPlanId)) {
            $subscriptionPlan = SubscriptionPlan::findOrFail($companySubscriptionPlanId);
            $requestData = [
                'company_id' => $companyId,
                'plan_id' => $companySubscriptionPlanId,
                'plan_name' => $subscriptionPlan->name,
                'price' => $subscriptionPlan->price,
                'number_of_month' => $subscriptionPlan->number_of_month,
                'start_date' => Carbon::today(),
                'expiry_date' => Carbon::today()->addMonths($subscriptionPlan->number_of_month),
                'status' => 'active'
            ];
            $companySubscriptionPlan = SubscriptionPlanLog::updateOrCreate(
                            ['company_id' => $companyId], $requestData
            );
            if (!empty($companySubscriptionPlan)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function subscriptionPlanUpdate(Request $request) {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $subscriptionPlanCurrent = SubscriptionPlanLog::where([['company_id', $request->company_id], ['status', 'active']])->orderBy('id', 'desc')->get();
        $subscriptionPending = SubscriptionPlanLog::where([['company_id', $request->company_id], ['status', 'pending']])->get();
        if (($subscriptionPlanCurrent[0]->expiry_date) < (Carbon::today())) {
            $requestData = [
                'start_date' => Carbon::today(),
                'expiry_date' => Carbon::today()->addMonths($subscriptionPending[0]->number_of_month),
                'status' => 'active'
            ];
        } else {
            $requestData = [
                'start_date' => Carbon::parse($subscriptionPlanCurrent[0]->expiry_date)->addDay(),
                'expiry_date' => Carbon::parse($subscriptionPlanCurrent[0]->expiry_date)->addDay()->addMonths($subscriptionPending[0]->number_of_month),
                'status' => 'active'
            ];
        }
        $subscriptionPlanUpdated = SubscriptionPlanLog::where([
                    ['company_id', $request->company_id], ['status', 'pending']]
                )->update($requestData);
        if ($subscriptionPlanUpdated) {
            $request->session()->flash('success', __('Plan has been Subscribed Successfully'));
            return redirect()->route('companies');
        }
        $request->session()->flash('error', __('Plan has not been Subscribed Successfully'));
    }

}
