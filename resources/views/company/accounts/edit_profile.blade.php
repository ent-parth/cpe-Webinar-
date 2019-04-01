@extends('company.layouts.company_app')
@section('content')
<section class="content-header">
  <h1> Edit Company Profile</h1>
</section>
{!! HTML::style('css/jquery_ui/jquery-ui.css') !!}
{!! HTML::style('css/timepicker/timePicker.min.css') !!}
{!! HTML::style('css/datetimepicker/bootstrap-datetimepicker.css') !!} 
{!! HTML::style('css/jquery-confirm.css') !!} 
<style type="text/css">
	.error{color:#F00;}
</style>
<!-- Main content -->
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary"> 
        <!-- /.box-header --> 
        <!-- form start -->
        <form id="updateCompany" name="updateCompany" action="{{route('company-edit-profile')}}" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Company Name <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255"  noSpace=true placeholder="Company Name" value="{{$companyDetail->company_name}}" required="required" name="company_name" id="company_name" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Contact Person Name <span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255"  noSpace=true placeholder="Contact Person Name" value="{{$companyDetail->name}}" required="required" name="name" id="name" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Email (UserName)<span aria-required="true" class="required"> * </span></label>
                    <input type="text" minlength="2" maxlength="255" disabled="disabled"  noSpace=true placeholder="Email" value="{{$companyDetail->email}}" required="required" name="email" id="email" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Email of Person <span aria-required="true" class="required">  </span></label>
                    <input type="text" minlength="2" maxlength="255"  noSpace=true placeholder="Person Email" value="{{$companyDetail->person_email}}" name="person_email" id="person_email" class="form-control email">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Phone Number<span aria-required="true" class="required">  </span></label>
                    <div class="col-md-12"  style="padding-left:0px; padding-right:0px;">
                      <div class="col-md-6"  style="padding-left:0px; padding-right:0px;">
                        <div class="form-group">
                          <input type="text" minlength="2" maxlength="15"  noSpace=true placeholder="Office Phone Number" value="{{$companyDetail->phone}}"  name="phone" id="phone" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                        	<input type="text" minlength="1" maxlength="15"  noSpace=true placeholder="Extension number" value="{{$companyDetail->phone_ext}}"  name="phone_ext" id="phone_ext" class="form-control">  
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Mobile <span aria-required="true" class="required"> </span></label>
                    <input type="text" minlength="2" maxlength="15"  noSpace=true placeholder="Contact Person Mobile Number" value="{{$companyDetail->mobile}}"  name="mobile" id="mobile" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Designation <span aria-required="true" class="required">  </span></label>
                    <input type="text" minlength="2" maxlength="255"  noSpace=true placeholder="Designation" value="{{$companyDetail->designation}}"  name="designation" id="designation" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Website <span aria-required="true" class="required">  </span></label>
                    <input type="text" minlength="2" maxlength="255"  noSpace=true placeholder="https://www.abc.com" value="{{$companyDetail->website}}"  name="website" id="website" class="form-control url">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">About Company <span aria-required="true" ></span></label>
                    <textarea id="about_company" name="about_company" rows="10" class="form-control">{{$companyDetail->about_company}}</textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Company Logo <span aria-required="true" class="required">  </span></label>
                    <input type="file" name="logo" id="logo" class="form-control" extension = "jpg|png|gif|jpeg">
                    <span>Allowed file type are : jpg,png,gif,jpeg</span> @if(!empty($companyDetail->logo) && file_exists(public_path('uploads/company_logo/'.$companyDetail->logo)))
                    <p>Uploaded Logo <img src="{{env('APP_URL')}}/uploads/company_logo/{{$companyDetail->logo}}" width="100" /></p>
                    @endif </div>
                </div>
              </div>
              
              <?php /*?>
			  		<div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Credit Card Number <span aria-required="true" class="required">  </span></label>
                    <input type="text" minlength="16" maxlength="16"  noSpace=true placeholder="1234 5678 9012 3456" value="{{$companyDetail->credit_card_number}}" name="credit_card_number" id="credit_card_number" class="form-control customRequiredFileds">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> Name On Card <span aria-required="true" class="required">  </span></label>
                    <input type="text" minlength="2" maxlength="255"  noSpace=true placeholder="John Deo" value="{{$companyDetail->name_on_card}}"  name="name_on_card" id="name_on_card" class="form-control">
                  </div>
                </div>
              </div>
             	 	<div class="col-md-12">
                <div class="col-md-6"  style="padding-left:0px; padding-right:0px;">
                  <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Card Expiry Month <span aria-required="true" class="required">  </span></label>
                        <input type="text" minlength="2" maxlength="2"  noSpace=true placeholder="exp. 10" value="{{$expMonth}}"  name="card_expiry_month" id="card_expiry_month" class="form-control customRequiredFileds">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Card Expiry Year <span aria-required="true" class="required">  </span></label>
                        <input type="text" minlength="2" maxlength="2"  noSpace=true placeholder="exp. 20" value="{{$expYear}}"  name="card_expiry_year" id="card_expiry_year" class="form-control customRequiredFileds">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label"> CVV <span aria-required="true" class="required"> </span></label>
                    <input type="text" minlength="2" maxlength="3"  noSpace=true placeholder="123" value="{{$companyDetail->card_cvv}}"  name="card_cvv" id="card_cvv" class="form-control customRequiredFileds">
                  </div>
                </div>
              </div>
			  <?php */?>
            </div>
          </div>
          <!-- /.box-body -->
          
          <div class="box-footer">
            <div class="col-md-12 text-right">
              <?php /*?><a href="{{ route('speaker.companyDetail') }}" class="btn btn-danger" title="Cancel"> Cancel </a> <?php */?>
              <?php /*?><button type="button" class="btn btn-primary ml-3" onclick="cardFormValidate()" id="updateBtn">Update</button><?php */?>
              <button type="submit" class="btn btn-primary ml-3" >Update</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
{{ HTML::script('https://momentjs.com/downloads/moment.js') }}
{{ HTML::script('js/jquery-confirm.js') }}
{{ HTML::script('js/plugins/validation/validate.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
{{ HTML::script('/js/plugins/jquery_ui/jquery-ui.js') }}
{{ HTML::script('js/plugins/validation/additional_methods.min.js') }}
{{ HTML::script('js/creditCardValidator.js') }} 
<script language="javascript" type="application/javascript">
	var validateForm = $('#updateCompany').validate();

	function cardFormValidate(){
		if(!$('#updateCompany').valid()){
			validateForm.focusInvalid();
			return false;
		}
		var cardValid = 0;
	
		//card number validation
		$('#credit_card_number').validateCreditCard(function(result){
			if(result.valid){
				$("#credit_card_number").removeClass('required');
				cardValid = 1;
			}else{
				//$("#credit_card_number").addClass('required');
				cardValid = 0;
			}
		});
		
		//card details validation
		var cardName = $("#name_on_card").val();
		var expMonth = $("#card_expiry_month").val();
		var expYear = $("#card_expiry_year").val();
		var cvv = $("#card_cvv").val();
		var regName = /^[a-z ,.'-]+$/i;
		var regMonth = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
		var regYear = /^13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37$/;
		var regCVV = /^[0-9]{3,3}$/;
		
		var finalvalidate = true;
		if (cardValid == 0) {
			if($('#credit_card_number').val()!=''){
				$("#credit_card_number").addClass('required');
				$("#credit_card_number").focus();
				finalvalidate =  false;
			}
		}else if (!regName.test(cardName)) {
			$("#credit_card_number").removeClass('required');
			$("#cvv").removeClass('required');
			if($('#name_on_card').val()!=''){
				$("#name_on_card").addClass('required');
				$("#name_on_card").focus();
				finalvalidate = false;
			}
		}else if (!regMonth.test(expMonth)) {
			$("#credit_card_number").removeClass('required');
			$("#name_on_card").removeClass('required');
			if($('#card_expiry_month').val()!=''){
				$("#card_expiry_month").addClass('required');
				$("#card_expiry_month").focus();
				finalvalidate = false;
			}
		}else if (!regYear.test(expYear)) {
			$("#credit_card_number").removeClass('required');
			$("#card_expiry_month").removeClass('required');
			if($('#card_expiry_year').val()!=''){
				$("#card_expiry_year").addClass('required');
				$("#card_expiry_year").focus();
				finalvalidate = false;
			}
		}else if (!regCVV.test(cvv)) {
			$("#credit_card_number").removeClass('required');
			$("#card_expiry_month").removeClass('required');
			$("#card_expiry_year").removeClass('required');
			if($('#card_cvv').val()!=''){
				$("#card_cvv").addClass('required');
				$("#card_cvv").focus();
				finalvalidate = false;
			}
		}else{
			$("#credit_card_number").removeClass('required');
			$("#card_expiry_month").removeClass('required');
			$("#card_expiry_year").removeClass('required');
			$("#card_cvv").removeClass('required');
			$("#name_on_card").removeClass('required');
			finalvalidate = true;
		}
		
		if(finalvalidate){
			$("#updateCompany").submit();
		}
	}
</script> 
@endSection 