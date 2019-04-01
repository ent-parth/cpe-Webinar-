 @forelse($Users as $us)
<tr id="filter_tr{{$us->id}}">
  <?php /*?><td><input type="checkbox" class="check-box" value="{{$webinar->id}}"></td><?php */?>
  <td>{{$us->first_name}} {{$us->last_name}}</td>
  <td>{{$us->email}}</td>
  <td>{{$us->firm_name}}</td>
  <td>{{date("F j Y",strtotime($us->created_at))}}</td>
  <td>{{$us->status}}</td>
  <td><a href="{{route('users.view',encrypt($us->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn bg-transparent text-blue-400 border-blue-400 btn-sm btn-margin" title="View Webinar"><i class="icon-file-eye"></i></a> <a href="{{route('users.updateStatus', [$us->id,$us->status])}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="">@if($us->status=='inactive')<i class="fa fa-fw fa-times-circle"></i>@else<i class="fa fa-fw fa-check-square-o"></i>@endif</a> <a href="{{route('users.delete',encrypt($us->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"  title="Delete" class="btn btn-group btn-default btn-sm delete-record-custom"><i class="fa fa-trash-o"></i></a></td>
</tr>
@empty
<tr>
  <td colspan="4"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 