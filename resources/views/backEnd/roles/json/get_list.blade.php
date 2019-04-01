@if ($roles->count() > 0)
    @php $incNumber = (($page - 1)) * $limit; @endphp
    @foreach($roles as $role)
        @php
            $incNumber++;
            $records[] = [   
                $incNumber,
                $role->name,
                !empty($statusList[$role->status])  ? $statusList[$role->status] : '',
                (\App\Helpers\PermissionHelper::hasAccess('manage-role-permission')) ? '<a href="' . route('create.role.permission', [$role->id]) . '" class="btn btn-group btn-default btn-sm" title="Manage permissions"><i class="fa fa-gears"></i></a>' .
                ((\App\Helpers\PermissionHelper::hasAccess('edit-role')) ? '<a href="javascript:void(0)" data-toggle="modal" data-url="' . route('edit-role', [ $role->id]). '" class="btn btn-group btn-default btn-sm edit-role" title="Edit Role"><i class="fa fa-edit"></i></a>' : '') .
                ((\App\Helpers\PermissionHelper::hasAccess('delete-role')) ? '<a href="' . route('roles-delete', [ $role->id]) . '" title="Delete Role" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>' : '') : ''
               ] 
        @endphp
    @endforeach
@else
    @php
        $records = []; 
    @endphp
@endif   

@php
    $response = [
        'data' => $records,
        'recordsTotal' => $paginationCount,
        'recordsFiltered' => $paginationCount,
    ];

echo json_encode($response) ;
@endphp

