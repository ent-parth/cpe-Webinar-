<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\TeamRequest;
use App\Models\Team;

class TeamController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Team';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'team';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Team')]);

        return view('backEnd.team.index', compact('statusList'));
    }

    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'first_name',
            2 => 'email',
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
        $requestData = ['email'];

        foreach ($requestData as $field) {
            if (!empty($request->$field)) {
                $searchData[] = [$field, 'LIKE', '%' . trim($request->$field) . '%'];
            }
        }

        if (!empty($request->status)) {
            $searchData[] = ['status', $request->status];
        }
        $teamData = Team::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);
        if (!empty($request->name)) {
            $teamData->where(function ($query) use ($request) {
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$request->name%' ");
            });
        }
        try {
            $team = $teamData->paginate($limit);
            $paginationCount = $team->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.team.json.get_list', compact('team', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        return view('backEnd.team.add', compact('statusList'));
    }

    public function store(TeamRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $team = Team::create($requestData);
            if ($team) {
                $request->session()->flash('success', __('Team has been added successfully.'));
                return redirect()->route('team');
            }
            $request->session()->flash('error', __('Team could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Team could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $team = Team::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($team) {
                return view('backEnd.team.edit', compact('team', 'statusList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(TeamRequest $request)
    {
        try {
            $team = Team::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $team->modified_by = Auth::guard('administrator')->user()->id;
            $updateeTeam = $team->update($request->all());
            if ($updateeTeam) {
                $request->session()->flash('success', __('Team has been updated successfully.'));

                return redirect()->route('team');
            }
            $request->session()->flash('error', __('Team could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Team could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $team = Team::notDeleted()->findOrFail($request->id);
            $team->modified_by = Auth::guard('administrator')->user()->id;
            $team->status = config('constants.STATUS.STATUS_DELETE');
            if ($team->save()) {
                $data = ['success' => __('Team has been deleted successfully.')];
            } else {
                $data = ['error' => __('Team can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Team can not be deleted. Please try again.'));
        }
    }

    /**
     * Remove the multiple user.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $team = Team::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($team) {
                    $data = ['success' => 'Team has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Team can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Team can not be deleted. Please try again.'];
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
        $team = Team::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($team->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('Team status updated successfully.'));
        $flag = ($team->update($updateData)) ? 'true' : 'false';

        return redirect()->route('team');
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
        $checkEmail = Team::notDeleted()->where('email', $request['email']);
        if (!empty($request['id'])) {
            $checkEmail->where('id', '<>', $request['id']);
        }
        $flag = $checkEmail->count() > 0 ? 'true' : 'true';

        return $flag;
    }
}
