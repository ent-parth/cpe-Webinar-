<?php
if ($webinars->count() > 0) {
    $incNumber = (($page - 1)) * $limit;
    foreach ($webinars as $webinar) {
        
        $incNumber++;
        $records[] = [
            $incNumber,
            $webinar->name,
            $webinar->webinar_type,
            $webinar->date,
            $webinar->goto_meeting_code,
            \App\Helpers\StatusHelper::getStatus($webinar->status),
            (('<a href="' . route('speaker.view.webinar',
                    $webinar->id) . '" class="btn bg-transparent text-blue-400 border-blue-400 btn-sm btn-margin" title="' . __('messages.view_administrator') . '"><i class="icon-file-eye"></i></a>')) .
            (('<a a href="' . route('speaker.edit.webinar', $webinar->id) . '" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>')).
            ('<a href="' . route('speaker.delete.webinar',
                    $webinar->id) . '" onclick="return confirm(`Are you sure you want to delete ' . $webinar->full_name . ' webinar ?`)" title="Delete" class="btn btn-group btn-default btn-sm"><i class="fa fa-trash-o"></i></a>')
        ];
    }
} else {
    $records = [];
}

$response = [
    'data' => $records,
    'recordsTotal' => $paginationCount,
    'recordsFiltered' => $paginationCount,
];
echo json_encode($response);
?>


