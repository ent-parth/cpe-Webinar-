@extends('speaker.layouts.speaker_app')
@section('content')
<style>
#uploadVideoForm {border-top:#F0F0F0 2px solid;background:#FAF8F8;padding:10px;}
#uploadVideoForm label {margin:2px; font-size:1em; font-weight:bold;}
.demoInputBox{padding:5px; border:#F0F0F0 1px solid; border-radius:4px; background-color:#FFF;}
#progress-bar {background-color: #12CC1A;height:20px;color: #FFFFFF;width:0%;-webkit-transition: width .3s;-moz-transition: width .3s;transition: width .3s;}
.btnSubmits{background-color:#09f;border:0;padding:10px 40px;color:#FFF;border:#F0F0F0 1px solid; border-radius:4px;}
#progress-div {border:#0FA015 1px solid;padding: 5px 0px;margin:30px 0px;border-radius:4px;text-align:center;}
#targetLayer{width:100%;text-align:center;}
.requireds{color:#F00;}
  .required{color:#000 !important;}

</style>

<section class="content-header">
  <h1> Upload video for Webinar <span class="pull-right"><a href="/selfstudy-webinars">List view</a></span></h1>
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
        <div class="col-md-12">
        	<div class="col-md-6">
            	<div class="form-group">
            		<form id="uploadVideoForm" name="uploadVideoForm" action="{{route('speaker.self_study_webinars.store_video')}}" enctype="multipart/form-data" method="post">
                    <label class="control-label">Video <span aria-required="true" class="requireds"> * </span></label>
            		<div>
                    	<input name="video" id="video" type="file" class="demoInputBox form-control" required="required" extension = "mp4|3gp|webm|wmv|flv" />
                	</div>
                    <div>
                    	<input type="submit" id="btnSubmit" value="Upload Video" class="btn btn-primary ml-3 btnSubmits" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="webinar_id" value="{{$id}}">
                        <input type="hidden" name="actionType" value="edit">
                        <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
                        <span><a href="javascript:void(0)" class="btn btn-danger stopvideo" title="Cancel"> Cancel </a></span>
                    </div>
                    <div id="progress-div" style="display:none;"><div id="progress-bar"></div></div>
                    <div id="targetLayer"></div>
                     <span>Allowed file type are : mp4, 3gp, webm, wmv, flv</span>
                    </form>
            	</div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content --> 
@endsection
@section('js')
{{ HTML::script('https://momentjs.com/downloads/moment.js') }}
{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }} 
{{ HTML::script('js/plugins/validation/additional_methods.min.js') }}
{{ HTML::script('/js/jquery.form.js') }} 
<script type="text/javascript">
    	$(document).ready(function(){
			
			$('#uploadVideoForm').submit(function(e) {	
				var valid = $('#uploadVideoForm').valid();
				if(valid){
					if($('#video').val()) {
						e.preventDefault();
						$('#loader-icon').show();
						ajaxCall = $(this).ajaxSubmit({ 
							target:   '#targetLayer', 
							beforeSubmit: function() {
								$('#uploadVideoForm').find("[type=submit]").hide();
							  	$('#updateWebinar').find("[type=submit]").hide();
							  	$('#updateWebinar').find(".BtnCancel").hide();	
							  	$('#progress-div').show();		
							  	$("#progress-bar").width('0%');
							},
							uploadProgress: function (event, position, total, percentComplete){	
								$("#progress-bar").width(percentComplete + '%');
								$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
							},
							success:function (data){
								$('#uploadVideoForm').find("[type=submit]").show();
								window.location.href = '{{env("SPEAKER_URL")}}/selfstudy-webinars';
								$('#loader-icon').hide();
							},
							resetForm: true 
						}); 
						return false; 
					}
				}else{
					return false; 
				}
				
				
			
			});
				$(document).on('click','.stopvideo', function(e){ 
				$('#uploadVideoForm').find("[type=submit]").show();
					var xhr = ajaxCall.data('jqxhr');
					xhr.abort();
				});

   		}); 
</script> 
@endSection 