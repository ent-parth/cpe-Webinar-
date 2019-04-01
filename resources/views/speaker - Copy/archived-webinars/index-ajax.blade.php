@forelse($archived_webinars as $webinar)       
    <tr id="filter_tr{{$webinar->id}}">
      <td>{{$webinar->id}}</td>
      <td>{{$webinar->title}}</td>
      <td>{{$webinar->recorded_date}}</td>
      <td>@if($webinar->webinar_type == 'archived' AND $webinar->status == 'active') Active @else Inactive @endif</td>
      
    </tr>
@empty
    <tr>
      <td colspan="5"><center>No Records Available</center></td>
    </tr>
@endforelse 
