 @forelse($WebinarUserRegister as $ur)
<tr id="filter_tr{{$ur->id}}">
  <td>{{$ur->id}}</td>
  <td>{{$ur->first_name}} {{$ur->last_name}}<br/>
    <small>{{$ur->email}}</small></td>
  <td>{{$ur->email}}</td>
  <td>{{$ur->title}}</td>
  <td>@if($ur->webinar_type == 'self_study') self study @elseif($ur->webinar_type == 'live') live @elseif($ur->webinar_type == 'archived') archived @endif</td>
  <td>@if($ur->fee == '') Free  @else ${{$ur->fee}} @endif</td>
  <td>{{ date("F j Y",strtotime($ur->recorded_date)) }}@if($ur->webinar_type == 'live')<br/>
    ({{date("g:i A",strtotime($ur->start_time)).' - '.date("g:i A",strtotime($ur->end_time))}})@endif</td>
  <td>{{ date("F j Y",strtotime($ur->created_at))}}</td>
  <td>@if($ur->join_url == '') NA @else <a href="{{$ur->join_url}}" target="_blank">Join Link</a> @endif</td>
  <td>@if($ur->fee == '') NA @else {{$ur->payment_status}} @endif </td>
  <?php /*?><td>{{$ur->status}}</td><?php */?>
  <td>
  	<?php /*?>@if($ur->status == 'inactive' && $ur->webinar_type == 'live')
    <a href="/add-webinar-attendees/{{$ur->id}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-sm btn-default">Add Attendee</a>
    @endif<?php */?>
  </td>
</tr>
@empty
<tr>
  <td colspan="4"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 