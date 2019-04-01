<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\CourseLevelRequest;
use App\Models\CourseLevel;

class CourseLevelController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'CourseLevel';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'courseLevel';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Course Level')]);

        return view('backEnd.course_level.index', compact('statusList'));
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
        $courseLevelData = CourseLevel::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);

        try {
            $courseLevel = $courseLevelData->paginate($limit);
            $paginationCount = $courseLevel->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.course_level.json.get_list', compact('courseLevel', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        return view('backEnd.course_level.add', compact('statusList'));
    }

    public function store(CourseLevelRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $courseLevel = CourseLevel::create($requestData);
            if ($courseLevel) {
                $request->session()->flash('success', __('Course level has been added successfully.'));

                return redirect()->route('course-level');
            }
            $request->session()->flash('error', __('Course level could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Course level could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $courseLevel = CourseLevel::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($courseLevel) {
                return view('backEnd.course_level.edit', compact('courseLevel', 'statusList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(CourseLevelRequest $request)
    {
        try {
            $courseLevel = CourseLevel::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $courseLevel->modified_by = Auth::guard('administrator')->user()->id;
            $updateCourseLevel = $courseLevel->update($request->all());
            if ($updateCourseLevel) {
                $request->session()->flash('success', __('Course level has been updated successfully.'));

                return redirect()->route('course-level');
            }
            $request->session()->flash('error', __('Course level could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Course level could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $courseLevel = CourseLevel::notDeleted()->findOrFail($request->id);
            $courseLevel->modified_by = Auth::guard('administrator')->user()->id;
            $courseLevel->status = config('constants.STATUS.STATUS_DELETE');
            if ($courseLevel->save()) {
                \App\Models\Course::where('course_level_id', $request->id)->update(['status' => config('constants.STATUS.STATUS_DELETE')]);
                $data = ['success' => __('Course level has been deleted successfully.')];
            } else {
                $data = ['error' => __('Course level can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Course level can not be deleted. Please try again.'));
        }
    }

    /**
     * Remove the multiple course level.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $courseLevel = CourseLevel::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($courseLevel) {
                    \App\Models\Course::whereIn('course_level_id', $request->id)->update(['status' => config('constants.STATUS.STATUS_DELETE')]);
                    $data = ['success' => 'Course level has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Course level can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Course level can not be deleted. Please try again.'];
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
        $courseLevel = CourseLevel::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($courseLevel->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('Course level status updated successfully.'));
        $flag = ($courseLevel->update($updateData)) ? 'true' : 'false';

        return redirect()->route('course-level');
    }

    /**
     * Check course-level for course-level
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkCourseLevel(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkCourseLevel = CourseLevel::notDeleted()->where('name', $request['name']);
        if (!empty($request['id'])) {
            $checkCourseLevel->where('id', '<>', $request['id']);
        }
        $flag = $checkCourseLevel->count() > 0 ? 'false' : 'true';

        return $flag;
    }
}
