@forelse($webinars as $webinar)
<tr id="filter_tr{{$webinar->id}}">
  <?php /*?><td><input type="checkbox" class="check-box" value="{{$webinar->id}}"></td><?php */?>
  <td>{{$webinar->title}}</td>
  <td>@if($webinar->fee != '' && $webinar->fee != 0)$ {{ number_format($webinar->fee,2)}} @else FREE @endif</td>
  <td>{{date("F j Y",strtotime($webinar->recorded_date))}}</td>
  <td>{{date("g:i A",strtotime($webinar->start_time)).' - '.date("g:i A",strtotime($webinar->end_time))}}</td>
  <td>{{$webinar->first_name}} {{$webinar->last_name}}</td>
  <td>{{$webinar->status}}</td>
  <td><select name="series" class="series" onchange = "updateSeries(this.value,'<?php echo $webinar->id?>')";>
      <option>Select series</option>
      
           @foreach($seriesList as $series)
      
      <option value="{{$series->id}}" @if($series->id == $webinar->series) selected="selected" @endif>{{$series->name}}</option>
      
            @endforeach
    
    </select>
    <a href="{{route('live-webinar.view',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Manage Webinar">Manage Webinar</a> 
    <!--<a href="https://api.getgo.com/oauth/v2/authorize?client_id={{env("GOTO_CONSUMER_KEY")}}&response_type=code&state=MyTest&redirect_uri={{env("HTTP_ADMIN_APP_URL")}}live-webinar/webinars/create/{{$webinar->id}}" class="btn bg-transparent text-blue-400 border-blue-400 btn-sm btn-margin" title="create webinar"><i class="icon-file-eye"></i></a>--> 
    <a href="{{route('live-webinar.edit', $webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a> 
    <!--<a href="{{route('live-webinar.delete',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" onclick="return confirm('Are you sure you want to delete.?');" title="Delete" class="btn btn-group btn-default btn-sm"><i class="fa fa-trash-o"></i></a>--></td>
</tr>
@empty
<tr>
  <td colspan="7"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 