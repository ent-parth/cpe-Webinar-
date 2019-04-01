@if ($states->count() > 0)
    @foreach($states as $states)
        @php
            if ($states->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $statusIcon = 'fa fa-fw fa-check-square-o';
            } else {
                $statusIcon = 'fa fa-fw fa-times-circle';
            }
            $records[] = [   
                '<input type="checkbox" class="check-box" value="' . $states->id . '">',
                $states->country->name ?? '',
                $states->name ?? '',
                \App\Helpers\StatusHelper::getStatus($states->status),
                ('<a href="' . route('status-update.state',
                    $states->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-states')) ? '<a href="javascript:void(0)" data-toggle="modal" data-url="' . route('edit.state', [ $states->id]). '" class="btn btn-group btn-default btn-sm edit-state" title="Edit State"><i class="fa fa-edit"></i></a>' : '') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-states')) ? '<a href="' . route('delete.state', [ $states->id]) . '" title="Delete State" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>' : '')
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
@php
function readMoreHelper($story_desc, $chars = 200) {
        if(strlen($story_desc) >= 200){
            $story_description = substr($story_desc, 0,$chars);
            $story_desc = $story_description." <a href='javascript:void(0);' data-toggle='modal' id='description-model' data-target='#modal_default' data-id='$story_desc'>Read More</a>";
	}
        
        return $story_desc;
} 
@endphp