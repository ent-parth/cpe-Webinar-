<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class CityController extends Controller
{

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'City';

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
    public $activeSidebarSubMenu = 'city';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        config(['app.name' => __('Cities')]);

        return view('backEnd.cities.index', compact('statusList'));
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
            3 => 'cities.name',
            4 => 'cities.status',
        ];

        $start = !empty($request->input('start')) ? intval($request->input('start')) : 1;
        $limit = intval($request->input('length'));

        $page = intval(($start / $limit) + 1);
        $columnValue = !empty($request->input('order.0.column')) ? $request->input('order.0.column') : 0;
        $columnName = !empty($columnArr[$columnValue]) ? $columnArr[$columnValue] : 'cities.created_at';
        $columnOrderBy = !empty($request->input('order.0.dir')) ? $request->input('order.0.dir') : 'desc';

        $this->getCurrentPageNo($page);
        $searchData = $searchCountry = [];

        if (!empty($request->name)) {
            $searchData[] = ['cities.name', 'LIKE', '%' . trim($request->name) . '%'];
        }
        if (!empty($request->country_name)) {
            $searchData[] = ['countries.name', 'LIKE', '%' . $request->country_name . '%'];
        }
        if (!empty($request->state_name)) {
            $searchData[] = ['states.name', 'LIKE', '%' . $request->state_name . '%'];
        }
        if (!empty($request->status)) {
            $searchData[] = ['cities.status', $request->status];
        }

        $cityData = City::select('cities.id', 'cities.country_id', 'cities.state_id', 'cities.name', 'cities.status')
        ->join('countries', 'cities.country_id', "=", 'countries.id')
        ->join('states', 'cities.state_id', "=", 'states.id')
        ->notDeleted()
        ->where($searchData)->orderBy($columnName, $columnOrderBy);

        try {
            $cities = $cityData->paginate($limit);
            $paginationCount = $cities->total();
        } catch (NotFoundException $e) {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        return response()->view('backEnd.cities.json.get_list', compact('cities', 'paginationCount', 'limit', 'page', 'statusList'));
    }

    public function create()
    {
        $countries = Country::getCountry();
        $statusList = StatusHelper::getStatusesList();

        return view('backEnd.cities.add', compact('countries', 'statusList'));
    }

    public function store(CityRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['created_by'] = Auth::guard('administrator')->user()->id;
            $city = City::create($requestData);

            if ($city) {
                $request->session()->flash('success', __('City has been added successfully.'));

                return redirect()->route('cities');
            }
            $request->session()->flash('error', __('City could not be saved. Please, try again.'));

            return redirect()->route('cities');
        } catch (Exception $exc) {
            $request->session()->flash('error', __('City could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        try {
            $countries = Country::getCountry();
            $cities = City::notDeleted()->findOrFail($id);
            $statusList = StatusHelper::getStatusesList();

            if ($cities) {
                return view('backEnd.cities.edit', compact('cities', 'countries', 'statusList'));
            }
        } catch (Exception $ex) {
            abort(404);
        }
    }

    public function update(CityRequest $request)
    {
        try {
            $city = City::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> delete.
            $city->modified_by = Auth::guard('administrator')->user()->id;
            $updateCity = $city->update($request->all());
            if ($updateCity) {
                $request->session()->flash('success', __('City has been updated successfully.'));

                return redirect()->route('cities');
            }
            $request->session()->flash('error', __('City could not be updated. Please, try again.'));

            return redirect()->route('cities');
        } catch (Exception $exc) {
            $request->session()->flash('error', __('City could not be updated. Please, try again.'));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $city = City::notDeleted()->findOrFail($request->id);
            $city->modified_by = Auth::guard('administrator')->user()->id;
            $city->status = config('constants.STATUS.STATUS_DELETE');
            if ($city->save()) {
                $data = ['success' => __('City has been deleted successfully.')];
            } else {
                $data = ['error' => __('City can not be deleted. Please try again.')];
            }

            echo json_encode($data);
        } catch (Exception $ex) {
            $request->session()->flash('error', __('City can not be deleted. Please try again.'));
        }
    }

    /**
     * Remove the multiple city.
     *
     * @param  int $id Array
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $city = City::whereIn('id', $request->id)
                    ->update([
                        'status' => config('constants.STATUS.STATUS_DELETE'),
                        'modified_by' => Auth::guard('administrator')->user()->id
                ]);
                if ($city) {
                    $data = ['success' => 'City has been deleted successfully.'];
                } else {
                    $data = ['error' => 'City can not be deleted. Please try again.'];
                }
            } else {
                $data = ['error' => 'City can not be deleted. Please try again.'];
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
        $city = City::notDeleted()->findOrFail($request->id);
        $updateData = [];
        
        $updateData['status'] = ($city->status == config('constants.STATUS.STATUS_ACTIVE')) ? config('constants.STATUS.STATUS_INACTIVE') : config('constants.STATUS.STATUS_ACTIVE');
        $updateData['modified_by'] = Auth::guard('administrator')->user()->id;
        $request->session()->flash('success', __('City status updated successfully.'));
        $flag = ($city->update($updateData)) ? 'true' : 'false';

        return redirect()->route('cities');
    }

    public function getCity(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        try {
            $city = City::getCity($request->id);
            return $city;
        } catch (Exception $ex) {
            return [];
        }
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
                $cityList = City::select('id', DB::raw("lower(name) as name"))->notDeleted()->pluck('name', 'id')->toArray();
                foreach ($data->toArray() as $row)
                {
                    if(!empty($row))
                    {
                        $country_id = array_search(strtolower(trim($row['country'])), $countryList);
                        $state_id = array_search(strtolower(trim($row['state'])), $stateList);
                        $city_id = array_search(strtolower(trim($row['name'])), $cityList);
                        
                        if (empty($city_id)) {

                            if (empty($country_id)) {
                                $countryData['name'] = trim($row['country']);
                                $countryData['created_by'] = Auth::guard('administrator')->user()->id;
                                $country = Country::create($countryData);
                                $country_id = !empty($country->id) ? $country->id : '';
                                $countryList[$country_id] = !empty($country->name) ? $country->name : '';
                            }
                            if (empty($state_id)) {
                                $stateData['country_id'] = $country_id;
                                $stateData['name'] = trim($row['state']);
                                $stateData['created_by'] = Auth::guard('administrator')->user()->id;
                                $state = State::create($stateData);
                                $state_id = !empty($state->id) ? $state->id : '';
                                $stateList[$state_id] = !empty($state->name) ? $state->name : '';
                            }
                            $dataArray[] = [
                                'country_id' => $country_id,
                                'state_id' => $state_id,
                                'name' => $row['name'],
                                'created_by' => Auth::guard('administrator')->user()->id,
                            ];
                        }
                    }
                }
                if (!empty($dataArray)) {
                    City::insert($dataArray);
                }
                $request->session()->flash('success', __('City imported successfully.'));

                return redirect()->route('states');
            }
        }
        return view('backEnd.cities.import');
    }

    /**
     * Check City already exist or not
     * @param Request $request
     * @return bool
     * @throws NotFoundException
     */
    public function checkCity(Request $request)
    {
        if (!$request->ajax() || $request->isMethod('get')) {
            throw new NotFoundException();
        }
        $checkCity = City::notDeleted()->where('name', $request['name']);
        if (!empty($request['id'])) {
            $checkCity->where('id', '<>', $request['id']);
        }
        $flag = $checkCity->count() > 0 ? 'false' : 'true';

        return $flag;
    }
}
