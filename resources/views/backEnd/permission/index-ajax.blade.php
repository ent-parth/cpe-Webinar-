@forelse($permission as $pr)       


    <tr id="filter_tr{{$pr->id}}">
      <?php /*?><td><input type="checkbox" class="check-box" value="{{$webinar->id}}"></td><?php */?>
      <td>{{$pr->id}}</td>
       <td>{{$pr->name}}</td>
      <td>{{$pr->display_name}}</td>
      <td>{{$pr->description }}</td>
      <td>{{$pr->status}}</td>
      


      <td>
      	
        <a href="{{route('permission.updateStatus', [$pr->id,$pr->status])}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="">@if($pr->status=='inactive')<i class="fa fa-fw fa-times-circle"></i>@else<i class="fa fa-fw fa-check-square-o"></i>@endif</a>
    
        
      	<a href="{{route('permission.edit', $pr->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
        <a href="{{route('permission.delete',$pr->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"  title="Delete" class="btn btn-group btn-default btn-sm delete-record-custom"><i class="fa fa-trash-o"></i></a>
      </td>
    </tr>
@empty
<tr>
  <td colspan="4"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 