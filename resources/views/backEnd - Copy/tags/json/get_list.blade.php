@if ($tags->count() > 0)
    @foreach($tags as $tag)
        @php
            if ($tag->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $statusIcon = 'fa fa-fw fa-check-square-o';
            } else {
                $statusIcon = 'fa fa-fw fa-times-circle';
            }
            $records[] = [   
                '<input type="checkbox" class="check-box" value="' . $tag->id . '">',
                $tag->tag ?? '',
                \App\Helpers\StatusHelper::getStatus($tag->status),
                (('<a href="' . route('status-update.tags',
                    $tag->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>') .
                ((Auth::guard('administrator')->check() || (Auth::guard('speaker')->check() && $tag->user_type == config('constants.TAGS.SPEAKER'))) ?
                (\App\Helpers\PermissionHelper::hasAccess('manage-tags') ? '<a href="javascript:void(0)" data-toggle="modal" data-url="' . route('edit.tag', [ $tag->id]). '" class="btn btn-group btn-default btn-sm edit-tag" title="Edit Tag"><i class="fa fa-edit"></i></a>' : '') : '') .
                ((\App\Helpers\PermissionHelper::hasAccess('manage-tags')) ? '<a href="' . route('delete.tag', [ $tag->id]) . '" title="Delete Tag" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>' : ''))
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