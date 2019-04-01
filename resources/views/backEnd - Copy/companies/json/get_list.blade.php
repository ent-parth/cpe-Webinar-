@if ($companies->count() > 0)
    @foreach($companies as $company)
        @php
            if ($company->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $statusIcon = 'fa fa-fw fa-check-square-o';
            } else {
                $statusIcon = 'fa fa-fw fa-times-circle';
            }
            $records[] = [
                '<input type="checkbox" class="check-box" value="' . $company->id . '">',
                $company->name,
                !empty($company->contact_number) ? $company->contact_number : '',
                ('<a href="' . route('status-update.companies',
                    $company->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-companies')) ? '<a href="' . route('edit.company', [$company->id]). '" class="btn btn-group btn-default btn-sm" title="Edit Company"><i class="fa fa-edit"></i></a>' : '') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-companies')) ? '<a href="' . route('delete.company', [$company->id]) . '" title="Delete Company" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>' : '')
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