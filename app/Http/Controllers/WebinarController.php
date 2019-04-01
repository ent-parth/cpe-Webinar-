<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Helpers\StatusHelper;

class WebinarController extends Controller
{
    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Webinar';

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'webinars';

    /**
     * Active Sidebar sub-menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'webinars';

    public function index()
    {
        $statusList = StatusHelper::getStatusesList();
        $adminStatusList = StatusHelper::getAdminStatusList();
        config(['app.name' => __('Webinar')]);
        return view('backEnd.webinars.index', compact('statusList','adminStatusList'));
    }

    public function getList(Request $request)
    {
        if (!$request->ajax() && $request->isMethod('post')) {
            throw new NotFoundException();
        }
        $columnArr = [
            0 => null,
            1 => 'name',
            2 => 'webinar_type',
            3 => 'admin_status',
            4 => 'status',
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

        if (!empty($request->admin_status)) {
            $searchData[] = ['admin_status', $request->admin_status];
        }


        if (!empty($request->webinar_type)) {
            $searchData[] = ['webinar_type', $request->webinar_type];
        } 
        

        $webinarData = Webinar::notDeleted()->where($searchData)->orderBy($columnName, $columnOrderBy);
        if (!empty($request->name)) 
        {
            $webinarData->where(function ($query) use ($request) {
                $query->where("name", "like", "%$request->name%");
            });
        }

        try 
        {
            $webinars = $webinarData->paginate($limit);
            $paginationCount = $webinars->total();
        } 
        catch (NotFoundException $e) 
        {
            $paginationCount = 0;
        }
        $statusList = StatusHelper::getStatusesList();
        $adminStatusList = StatusHelper::getAdminStatusList();
            
        return response()->view('backEnd.webinars.json.get_list', compact('webinars', 'paginationCount', 'limit', 'page', 'statusList','adminStatusList'));
    }

    public function edit($id = null)
    {
        try 
        {
            $statusList = StatusHelper::getStatusesList();
            $webinar = Webinar::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($webinar)
            {
                return view('backEnd.webinars.edit', compact('webinar', 'statusList'));
            }
        } 
        catch (Exception $ex) 
        {
            abort(404);
        }
    }

    public function editStatus($id = null)
    {
        try 
        {
            $webinar = Webinar::notDeleted()->findOrFail($id); // active() is fetch the record which status <> 2.
            if ($webinar)
            {
                $statusList = StatusHelper::getStatusesList();
                if($webinar->webinar_type == 'live')
                {   
                    return view('backEnd.webinars.edit_live', compact('webinar','statusList'));
                }
                else
                {
                    return view('backEnd.webinars.edit_self_study', compact('webinar','statusList'));    
                }
            }
        } 
        catch (Exception $ex) 
        {
            abort(404);
        }
    }


    public function updateStatus(Request $request,$webinar_id,$status)
    {
        try {
            $webinar = Webinar::notDeleted()->findOrFail($webinar_id); // active() is fetch the record which status <> 2.
            $webinar->modified_by = Auth::guard('administrator')->user()->id;
            $webinar->admin_status = $status;
             
            if ($webinar->save()) 
            {
                $request->session()->flash('success', __('Webinar admin status has been updated successfully.'));
                return redirect()->route('webinar');
            }
            $request->session()->flash('error', __('Webinar admin status could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Webinar admin status could not be updated. Please, try again.'));
        }
    }
    /*public function update(WebinarRequest $request)
    {
        try {
            $requestData = $request->all();
            $webinar = Webinar::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $webinar->modified_by = Auth::guard('speaker')->user()->id;
            $requestData['time'] = date('H:i:s', strtotime($requestData['time']));
            
            $updateeWebinar = $webinar->update($requestData);
            if ($updateeWebinar) {
                $request->session()->flash('success', __('Webinar has been updated successfully.'));
                return redirect()->route('speaker.webinar');
            }
            $request->session()->flash('error', __('Webinar could not be updated. Please, try again.'));
        } catch (Exception $exc) {
            $request->session()->flash('error', __('Webinar could not be updated. Please, try again.'));
        }
    }*/

    public function update_status(WebinarRequest $request)
    {
        try 
        {
            $requestData = $request->all();
            $webinar = Webinar::notDeleted()->findOrFail($request->id); // active() is fetch the record which status <> 2.
            $webinar->modified_by = Auth::guard('administrator')->user()->id;
                     
            $updateeWebinar = $webinar->update($requestData);
            if ($updateeWebinar)
            {
                $request->session()->flash('success', __('Webinar status has been updated successfully.'));
                return redirect()->route('webinar');
            }
            $request->session()->flash('error', __('Webinar status could not be updated. Please, try again.'));
        }
        catch (Exception $exc) 
        {
            $request->session()->flash('error', __('Webinar status could not be updated. Please, try again.'));
        }
    }
}
