@forelse($webinars as $webinar)
<tr id="filter_tr{{$webinar->id}}">
  <td>{{$webinar->title}}</td>
  <td>@if($webinar->fee != '' && $webinar->fee != 0)$ {{ number_format($webinar->fee,2) }} @else FREE @endif</td>
  <td>{{ date("F j Y", strtotime($webinar->recorded_date)) }}<br /><small>{{ $webinar->time_zone }}</small></td>
  <td>{{$webinar->presentation_length}}</td>
  <td>{{$webinar->status}}</td>
  <td><a href="{{route('speaker.self_study_webinars.view',encrypt($webinar->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="View"><i class="icon-file-eye"></i></a> @if($webinar->status != 'active') <a a href="{{route('speaker.self_study_webinars.edit', encrypt($webinar->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a> <a href="{{route('speaker.self_study_webinars.delete',encrypt($webinar->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"  title="Delete" class="btn btn-group btn-default btn-sm delete-record-custom"><i class="fa fa-trash-o"></i></a> @endif
  <button class="btn btn-group btn-default btn-sm" id="btn_preview" name="btn_preview">Preview</button></td>
</tr>
@empty
<tr>
  <td colspan="7"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 