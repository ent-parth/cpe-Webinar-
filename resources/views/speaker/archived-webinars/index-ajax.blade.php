@forelse($archived_webinars as $webinar)
<tr id="filter_tr{{$webinar->id}}">
  <td>{{$webinar->title}}</td>
  <td>{{ date("F j Y", strtotime($webinar->recorded_date)) }}<br />
    <small>{{ $webinar->time_zone }}</small></td>
  <td>@if($webinar->webinar_type == 'archived' AND $webinar->status == 'active') Active @elseif($webinar->webinar_type == 'live') draft @elseif($webinar->webinar_type == 'archived' AND $webinar->status == 'inactive') Inactive @endif</td>
  <td><a href="{{route('speaker.archived-webinar.view',encrypt($webinar->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="View"><i class="icon-file-eye"></i></a> </td/>
</tr>
@empty
<tr>
  <td colspan="5"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 