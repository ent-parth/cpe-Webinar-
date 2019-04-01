@forelse($webinars as $webinar)
<tr id="filter_tr{{$webinar->id}}">
  <?php /*?><td><input type="checkbox" class="check-box" value="{{$webinar->id}}"></td><?php */?>
  <td>{{$webinar->title}}</td>
  <td>{{date("F j Y",strtotime($webinar->recorded_date))}}</td>
  <!--  <td>{{date("H:i:s A",strtotime($webinar->start_time)).' - '.date("H:i:s A",strtotime($webinar->end_time))}}</td> -->
  <td>{{$webinar->first_name}} {{$webinar->last_name}}</td>
  <td>@if($webinar->webinar_type == 'archived' AND $webinar->status == 'active') Active @elseif($webinar->webinar_type == 'live') draft @elseif($webinar->webinar_type == 'archived' AND $webinar->status == 'inactive') Inactive @endif</td>
  <td> 
  	@if($webinar->webinar_type == 'archived') 
    	<!--<a href="{{route('archive-webinar.updateStatus', [$webinar->id,$webinar->status])}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="">
            @if($webinar->status=='inactive')
                <i class="fa fa-fw fa-times-circle"></i>
            @else
                <i class="fa fa-fw fa-check-square-o"></i>
            @endif
        </a>--> 
    @endif 
    	<a href="{{route('archive-webinar.edit', $webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a> 
        <a href="{{route('archive-webinar.view',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Manage Webinar">Manage Webinar</a> 
    	<!--<a href="{{route('archive-webinar.delete',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" onclick="return confirm('Are you sure you want to delete.?');" title="Delete" class="btn btn-group btn-default btn-sm"><i class="fa fa-trash-o"></i></a> -->
 </td>
</tr>
@empty
<tr>
  <td colspan="7"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 