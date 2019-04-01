<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;

class SubjectController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Subject';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'subjects';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Subjects')]);

        return view('backEnd.subjects.index', compact('statusList'));
    }

    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'subject',
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
        $requestData = ['subject'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        if (!empty($request->status)) {
            $searchData[] = ['status', $request->status];
        }
        $subjectData = Subject::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);

        try {
            $subjects = $subjectData->paginate($limit);
            $paginationCount = $subjects->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.subjects.json.get_list', compact('subjects', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        return view('backEnd.subjects.add', compact('statusList'));
    }

    public function store(SubjectRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $subject = Subject::create($requestData);
            if ($subject) {
                $request->session()->flash('success', __('Subject has been added successfully.'));

                return redirect()->route('subjects');
            }
            $request->session()->flash('error', __('Subject could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Subject could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $subject = Subject::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($subject) {
                return view('backEnd.subjects.edit', compact('subject', 'statusList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(SubjectRequest $request)
    {
        try {
            $subject = Subject::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $subject->modified_by = Auth::guard('administrator')->user()->id;
            $updateSubject = $subject->update($request->all());
            if ($updateSubject) {
                $request->session()->flash('success', __('Subject has been updated successfully.'));

                return redirect()->route('subjects');
            }
            $request->session()->flash('error', __('Subject could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Subject could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $subject = Subject::notDeleted()->findOrFail($request->id);
            $subject->modified_by = Auth::guard('administrator')->user()->id;
            $subject->status = config('constants.STATUS.STATUS_DELETE');
           if ($subject->save()) {
                $data = ['success' => __('Subject has been deleted successfully.')];
            } else {
                $data = ['error' => __('Subject can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Subject can not be deleted. Please try again.'));
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
                $subject = Subject::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($subject) {
                    $data = ['success' => 'Subjects has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Subjects can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Subjects can not be deleted. Please try again.'];
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
        $subject = Subject::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($subject->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('Subject status updated successfully.'));
        $flag = ($subject->update($updateData)) ? 'true' : 'false';

        return redirect()->route('subjects');
    }

    /**
     * Check Subject for subject
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkSubject(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkSubject = Subject::notDeleted()->where('subject', $request['name']);
        if (!empty($request['id'])) {
            $checkSubject->where('id', '<>', $request['id']);
        }
        $flag = $checkSubject->count() > 0 ? 'false' : 'true';

        return $flag;
    }
}
