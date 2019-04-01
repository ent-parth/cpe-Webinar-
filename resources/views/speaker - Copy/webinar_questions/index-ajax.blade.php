@forelse($WebinarQuestions as $Questions)       


    <tr id="filter_tr{{$Questions->id}}">
      <td>{{$Questions->id}}</td>
      <td>{{$Questions->question}}</td>
      <td>{{$Questions->title}}</td>
      <td>{{$Questions->type}}</td>
      <td>{{$Questions->status}}</td>


      <td>
     
      
      	<a a href="{{route('speaker.webinar-questions.edit', $Questions->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
        
        <a href="{{route('speaker.webinar-questions.delete',$Questions->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" onclick="return confirm('Are you sure you want to delete.?');" title="Delete" class="btn btn-group btn-default btn-sm delete-record-custom"><i class="fa fa-trash-o"></i></a>
    
      </td>
    </tr>
@empty
    <tr>
      <td colspan="7"><center>No Records Available</center></td>
    </tr>
@endforelse 
