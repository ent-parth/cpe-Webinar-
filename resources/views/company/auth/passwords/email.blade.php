@extends('backEnd.layouts.admin_login')
@section('content')
<div class="login-logo"> <a href="../../index2.html"><b>Admin</b>LTE</a> </div>
<div class="login-box-body">
  <p class="login-box-msg">Paasword Recovery - We'll send you instructions in email</p>
  {{ Form::open(['id' => 'login-form','class' => 'form-validate']) }}
  <div class="form-group has-feedback"> {!! Form::text('email', null, array('class' => 'form-control', 'id'=>'forgot-password-form','placeholder' => 'Email', 'autofocus' => 'autofocus','required' => 'required')) !!} <span class="glyphicon glyphicon-envelope form-control-feedback"></span> </div>
  <div class="row"> 
    <!--.col -->
    <div class="col-xs-4 pull-right">
      <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
    </div>
    <!--.col --> 
  </div>
  {{ Form::close() }} </div>
@endsection

@section('js') 
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script> 
@endsection 