@if ($categories->count() > 0)
    @foreach($categories as $category)
        @php
            if ($category->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $statusIcon = 'fa fa-fw fa-check-square-o';
            } else {
                $statusIcon = 'fa fa-fw fa-times-circle';
            }
            $records[] = [   
                '<input type="checkbox" class="check-box" value="' . $category->id . '">',
                $category->name ?? '',
                \App\Helpers\StatusHelper::getStatus($category->status),
                ('<a href="' . route('status-update.category',
                    $category->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-categories')) ? '<a href="javascript:void(0)" data-toggle="modal" data-url="' . route('edit.category', [ $category->id]). '" class="btn btn-group btn-default btn-sm edit-category" title="Edit Category"><i class="fa fa-edit"></i></a>' : '') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-categories')) ? '<a href="' . route('delete.category', [ $category->id]) . '" title="Delete Category" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>' : '')
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