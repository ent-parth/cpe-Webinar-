 @forelse($WebinarUserRegister as $ur)
<tr id="filter_tr{{$ur->id}}">
  <td>{{$ur->id}}</td>
  <td>{{$ur->first_name}} {{$ur->last_name}}<br/>
    <small>{{$ur->email}}</small></td>
    <?php
   /*<td>{{$ur->email}}</td>*/
  ?>
  <td>{{$ur->title}}</td>
  <td>@if($ur->webinar_type == 'self_study') self study @elseif($ur->webinar_type == 'live') live @elseif($ur->webinar_type == 'archived') archived @endif</td>
  <td>@if($ur->fee == '') Free  @else ${{$ur->fee}} @endif</td>
  
  <td>@if($ur->webinar_type == 'live')
  		{{ date("F j Y",strtotime($ur->recorded_date))}}<br /><small>{{ $ur->time_zone }}</small>
  		<br/>
    	{{ CommonHelper::convertTime($ur->start_time,$ur->time_zone,'g:i A').' - '.CommonHelper::convertTime($ur->end_time,$ur->time_zone,'g:i A')}}
      @else
      	{{ date("F j Y",strtotime($ur->recorded_date)) }}<br /><small>{{ $ur->time_zone }}</small>
      @endif
      
   </td>
    
   
    <td>{{ date("F j Y",strtotime($ur->created_at))}}</td>
    
    @if($ur->webinar_type == 'live') <td><a href="{{$ur->join_url}}" target="_blank">JoinLink</a></td> @else <td></td>@endif
  
    <td>@if($ur->fee == '') NA @else {{$ur->payment_status}} @endif </td>
  <?php
  /*<td>@if($ur->join_url == '') NA @else <a href="{{$ur->join_url}}" target="_blank">Join Link</a> @endif</td>*/
  ?>
  
  
  <?php
  /*<td>{{$ur->status}}</td>*/
  ?>
  <td>
  </td>
</tr>
@empty
<tr>
  <td colspan="4"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 