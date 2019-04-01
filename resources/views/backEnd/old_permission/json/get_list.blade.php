<?php

if ($permissions->count() > 0) {

    $incNumber = (($page - 1)) * $limit;
    foreach ($permissions as $permission) {
        $incNumber++;
        $records[] = [
            $incNumber,
            $permission->parent_id,
            $permission->title,
            $permission->permission_key,
            ($permission->status) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>',
            ('<a href="' . route('permissions.view',
                    $permission->id) . '" class="btn bg-transparent text-blue-400 border-blue-400 btn-sm btn-margin" title="View Permission"><i class="icon-file-eye"></i></a>') .
            ('<a href="' . route('edit.permission',
                    $permission->id) . '" class="btn bg-transparent text-indigo-400 border-indigo-400 btn-sm btn-margin" title="Edit admin"><i class="icon-pencil7"></i></a>') .
            ('<a href="' . route('delete.permission',
                    $permission->id) . '" onclick="return confirm(`Are you sure you want to delete ' . $permission->title . '?`)" class="btn bg-transparent text-danger border-danger btn-sm btn-margin" title="Delete admin"><i class="icon-trash"></i></a>')
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


