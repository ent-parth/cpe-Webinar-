@extends('speaker.layouts.speaker_app')
@section('content')
<section class="content-header">
  <h1> Edit Question for {{$webinars->title}} webinar</h1>
</section>
{!! HTML::style('css/jquery_ui/jquery-ui.css') !!}
{!! HTML::style('css/timepicker/timePicker.min.css') !!} 

<!-- Main content -->
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary"> 
        <!-- /.box-header --> 
        <!-- form start -->
        
        <form id="updateWebinarQuestion" name="updateWebinarQuestion" action="{{route('speaker.update_webinar_question')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Time<span aria-required="true" class="required"> * </span></label>
                    <div class='input-group date' id='datetimepicker1'>
                      <input type='text' class="form-control" placeholder="Select Time" required="required" value="{{$WebinarQuestionsEdit->time}}"  id="time" name="time" autocomplete="off" />
                      <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                  </div>
                  <span id="time_error_Message"></span> 
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Question <span aria-required="true" class="required"> * </span></label>
                    <textarea  placeholder="Write Question Here" required="required" name="question" id="question" value="{{$WebinarQuestionsEdit->question}}" class="form-control">{{$WebinarQuestionsEdit->question}}</textarea>
                  </div>
                </div>
              </div>
              
              
              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Option A <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_a" id="option_a" class="form-control" value="{{$WebinarQuestionsEdit->option_a}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Answer Note A<span aria-required="true" class="required"> *</span></label>
                    <textarea id="currect_answer_note_a" name="currect_answer_note_a" class="form-control" required="required">{{$WebinarQuestionsEdit->currect_answer_note_a}}</textarea>
                  </div>
                </div>
                <!--<div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Wrong Answer Note A<span aria-required="true" class="required"> *</span></label>
                    <textarea id="wrong_answer_note_a" name="wrong_answer_note_a" class="form-control" required="required">{{$WebinarQuestionsEdit->wrong_answer_note_a}}</textarea>
                  </div>
                </div>-->
              </div>
              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Option B <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_b" id="option_b" class="form-control" value="{{$WebinarQuestionsEdit->option_b}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Answer Note B<span aria-required="true" class="required">* </span></label>
                    <textarea id="currect_answer_note_b" name="currect_answer_note_b" class="form-control" required="required">{{$WebinarQuestionsEdit->currect_answer_note_b}}</textarea>
                  </div>
                </div>
                <!--<div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Wrong Answer Note B<span aria-required="true" class="required"> *</span></label>
                    <textarea id="wrong_answer_note_b" name="wrong_answer_note_b" class="form-control" required="required">{{$WebinarQuestionsEdit->wrong_answer_note_b}}</textarea>
                  </div>
                </div>-->
              </div>
              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Option C <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_c" id="option_c" class="form-control" value="{{$WebinarQuestionsEdit->option_c}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Answer Note C<span aria-required="true" class="required"> *</span></label>
                    <textarea id="currect_answer_note_c" name="currect_answer_note_c" class="form-control" required="required">{{$WebinarQuestionsEdit->currect_answer_note_c}}</textarea>
                  </div>
                </div>
                <!--<div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Wrong Answer Note C<span aria-required="true" class="required"> *</span></label>
                    <textarea id="wrong_answer_note_c" name="wrong_answer_note_c" class="form-control" required="required">{{$WebinarQuestionsEdit->wrong_answer_note_c}}</textarea>
                  </div>
                </div>-->
              </div>  
              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Option D <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" placeholder="" required="required" name="option_d" id="option_d" class="form-control" value="{{$WebinarQuestionsEdit->option_d}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Answer Note D<span aria-required="true" class="required"> *</span></label>
                    <textarea id="currect_answer_note_d" name="currect_answer_note_d" class="form-control" required="required">{{$WebinarQuestionsEdit->currect_answer_note_d}}</textarea>
                  </div>
                </div>
                <!--<div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label"> Wrong Answer Note D<span aria-required="true" class="required">* </span></label>
                    <textarea id="wrong_answer_note_d" name="wrong_answer_note_d" class="form-control" required="required">{{$WebinarQuestionsEdit->wrong_answer_note_d}}</textarea>
                  </div>
                </div>-->
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Answer <span aria-required="true" class="required"> * </span></label>
                    <select name="answer" id="answer" class="form-control" required>
                      <option value="">Select </option>
                      <option value="a" @if(isset($WebinarQuestionsEdit->answer) && $WebinarQuestionsEdit->answer == 'a') selected="selected" @endif>A</option>
                      <option value="b" @if(isset($WebinarQuestionsEdit->answer) && $WebinarQuestionsEdit->answer == 'b') selected="selected" @endif>B</option>
                      <option value="c" @if(isset($WebinarQuestionsEdit->answer) && $WebinarQuestionsEdit->answer == 'c') selected="selected" @endif>C</option>
                      <option value="d" @if(isset($WebinarQuestionsEdit->answer) && $WebinarQuestionsEdit->answer == 'd') selected="selected" @endif>D</option>
                    </select>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <!-- /.box-body -->
          
          <div class="box-footer">
            <div class="col-md-12 text-right">
              <button type="button" class="btn btn-primary ml-3" onclick="submitQuestion()">update</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{encrypt($WebinarQuestionsEdit->id)}}">
              <input type="hidden" name="type" id="type" value="{{$WebinarQuestionsEdit->type}}">
              <input type="hidden" name="webinar_id" value="{{encrypt($webinars->id)}}">
              <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
              <a href="{{ env('SPEAKER_URL').'/selfstudy-webinars/'.encrypt($webinars->id).'/add-webinar-question'}}" class="btn btn-danger" title="Cancel"> Cancel </a> </div>
          </div>
        </form>
      </div>
      <!-- /.box -->
      
      <?php /*?><div class="box box-primary">
      <h3>Review Questions</h3>
        <table id="webinar-list" class="table table-bordered table-hover datatable-highlight">
          <thead>
            <tr class="heading">
              <th class="listing-id">#</th>
              <th width="20%">Question </th>
              <th width="10%">Answer</th>
              <th width="10%">Type</th>
              <th width="15%">Status</th>
              <th class="listing-action">Action</th>
            </tr>
          </thead>
          <tfoot>
          
          @forelse($WebinarQuestionsReview as $Questions)
          <tr id="filter_tr{{$Questions->id}}">
            <td>{{$Questions->id}}</td>
            <td>{{$Questions->question}}</td>
            <td>Option <b style="font-size:16px; text-transform:capitalize;">{{$Questions->answer}}</b></td>
            <td>{{$Questions->type}}</td>
            <td>{{$Questions->status}}</td>
            <td><a a href="{{route('speaker.edit_webinar_question', encrypt($Questions->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a> <a href="{{env('SPEAKER_URL').'/selfstudy-webinars/delete-question/'.encrypt($Questions->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"  title="Delete Question" onclick="return confirm('Are you sure, you want to delete?')" class="btn btn-group btn-default btn-sm delete-record-custom"><i class="fa fa-trash-o"></i></a></td>
          </tr>
          @empty
          <tr>
            <td colspan="6"><center>
                No Records Available
              </center></td>
          </tr>
          @endforelse
            </tfoot>
          
        </table>
      </div>
      
      <div class="box box-primary">
       <h3>Final Questions</h3>
        <table id="webinar-list" class="table table-bordered table-hover datatable-highlight">
          <thead>
            <tr class="heading">
              <th class="listing-id">#</th>
              <th width="20%">Question </th>
              <th width="10%">Answer</th>
              <th width="10%">Type</th>
              <th width="15%">Status</th>
              <th class="listing-action">Action</th>
            </tr>
          </thead>
          <tfoot>
          
          @forelse($WebinarQuestionsFinal as $Questions)
          <tr id="filter_tr{{$Questions->id}}">
            <td>{{$Questions->id}}</td>
            <td>{{$Questions->question}}</td>
            <td>Option <b style="font-size:16px; text-transform:capitalize;">{{$Questions->answer}}</b></td>
            <td>{{$Questions->type}}</td>
            <td>{{$Questions->status}}</td>
            <td><a a href="{{route('speaker.edit_webinar_question', encrypt($Questions->id))}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}" class="btn btn-group btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a> <a href="{{env('SPEAKER_URL').'/selfstudy-webinars/delete-question/'.encrypt($Questions->id)}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"  title="Delete Question" onclick="return confirm('Are you sure, you want to delete?')" class="btn btn-group btn-default btn-sm delete-record-custom"><i class="fa fa-trash-o"></i></a></td>
          </tr>
          @empty
          <tr>
            <td colspan="6"><center>
                No Records Available
              </center></td>
          </tr>
          @endforelse
            </tfoot>
          
        </table>
      </div><?php */?>
    </div>
  </div>
</section>
<!-- /.content --> 
@endsection
@section('js') 
<script language="javascript" src="https://momentjs.com/downloads/moment.js"></script> 
<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">
{{ HTML::script('https://momentjs.com/downloads/moment.js') }}
{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }} 
<script language="javascript" type="application/javascript">
	$('#datetimepicker1').datetimepicker({
		format: 'hh:mm:ss',
	});
	
	$('#updateWebinarQuestion').validate({
		ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
		errorClass: 'validation-invalid-label',
		successClass: 'validation-valid-label',
		validClass: 'validation-valid-label',
		highlight: function (element, errorClass) {
			$(element).removeClass(errorClass);
		},
		unhighlight: function (element, errorClass) {
			$(element).removeClass(errorClass);
		},
		
		// Different components require proper error label placement
		errorPlacement: function (error, element) {
			// Unstyled checkboxes, radios
			if (element.parents().hasClass('form-check')) {
				error.appendTo(element.parents('.form-check').parent());
			}else if(element.attr("name") == "time"){
				error.appendTo("#time_error_Message");
			}else {
				error.insertAfter(element);
			}
		}
	});
	
	
	function submitQuestion(){
		var valid = $('#updateWebinarQuestion').validate();
		if(valid) {
			$("#updateWebinarQuestion").submit();
		}else{
			validator.focusInvalid();
	        return false;	
		}	
	}
</script> 
@endSection 