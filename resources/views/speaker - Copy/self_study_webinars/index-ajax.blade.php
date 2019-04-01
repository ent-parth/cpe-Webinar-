@forelse($webinars as $webinar)       


    <tr id="filter_tr{{$webinar->id}}">
      <td>{{$webinar->id}}</td>
      <td>{{$webinar->title}}</td>
      <td>@if($webinar->fee != '' && $webinar->fee != 0)$ {{$webinar->fee}} @else FREE @endif</td>
      <td>{{$webinar->recorded_date}}</td>
      <td>{{$webinar->presentation_length}}</td>
      <td>{{$webinar->status}}</td>


      <td>
      @if($webinar->status != 'active')
      	<!--<a href="{{route('speaker.webinar.view',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn bg-transparent text-blue-400 border-blue-400 btn-sm btn-margin" title="View Webinar"><i class="icon-file-eye"></i></a>-->
      	<a a href="{{route('speaker.self_study_webinars.edit', $webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
        <a href="{{route('speaker.self_study_webinars.delete',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" onclick="return confirm('Are you sure you want to delete.?');" title="Delete" class="btn btn-group btn-default btn-sm"><i class="fa fa-trash-o"></i></a>
      @endif  
      </td>
    </tr>
@empty
    <tr>
      <td colspan="7"><center>No Records Available</center></td>
    </tr>
@endforelse 
