<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Models\State;

class TagController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Tag';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'tags';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Countries')]);

        return view('backEnd.tags.index', compact('statusList'));
    }

    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'tag',
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
        $requestData = ['tag'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        if (!empty($request->status)) {
            $searchData[] = ['status', $request->status];
        }
        $tagData = Tag::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);

        if(Auth::guard('speaker')->check()) {
            $tagData->where(function($q) {
                $q->where('user_type', config('constants.TAGS.ADMIN'))
                ->orWhere([['user_type', config('constants.TAGS.SPEAKER')], ['created_by', Auth::guard('speaker')->user()->id]]);
            });
        }

        try {
            $tags = $tagData->paginate($limit);
            $paginationCount = $tags->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        return response()->view('backEnd.tags.json.get_list', compact('tags', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        return view('backEnd.tags.add', compact('statusList'));
    }

    public function store(TagRequest $request)
    {
        try {
            $requestData = $request->all();
            if (Auth::guard('administrator')->check()) {
                $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            } else if (Auth::guard('speaker')->check()) {
                $requestData['created_by'] = Auth::guard('speaker')->user()->id;
                $requestData['user_type'] = config('constants.TAGS.SPEAKER');
            }
            $tag = Tag::create($requestData);
            
            if ($tag) {
                $request->session()->flash('success', __('Tag has been added successfully.'));

                return redirect()->route('tags');
            }
            $request->session()->flash('error', __('Tag could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Tag could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $tag = Tag::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($tag) {
                return view('backEnd.tags.edit', compact('tag', 'statusList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(TagRequest $request)
    {
        try {
            $tag = Tag::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            if (Auth::guard('administrator')->check()) {
                $tag->modified_by = Auth::guard('administrator')->user()->id;
            } else if (Auth::guard('speaker')->check()) {
                $tag->modified_by = Auth::guard('speaker')->user()->id;
            }
            $updateeTag = $tag->update($request->all());
            if ($updateeTag) {
                $request->session()->flash('success', __('Tag has been updated successfully.'));

                return redirect()->route('tags');
            }
            $request->session()->flash('error', __('Tag could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Tag could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $tag = Tag::notDeleted()->findOrFail($request->id);
            if (Auth::guard('administrator')->check()) {
                $tag->modified_by = Auth::guard('administrator')->user()->id;
            } else if (Auth::guard('speaker')->check()) {
                $tag->modified_by = Auth::guard('speaker')->user()->id;
            }
            $tag->status = config('constants.STATUS.STATUS_DELETE');
            if ($tag->save()) {
                $data = ['success' => __('Tag has been deleted successfully.')];
            } else {
                $data = ['error' => __('Tag can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Tag can not be deleted. Please try again.'));
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
                if (Auth::guard('administrator')->check()) {
                    $modifiedBy = Auth::guard('administrator')->user()->id;
                } else if (Auth::guard('speaker')->check()) {
                    $modifiedBy = Auth::guard('speaker')->user()->id;
                }
                $company = Tag::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => $modifiedBy
                ]);
                if ($company) {
                    $data = ['success' => 'Tag(s) has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Tag(s) can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Tag(s) can not be deleted. Please try again.'];
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
        $tag = Tag::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($tag->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('Tag status updated successfully.'));
        $flag = ($tag->update($updateData)) ? 'true' : 'false';

        return redirect()->route('tags');
    }

    /**
     * Check tag is already exist or not
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkTag(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkTag = Tag::notDeleted()->where('tag', $request['tag']);

        if (Auth::guard('administrator')->check()) {
            $checkTag->where('user_type', config('constants.TAGS.ADMIN'));
        } else if(Auth::guard('speaker')->check()) {
            $checkTag->where(function($q) {
                $q->where('user_type', config('constants.TAGS.ADMIN'))
                ->orWhere([['user_type', config('constants.TAGS.SPEAKER')], ['created_by', Auth::guard('speaker')->user()->id]]);
            });
        }
        if (!empty($request['id'])) {
            $checkTag->where('id', '<>', $request['id']);
        }
        $flag = $checkTag->count() > 0 ? 'false' : 'true';

        return $flag;
    }
}
