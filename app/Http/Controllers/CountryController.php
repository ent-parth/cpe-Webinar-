<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use App\Models\State;

class CountryController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Country';

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
    public $activeSidebarSubMenu = 'country';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Countries')]);

        return view('backEnd.countries.index', compact('statusList'));
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
        $countryData = Country::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);

        try {
            $countries = $countryData->paginate($limit);
            $paginationCount = $countries->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.countries.json.get_list', compact('countries', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $statusList = StatusHelper::getStatusesList();
        return view('backEnd.countries.add', compact('statusList'));
    }

    public function store(CountryRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $country = Country::create($requestData);
            if ($country) {
                $request->session()->flash('success', __('Country has been added successfully.'));

                return redirect()->route('countries');
            }
            $request->session()->flash('error', __('Country could not be saved. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Country could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $statusList = StatusHelper::getStatusesList();
            $country = Country::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($country) {
                return view('backEnd.countries.edit', compact('country', 'statusList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(CountryRequest $request)
    {
        try {
            $country = Country::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $country->modified_by = Auth::guard('administrator')->user()->id;
            $updateeCountry = $country->update($request->all());
            if ($updateeCountry) {
                $request->session()->flash('success', __('Country has been updated successfully.'));

                return redirect()->route('countries');
            }
            $request->session()->flash('error', __('Country could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Country could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $country = Country::notDeleted()->findOrFail($request->id);
            $country->modified_by = Auth::guard('administrator')->user()->id;
            //$states = State::notDeleted()->where('country_id', '=', $request->id)->count();
            $country->status = config('constants.STATUS.STATUS_DELETE');
            /*if (!empty($states)) {
                $data = ['error' => __('Please first delete all associated states.')];
            } else */
            if ($country->save()) {
                State::where('country_id', $request->id)->update(['status' => config('constants.STATUS.STATUS_DELETE')]);
                \App\Models\City::where('country_id', $request->id)->update(['status' => config('constants.STATUS.STATUS_DELETE')]);
                $data = ['success' => __('Country has been deleted successfully.')];
            } else {
                $data = ['error' => __('Country can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('Country can not be deleted. Please try again.'));
        }
    }

    /**
     * Remove the multiple country.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $country = Country::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($country) {
                    State::whereIn('country_id', $request->id)->update(['status' => config('constants.STATUS.STATUS_DELETE')]);
                    \App\Models\City::whereIn('country_id', $request->id)->update(['status' => config('constants.STATUS.STATUS_DELETE')]);
                    $data = ['success' => 'Country has been deleted successfully.'];
                } else {
                    $data = ['error' => 'Country can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'Country can not be deleted. Please try again.'];
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
        $country = Country::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($country->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('Country status updated successfully.'));
        $flag = ($country->update($updateData)) ? 'true' : 'false';

        return redirect()->route('countries');
    }

    /**
     * Check Country already exist or not
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkCountry(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkCountry = Country::notDeleted()->where('name', $request['name']);
        if (!empty($request['id'])) {
            $checkCountry->where('id', '<>', $request['id']);
        }
        $flag = $checkCountry->count() > 0 ? 'false' : 'true';

        return $flag;
    }
}
