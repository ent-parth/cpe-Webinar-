
@forelse($Self_Study_Webinars as $webinar)       


    <tr id="filter_tr{{$webinar->id}}">
      <?php /*?><td><input type="checkbox" class="check-box" value="{{$webinar->id}}"></td><?php */?>
      <td>{{$webinar->id}}</td>
      <td>{{$webinar->title}}</td>
      <td>@if($webinar->fee != '' && $webinar->fee != 0)$ {{$webinar->fee}} @else FREE @endif</td>
      <td>{{$webinar->recorded_date}}</td>
      <td>{{$webinar->presentation_length}}</td>
      <td>{{$webinar->status}}</td>


      <td>
        <select name="series" class="series" onchange = "updateSeries(this.value,'<?php echo $webinar->id?>')";>
          <option>Select series</option>
           @foreach($seriesList as $series)
                          <option value="{{$series->id}}" @if($series->id == $webinar->series) selected="selected" @endif>{{$series->name}}</option>
            @endforeach
           
        </select>
      	<a href="{{route('selfstudy-webinar.view',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Manage Webinar">Manage Webinar</a>
      	<a href="{{route('selfstudy-webinar.edit', $webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
        <!--<a href="{{route('selfstudy-webinar.delete',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" onclick="return confirm('Are you sure you want to delete.?');" title="Delete" class="btn btn-group btn-default btn-sm"><i class="fa fa-trash-o"></i></a>-->
      </td>
    </tr>
@empty
    <tr>
      <td colspan="7"><center>No Records Available</center></td>
    </tr>
@endforelse 




