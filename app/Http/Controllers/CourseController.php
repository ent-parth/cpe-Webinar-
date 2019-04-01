<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\CourseLevel;

class CourseController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Course';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'course';

    /**
     * Active Sidebar sub-menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'course';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        $courseLevelList = CourseLevel::notDeleted()->pluck('name', 'id');;
        config(['app.name' => __('Course')]);

        return view('backEnd.course.index', compact('statusList', 'courseLevelList'));
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
        if (!empty($request->course_level_id)) {
            $searchData[] = ['course_level_id', $request->course_level_id];
        }
        $courseData = Course::with('courseLevel')->notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);

        try {
            $courses = $courseData->paginate($limit);
            $paginationCount = $courses->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        return response()->view('backEnd.course.json.get_list', compact('courses', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        $courseLevelList = CourseLevel::getCourseLevel();
        return view('backEnd.course.add', compact('statusList', 'courseLevelList'));
    }

    public function store(Request $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $course = Course::create($requestData);
            if ($course) {
                $request->session()->flash('success', __('Course has been added successfully.'));

                return redirect()->route('course-list');
            }
            $request->session()->flash('error', __('Course could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Course could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $courseLevelList = CourseLevel::getCourseLevel();
            $course = Course::notDeleted()->findOrFail($id); // active() is fetch the record which status <> delete.
            if ($course) {
                return view('backEnd.course.edit', compact('course', 'statusList', 'courseLevelList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(CourseRequest $request)
    {
        try {
            $course = Course::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $course->modified_by = Auth::guard('administrator')->user()->id;
            $updateCourse = $course->update($request->all());
            if ($updateCourse) {
                $request->session()->flash('success', __('Course has been updated successfully.'));

                return redirect()->route('course-list');
            }
            $request->session()->flash('error', __('Course could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Course could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $course = Course::notDeleted()->findOrFail($request->id);
            $course->modified_by = Auth::guard('administrator')->user()->id;
            $course->status = config('constants.STATUS.STATUS_DELETE');
            if ($course->save()) {
                $data = ['success'=> __('Course has been deleted successfully.')];
            } else {
                $data = ['error' => __('Course can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Course can not be deleted. Please try again.'));
        }
    }

    /**
     * Remove the multiple course.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $company = Course::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($company) {
                    $data = ['success' => 'Course(s) has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Course(s) can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Course(s) can not be deleted. Please try again.'];
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
        $course = Course::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($course->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('Course status updated successfully.'));
        $flag = ($course->update($updateData)) ? 'true' : 'false';

        return redirect('/course');
    }

    /**
     * Check course is already exist or not
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkCourse(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkCourse = Course::notDeleted()->where('name', $request['name']);
        if (!empty($request['id'])) {
            $checkCourse->where('id', '<>', $request['id']);
        }
        $flag = $checkCourse->count() > 0 ? 'false' : 'true';

        return $flag;
    }
}
