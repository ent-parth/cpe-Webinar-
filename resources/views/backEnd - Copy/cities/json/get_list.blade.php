@if ($cities->count() > 0)
    @foreach($cities as $city)
        @php
            if ($city->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $statusIcon = 'fa fa-fw fa-check-square-o';
            } else {
                $statusIcon = 'fa fa-fw fa-times-circle';
            }
            $records[] = [
                '<input type="checkbox" class="check-box" value="' . $city->id . '">',
                $city->country->name ?? '',
                $city->state->name ?? '',
                $city->name,
                \App\Helpers\StatusHelper::getStatus($city->status),
                ('<a href="' . route('status-update.city',
                    $city->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>') .
                '<a href="javascript:void(0)" data-toggle="modal" data-url="' . route('edit.city', [ $city->id]). '" class="btn btn-group btn-default btn-sm edit-city" title="Edit City"><i class="fa fa-edit"></i></a>'.
                '<a href="' . route('delete.cities', [$city->id]) . '" class="btn btn-group btn-default btn-sm delete-record" title="Delete City"><i class="fa fa-trash-o"></i></a>'
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

