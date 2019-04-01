 @forelse($webinar_user_register as $data)
<tr id="filter_tr{{$data->id}}">
  <?php /*?><td><input type="checkbox" class="check-box" value="{{$webinar->id}}"></td><?php */?>
  <td>{{$data->first_name}} {{$data->last_name}}</td>
  <td>{{$data->email}}</td>
  <td>{{$data->title}} ({{$data->webinar_id}})</td>
  <td>@if($data->webinar_type == 'self_study') self study @else {{$data->webinar_type}} @endif</td>
  <td>@if($data->fee != '' && $data->fee != 0)$ {{$data->fee}} @else FREE @endif</td>
  <td>{{$data->transection_id}}</td>
  <td>{{ date("F j Y",strtotime($data->created_at))}}</td>
</tr>
@empty
<tr>
  <td colspan="7"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 