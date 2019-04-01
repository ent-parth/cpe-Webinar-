<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Category';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'categories';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Categories')]);

        return view('backEnd.categories.index', compact('statusList'));
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
        $categoryData = Category::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);

        try {
            $categories = $categoryData->paginate($limit);
            $paginationCount = $categories->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.categories.json.get_list', compact('categories', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        return view('backEnd.categories.add', compact('statusList'));
    }

    public function store(CategoryRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $category = Category::create($requestData);
            if ($category) {
                $request->session()->flash('success', __('Category has been added successfully.'));

                return redirect()->route('categories');
            }
            $request->session()->flash('error', __('Category could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Category could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $category = Category::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($category) {
                return view('backEnd.categories.edit', compact('category', 'statusList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(CategoryRequest $request)
    {
        try {
            $category = Category::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $category->modified_by = Auth::guard('administrator')->user()->id;
            $updateCategory = $category->update($request->all());
            if ($updateCategory) {
                $request->session()->flash('success', __('Category has been updated successfully.'));

                return redirect()->route('categories');
            }
            $request->session()->flash('error', __('Category could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Category could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $category = Category::notDeleted()->findOrFail($request->id);
            $category->modified_by = Auth::guard('administrator')->user()->id;
            $category->status = config('constants.STATUS.STATUS_DELETE');
           if ($category->save()) {
                $data = ['success' => __('Category has been deleted successfully.')];
            } else {
                $data = ['error' => __('Category can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Category can not be deleted. Please try again.'));
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
                $category = Category::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($category) {
                    $data = ['success' => 'Categories has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Categories can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Categories can not be deleted. Please try again.'];
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
        $category = Category::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($category->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('Category status updated successfully.'));
        $flag = ($category->update($updateData)) ? 'true' : 'false';

        return redirect()->route('categories');
    }

    /**
     * Check Category for category
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkCategory(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkCategory = Category::notDeleted()->where('name', $request['name']);
        if (!empty($request['id'])) {
            $checkCategory->where('id', '<>', $request['id']);
        }
        $flag = $checkCategory->count() > 0 ? 'false' : 'true';

        return $flag;
    }
}
