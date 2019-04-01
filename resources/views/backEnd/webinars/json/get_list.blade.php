<?php
if($webinars->count() > 0) 
{
    $incNumber = (($page - 1)) * $limit;
    foreach ($webinars as $webinar) 
    {
        
        $incNumber++;
        $records[] = 
        [
            $incNumber,
            $webinar->name,
            $webinar->webinar_type,
            \App\Helpers\StatusHelper::getAdminStatus($webinar->admin_status),
            \App\Helpers\StatusHelper::getStatus($webinar->status),
            (('<a a href="' . route('edit.webinar_status', $webinar->id) . '" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>'))
        ];
    }
} 
else 
{
    $records = [];
}

$response = [
    'data' => $records,
    'recordsTotal' => $paginationCount,
    'recordsFiltered' => $paginationCount,
];
echo json_encode($response);
?>


