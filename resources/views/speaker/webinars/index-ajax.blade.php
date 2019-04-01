@forelse($webinars as $webinar)       
    <tr id="filter_tr{{$webinar->id}}">
      <td>{{$webinar->title}}</td>
      <td>@if($webinar->fee != '' && $webinar->fee != 0)$ {{ number_format($webinar->fee,2) }} @else FREE @endif</td>
      <td>{{ CommonHelper::convertTime($webinar->start_time,$webinar->time_zone,'F j Y') }}<br /><small>{{ $webinar->time_zone }}</small></td>
      <td>{{ CommonHelper::convertTime($webinar->start_time,$webinar->time_zone,'g:i A').' - '.CommonHelper::convertTime($webinar->end_time,$webinar->time_zone,'g:i A')}}</td>
      <!--<td></td>-->
      <td>{{$webinar->status}}</td>
      
      <td>
        <a href="{{route('speaker.webinar.view',encrypt($webinar->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="View"><i class="icon-file-eye"></i></a>
       @if($webinar->status != 'active')
      	<!--<a href="{{route('speaker.webinar.view',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn bg-transparent text-blue-400 border-blue-400 btn-sm btn-margin" title="View Webinar"><i class="icon-file-eye"></i></a>-->
      	<a a href="{{route('speaker.webinar.edit', encrypt($webinar->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
        @endif
       @if($webinar->status == 'active')
        <a href="{{route('speaker.webinar.speaker_invitation',encrypt($webinar->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"  title="Speaker Invitation" class="btn btn-group btn-default btn-sm"><i class="fa fa-send"></i></a> 
        @endif
      </td>
    </tr>
@empty
    <tr>
      <td colspan="7"><center>No Records Available</center></td>
    </tr>
@endforelse 
