<?php
if ($team->count() > 0) {
    foreach ($team as $team) {
        if ($team->status == config('constants.STATUS.STATUS_ACTIVE')) {
            $statusIcon = 'fa fa-fw fa-check-square-o';
        } else {
            $statusIcon = 'fa fa-fw fa-times-circle';
        }
        $records[] = [
            '<input type="checkbox" class="check-box" value="' . $team->id . '">',
            $team->full_name,
            $team->email,
            \App\Helpers\StatusHelper::getStatus($team->status),
            ('<a href="' . route('status-update.team',
                    $team->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>') .
            (('<a a href="' . route('edit.team', $team->id) . '" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>')).
            ('<a href="' . route('delete.team',
                    $team->id) . '" title="Delete" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>')
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


