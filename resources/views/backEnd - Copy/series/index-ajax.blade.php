
@forelse($Series as $sr)       


    <tr id="filter_tr{{$sr->id}}">
      <?php /*?><td><input type="checkbox" class="check-box" value="{{$webinar->id}}"></td><?php */?>
      <td>{{$sr->id}}</td>
      <td>{{$sr->name}}</td>
      <td>{{$sr->status}}</td>


      <td>
      	
        <a href="{{route('series.updateStatus', [$sr->id,$sr->status])}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="">@if($sr->status=='inactive')<i class="fa fa-fw fa-times-circle"></i>@else<i class="fa fa-fw fa-check-square-o"></i>@endif</a>
    
        
      	<a href="{{route('series.edit', $sr->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
        <a href="{{route('series.delete',$sr->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"  title="Delete" class="btn btn-group btn-default btn-sm delete-record-custom"><i class="fa fa-trash-o"></i></a>
      </td>
    </tr>
@empty
    <tr>
      <td colspan="4"><center>No Records Available</center></td>
    </tr>
@endforelse 



