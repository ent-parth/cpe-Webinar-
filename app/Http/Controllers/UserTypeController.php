<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\UserTypeRequest;
use App\Models\UserType;

class UserTypeController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'UserType';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'userType';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('User Types')]);

        return view('backEnd.user_types.index', compact('statusList'));
    }

    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'name',
            2 => 'status',
        ];

        $start = !empty($request->input('start')) ? intval($request->input('start')) : 1;
        $limit = intval($request->input('length'));

        $page = intval(($start / $limit) + 1);
        $columnValue = !empty($request->input('order.0.column')) ? $request->input('order.0.column') : 0;
        $columnName = !empty($columnArr[$columnValue]) ? $columnArr[$columnValue] : 'created_at';
        $columnOrderBy = !empty($request->input('order.0.dir')) ? $request->input('order.0.dir') : 'desc';

        $this->getCurrentPageNo($page);
        $searchData = [];
        $requestData = ['name'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        if (!empty($request->status)) {
            $searchData[] = ['status', $request->status];
        }
        $userTypeData = UserType::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);

        try {
            $userTypes = $userTypeData->paginate($limit);
            $paginationCount = $userTypes->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.user_types.json.get_list', compact('userTypes', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        return view('backEnd.user_types.add', compact('statusList'));
    }

    public function store(UserTypeRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $userType = UserType::create($requestData);
            if ($userType) {
                $request->session()->flash('success', __('User type has been added successfully.'));

                return redirect()->route('user-types');
            }
            $request->session()->flash('error', __('User type could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('User type could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $userType = UserType::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($userType) {
                return view('backEnd.user_types.edit', compact('userType', 'statusList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(UserTypeRequest $request)
    {
        try {
            $userType = UserType::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $userType->modified_by = Auth::guard('administrator')->user()->id;
            $updateUserType = $userType->update($request->all());
            if ($updateUserType) {
                $request->session()->flash('success', __('User type has been updated successfully.'));

                return redirect()->route('user-types');
            }
            $request->session()->flash('error', __('User type could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('User type could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $userType = UserType::notDeleted()->findOrFail($request->id);
            $userType->modified_by = Auth::guard('administrator')->user()->id;
            $userType->status = config('constants.STATUS.STATUS_DELETE');
           if ($userType->save()) {
                $data = ['success' => __('User type has been deleted successfully.')];
            } else {
                $data = ['error' => __('User type can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('User type can not be deleted. Please try again.'));
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
                $userType = UserType::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($userType) {
                    $data = ['success' => 'User Types has been deleted successfully.'];
                } else {
                    $data = ['error' => 'User Types can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'User Types can not be deleted. Please try again.'];
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            abort(404);
        }
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
        $userType = UserType::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($userType->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('User type status updated successfully.'));
        $flag = ($userType->update($updateData)) ? 'true' : 'false';

        return redirect()->route('user-types');
    }

    /**
     * Check UserType exists.
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkUserType(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkUserType = UserType::notDeleted()->where('name', $request['name']);
        if (!empty($request['id'])) {
            $checkUserType->where('id', '<>', $request['id']);
        }
        $flag = $checkUserType->count() > 0 ? 'false' : 'true';

        return $flag;
    }
}
