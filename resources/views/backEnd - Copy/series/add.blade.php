@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content-header">
  <h1> Add Series <span class="pull-right small"><a href="/series"><b>List view</b></a></span></h1>
</section>
{!! HTML::style('css/jquery_ui/jquery-ui.css') !!}
{!! HTML::style('css/timepicker/timePicker.min.css') !!}
{!! HTML::style('css/datetimepicker/bootstrap-datetimepicker.css') !!} 

<!-- Main content -->
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary"> 
        <!-- /.box-header --> 
        <!-- form start -->
        <form id="addSeries" name="addSeries" action="{{route('series.store')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label"> Series Name <span aria-required="true" class="required"> * </span></label>
                      <input type="text" minlength="2" maxlength="255" placeholder="Series Name" required="required" name="name" id="name" class="form-control">
                    </div>
                  </div>  
                  
                
          
          <div class="box-footer">
            <div class="col-md-12 text-right"> 
            	<a href="{{ route('series') }}" class="btn btn-danger" title="Cancel"> Cancel </a> 
                <button type="submit" class="btn btn-primary ml-3" >Save</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="webinar_id" value="">
                <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
            </div>
          </div>
        </form>
      </div>
      <!-- /.box --> 
    </div>
  </div>
</section>
<!-- /.content --> 
@endsection
@section('js')
{{ HTML::script('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js?t=20130302') }}

{{ HTML::script('https://momentjs.com/downloads/moment.js') }}


{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/ckeditor/ckeditor.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }}


<script language="javascript" type="application/javascript">
	$(function() {
		$('#addSeries').validate();
		
		var date = new Date();
		date.setDate(date.getDate());
				
		

		/*//Customization option For Time Picker
		$(".time-picker").hrTimePicker({
			disableColor: "#989c9c", // red, green, #000
			enableColor: "#ff5722", // red, green, #000
			arrowTopSymbol: "&#9650;", // ▲ -- Enter html entity code
			arrowBottomSymbol: "&#9660;" // ▼ -- Enter html entity code
		});*/
    	$(".time-picker").hrTimePicker();
	});
	
	

</script>

@endSection 