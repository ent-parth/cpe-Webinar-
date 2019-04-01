<?php
if ($administrators->count() > 0) {
    foreach ($administrators as $administrator) {
        if ($administrator->status == config('constants.STATUS.STATUS_ACTIVE')) {
            $statusIcon = 'fa fa-fw fa-check-square-o';
        } else {
            $statusIcon = 'fa fa-fw fa-times-circle';
        }
//        $name = !empty($administrator->full_name) ? '<a href="#">' . $administrator->full_name . '</a>' : '-';
        $name = $administrator->full_name;
        $records[] = [
           '<input type="checkbox" class="check-box" value="' . $administrator->id . '">',
            $name,
            $administrator->email,
//            $administrator->role->name,
            !empty($statusList[$administrator->status]) ? $statusList[$administrator->status] : '',
            /*(('<a href="' . route('administrators-view',
                    $administrator->id) . '" class="btn bg-transparent text-blue-400 border-blue-400 btn-sm btn-margin" title="' . __('messages.view_administrator') . '"><i class="icon-file-eye"></i></a>')) .*/
            (('<a href="' . route('status-update.administrators',$administrator->id) . '" class="btn btn-group btn-default btn-sm" title=""><i class="' . $statusIcon . '"></i></a>')) .
            (('<a a href="' . route('administrators-edit', $administrator->id) . '" class="btn btn-group btn-default btn-sm edit-role" title="Edit Administrator"><i class="fa fa-edit"></i></a>')).
            ((($administrator->id) == 1 ? '' : '<a href="' . route('administrators-delete',
                    $administrator->id) . '" title="Delete Administrator" class="btn btn-group btn-default btn-sm delete-record"><i class="fa fa-trash-o"></i></a>'))
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


