<?php
if ($speakers->count() > 0) {

    $incNumber = (($page - 1)) * $limit;
    foreach ($speakers as $speaker) {
        $incNumber++;
        if ($speaker->status == config('constants.STATUS.STATUS_ACTIVE')) {
            $statusIcon = 'fa fa-fw fa-check-square-o';
        } else {
            $statusIcon = 'fa fa-fw fa-times-circle';
        }
        $records[] = [
            '<input type="checkbox" class="check-box" value="' . $speaker->id . '">',
            $speaker->full_name,
            $speaker->email,
            $speaker->contact_no,
            \App\Helpers\StatusHelper::getStatus($speaker->status),
            ('<a href="' . route('status-update.speaker',
                    $speaker->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>') .
            ('<a href="' . route('edit.speaker', $speaker->id) . '" class="btn btn-group btn-default btn-sm" title="Edit Speaker"><i class="fa fa-edit"></i></a>').
            ('<a href="' . route('delete.speaker',
                    $speaker->id) . '" title="Delete Speaker" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>')
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


