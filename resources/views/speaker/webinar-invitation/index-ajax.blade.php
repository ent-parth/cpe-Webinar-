@forelse($webinarInvitation as $webinarInvitationList)
<tr id="filter_tr{{$webinarInvitationList->id}}">
  <td>{{$webinarInvitationList->title}}</td>
  <td>{{ date("F j Y", strtotime($webinarInvitationList->recorded_date)) }}</td>
  <td>{{date("g:i A",strtotime($webinarInvitationList->start_time)).' - '.date("g:i A",strtotime($webinarInvitationList->end_time))}}</td>
  <td>@if ($webinarInvitationList->start_time < Carbon\Carbon::now()->addHours(2) && $webinarInvitationList->status == "pending") Expired @else   {{$webinarInvitationList->status}} @endif</td>
  <td>@if($webinarInvitationList->joinLink) <a href="{{$webinarInvitationList->joinLink}}" target="_blank">JoinLink</a> @endif</td>
  <td><a href="{{route('speaker.webinar-invitation.view',encrypt($webinarInvitationList->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Manage Invitation">Manage Invitation</a></td>
</tr>
@empty
<tr>
  <td colspan="7"><center>
      No Records Available
    </center></td>
</tr>
@endforelse 