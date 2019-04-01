<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\StateRequest;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class StateController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'State';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'locations';

    /**
     * Active Sidebar sub-menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'state';

    public function index()
    {
        $countryList = Country::getCountry();
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('States')]);

        return view('backEnd.states.index', compact('statusList', 'countryList'));
    }

    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'countries.name',
            2 => 'states.name',
            3 => 'states.status',
        ];

        $start = !empty($request->input('start')) ? intval($request->input('start')) : 1;
        $limit = intval($request->input('length'));

        $page = intval(($start / $limit) + 1);
        $columnValue = !empty($request->input('order.0.column')) ? $request->input('order.0.column') : 0;
        $columnName = !empty($columnArr[$columnValue]) ? $columnArr[$columnValue] : 'states.created_at';
        $columnOrderBy = !empty($request->input('order.0.dir')) ? $request->input('order.0.dir') : 'desc';

        $this->getCurrentPageNo($page);
        $searchData = $searchCountry = [];

        if (!empty($request->name)) {
            $searchData[] = ['states.name', 'LIKE', '%' . trim($request->name) . '%'];
        }
        if (!empty($request->country_id)) {
            $searchData[] = ['country_id', $request->country_id];
        }
        if (!empty($request->status)) {
            $searchData[] = ['states.status', $request->status];
        }
        $stateData = State::select('states.id', 'states.country_id', 'states.name', 'states.status')
            ->join('countries', 'states.country_id', 'countries.id')
            ->notDeleted()
            ->where($searchData)->orderBy($columnName, $columnOrderBy);
        try {
            $states = $stateData->paginate($limit);
            $paginationCount = $states->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }

        return response()->view('backEnd.states.json.get_list', compact('states', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $countries = Country::getCountry();
        $statusList = StatusHelper::getStatusesList();

        return view('backEnd.states.add', compact('countries', 'statusList'));
    }

    public function store(StateRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $state = State::create($requestData);
            if ($state) {
                $request->session()->flash('success', __('State has been added successfully.'));

                return redirect()->route('states');
            }
            $request->session()->flash('error', __('State could not be saved. Please, try again.'));

            return redirect()->route('states');
        } catch (Exception $exc) {
            $request->session()->flash('error', __('State could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $countries = Country::getCountry();
            $state = State::notDeleted()->findOrFail($id);

            if ($state) {
                return view('backEnd.states.edit', compact('state', 'statusList', 'countries'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(StateRequest $request)
    {
        try {
            $state = State::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $state->modified_by = Auth::guard('administrator')->user()->id;
            $updateState = $state->update($request->all());

            if ($updateState) {
                $request->session()->flash('success', __('State has been updated successfully.'));

                return redirect()->route('states');
            }
            $request->session()->flash('error', __('State could not be updated. Please, try again.'));

            return redirect()->route('states');
        } catch (Exception $exc) {
            $request->session()->flash('error', __('State could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $state = State::notDeleted()->findOrFail($request->id);
            $state->modified_by = Auth::guard('administrator')->user()->id;
            $state->status = config('constants.STATUS.STATUS_DELETE');
            //$cities = City::notDeleted()->where('country_id', '=', $request->id)->count();
            /*if (!empty($cities)) {
                $data = ['error' => __('Please first delete all associated cities.')];
            } else */
            if ($state->save()) {
                \App\Models\City::where('state_id', $request->id)->update(['status' => config('constants.STATUS.STATUS_DELETE')]);
                $data = ['success' => __('State has been deleted successfully.')];
            } else {
                $data = ['error' => __('State can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('State can not be deleted. Please try again.'));
        }
    }

    /**
     * Remove the multiple state.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $state = State::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($state) {
                    \App\Models\City::whereIn('state_id', $request->id)->update(['status' => config('constants.STATUS.STATUS_DELETE')]);
                    $data = ['success' => 'State has been deleted successfully.'];
                } else {
                    $data = ['error' => 'State can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'State can not be deleted. Please try again.'];
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
        $state = State::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($state->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('State status updated successfully.'));
        $flag = ($state->update($updateData)) ? 'true' : 'false';

        return redirect()->route('states');
    }

    public function getState(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        try {
            $state = State::getState($request->id);
            return $state;
        } catch (Exception $ex) {
            return [];
        }
    }

    /**
     * Check State already exist or not
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkState(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkState = State::notDeleted()->where('name', $request['name']);
        if (!empty($request['id'])) {
            $checkState->where('id', '<>', $request['id']);
        }
        $flag = $checkState->count() > 0 ? 'false' : 'true';

        return $flag;
    }

    /**
     * import a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function import(Request $request)
    {
       if($request->file('imported-file'))
       {
            $path = $request->file('imported-file')->getRealPath();
            $data = Excel::load($path, function($reader)
            {
            })->get();

            if(!empty($data) && $data->count())
            {
                $countryList = Country::select('id', DB::raw("lower(name) as name"))->notDeleted()->pluck('name', 'id')->toArray();
                $stateList = State::select('id', DB::raw("lower(name) as name"))->notDeleted()->pluck('name', 'id')->toArray();
                foreach ($data->toArray() as $row)
                {
                    if(!empty($row))
                    {
                        $country_id = array_search(strtolower(trim($row['country'])), $countryList);
                        $state_id = array_search(strtolower(trim($row['name'])), $stateList);
                        
                        if (empty($state_id)) {
                            if (empty($country_id)) {
                                $countryData['name'] = trim($row['country']);
                                $countryData['created_by'] = Auth::guard('administrator')->user()->id;
                                $country = Country::create($countryData);
                                $country_id = !empty($country->id) ? $country->id : '';
                                $countryList[$country_id] = !empty($country->name) ? $country->name : '';
                            }
                            $dataArray[] = [
                                'country_id' => $country_id,
                                'name' => $row['name'],
                                'created_by' => Auth::guard('administrator')->user()->id,
                            ];
                        }
                    }
                }
                if (!empty($dataArray)) {
                    State::insert($dataArray);
                }
                $request->session()->flash('success', __('State(s) imported successfully.'));

                return redirect()->route('states');
            }
        }
        return view('backEnd.states.import');
    }
}
