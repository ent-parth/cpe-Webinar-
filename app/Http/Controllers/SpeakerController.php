<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Models\Speaker;
use App\Http\Requests\SpeakerRequest;
use App\Models\Country;
use App\Models\Company;

class SpeakerController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Speaker';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'speakers';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Speakers')]);

        return view('backEnd.speaker.index', compact('statusList'));
    }

    /**
     * Returns the speakers list
     *
     * @throws NotFoundException When invalid request
     */
    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'first_name',
            2 => 'email',
            2 => 'contact_no',
            3 => 'status',
        ];

        $start = !empty($request->input('start')) ? intval($request->input('start')) : 1;
        $limit = intval($request->input('length'));

        $page = intval(($start / $limit) + 1);
        $columnValue = !empty($request->input('order.0.column')) ? $request->input('order.0.column') : 0;
        $columnName = !empty($columnArr[$columnValue]) ? $columnArr[$columnValue] : 'created_at';
        $columnOrderBy = !empty($request->input('order.0.dir')) ? $request->input('order.0.dir') : 'desc';

        $this->getCurrentPageNo($page);
        $searchData = [];
        $requestData = ['email', 'contact_no'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        if (!empty($request->status)) {
            $searchData[] = ['status', $request->status];
        }

        $speakersData = Speaker::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);
        if (!empty($request->name)) {
            $speakersData->where(function ($query) use ($request) {
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$request->name%' ");
            });
        }

        try {
            $speakers = $speakersData->paginate($limit);
            $paginationCount = $speakers->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        return response()->view('backEnd.speaker.json.get_list', compact('speakers', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        $companyList = Company::getCompany();
        $countries = Country::getCountry();
        config(['app.name' => __('Add') . ' | ' . __('Speakers')]);

        return view('backEnd.speaker.add', compact('statusList', 'companyList', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpeakerRequest $request)
    {
        try {
            $requestData = $request->all();
            if (empty($requestData['company_id'])) {
                $company = Company::create($requestData['companies']);
                $requestData['company_id'] = $company->id;
            }
            unset($requestData['companies']);

            //$requestData['created_by'] = Auth::guard('administrator')->user()->id;

            $speaker = Speaker::create($requestData);

            if ($speaker) {
                //$this->sendMail('speaker', $request->all());
                $request->session()->flash('success', __('Speaker has been added successfully.'));

                return redirect()->route('show-speaker-login-form');
            } else {
                $request->session()->flash('error', __('Speaker could not be saved. Please try again.'));
            }
        } catch (Exception $ex) {
            return response()->view('backEnd.errors.404');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        try {
            $speaker = Speaker::select('id', 'role_id', 'first_name', 'last_name', 'email', 'contact_no', 'status', 'avatar')->notDeleted()
                    ->with('permissions:title')
                    ->findOrFail($id);

            $permission = !empty($speaker->permissions->toArray()) ? array_column($speaker->permissions->toArray(), 'title') : '';
            $statusList = CommonHelper::activeInactiveStatus();

            config(['app.name' => __('View') . ' | ' . __('Speakers')]);

            return view('backEnd.speaker.view', compact('speaker', 'statusList', 'permission'));
        } catch (Exception $ex) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $speakers = Speaker::notDeleted()->findOrFail($request->id);
            $statusList = StatusHelper::getStatusesList();
            $countries = Country::getCountry();
            $companyList = Company::getCompany();
            config(['app.name' => __('Edit') . ' | ' . __('Speakers')]);

            return view('backEnd.speaker.edit', compact('speakers', 'statusList', 'countries', 'companyList'));
        } catch (Exception $ex) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpeakerRequest $request)
    { 
        $speaker = Speaker::notDeleted()->findOrFail($request->id);
		
        $updateData = $request->all();
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        if ($speaker) {
			//dd($updateData);
            if ($speaker->update($updateData)) {
				// Store Permission in permission table.
                /*if ($request->role_id == config('constants.ADMIN_CONST.SUPER_ADMIN')) {
                    $request->permission_key = [];
                }
                $saveRolePermission = $this->saveRolePermission($speaker->id, $request->permission_key);
                */
                $request->session()->flash('success', __('Speaker has been updated successfully.'));
                return redirect('/speakers');
            } else {
                $request->session()->flash('error', __('Speaker could not be updated. Please, try again.'));
            }
        }
    }

    /**
     * Check email for user
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkEmail(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $checkEmail = Speaker::notDeleted()->where('email', $request['email']);
        if (!empty($request['id'])) {
            $checkEmail->where('id', '<>', $request['id']);
        }
        $flag = $checkEmail->count() > 0 ? 'false' : 'true';

        return $flag;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $speaker = Speaker::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($speaker->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');

        $request->session()->flash('success', __('Speaker status updated successfully.'));
        $flag = ($speaker->update($updateData)) ? 'true' : 'false';

        return redirect('/speakers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $speaker = Speaker::notDeleted()->findOrFail($request->id);
            $speaker->status = config('constants.STATUS.STATUS_DELETE');
            $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
            if ($speaker->save()) {
                $data = ['success' => 'Speaker has been deleted successfully.'];
            } else {
                $data = ['error' => 'Speaker can not be deleted. Please try again.'];
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            abort(404);
        }
    }

    /**
     * Remove the multiple speaker.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $speaker = Speaker::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($speaker) {
                    $data = ['success' => 'Speaker(s) has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Speaker(s) can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Speaker(s) can not be deleted. Please try again.'];
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            abort(404);
        }
    }


    /**
     * Set the email content
     * Sent the email
     * 
     * @param type $slug email slug
     * @param type $userData user data
     */
    public function sendMail($slug, $userData)
    {
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

}
