@forelse($webinars as $webinar) 

      
    <tr id="filter_tr{{$webinar->id}}">
      <?php /*?><td><input type="checkbox" class="check-box" value="{{$webinar->id}}"></td><?php */?>
       <td>{{$webinar->id}}</td>
      <td>{{$webinar->title}}</td>
     
      <td>{{$webinar->recorded_date}}</td>
     <!--  <td>{{date("H:i:s A",strtotime($webinar->start_time)).' - '.date("H:i:s A",strtotime($webinar->end_time))}}</td> -->

      @if($webinar->webinar_type =='archived')
      <td>Active</td>
      @else
       <td>Inactive</td>
      @endif
      <td>
        <a href="{{route('archive-webinar.view',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn bg-transparent text-blue-400 border-blue-400 btn-sm btn-margin" title="View Webinar"><i class="icon-file-eye"></i></a>
        
        <a href="{{route('archive-webinar.delete',$webinar->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" onclick="return confirm('Are you sure you want to delete.?');" title="Delete" class="btn btn-group btn-default btn-sm"><i class="fa fa-trash-o"></i></a>
      </td>
    </tr>
@empty
    <tr>
      <td colspan="7"><center>No Records Available</center></td>
    </tr>
@endforelse 
