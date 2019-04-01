@if ($courses->count() > 0)
    @foreach($courses as $course)
        @php
            if ($course->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $statusIcon = 'fa fa-fw fa-check-square-o';
            } else {
                $statusIcon = 'fa fa-fw fa-times-circle';
            }
            $records[] = [
                '<input type="checkbox" class="check-box" value="' . $course->id . '">',
                !empty($course->courseLevel->name) ? $course->courseLevel->name : '',
                $course->name ?? '',
                \App\Helpers\StatusHelper::getStatus($course->status),
                ('<a href="' . route('status-update.course',$course->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-course')) ? '<a href="javascript:void(0)" data-toggle="modal" data-url="' . route('edit.course', [ $course->id]). '" class="btn btn-group btn-default btn-sm edit-course" title="Edit Course"><i class="fa fa-edit"></i></a>' : '') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-course')) ? '<a href="' . route('delete.course', [ $course->id]) . '" title="Delete Course" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>' : '')
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