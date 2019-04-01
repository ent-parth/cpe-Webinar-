@extends('backEnd.layouts.admin_login')

@section('content')
<div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
</div>
<div class="login-box-body">
    <p class="login-box-msg">Paasword Recovery - We'll send you instructions in email</p>
    {{ Form::open(['name' => 'reset', 'id'=>'reset-password-form', 'class' => 'form-validate','route' => ['speaker.reset.password']]) }}
    {{ Form::hidden('token', $token) }}
      <div class="form-group has-feedback">
        {!! Form::text('email', old('email'), array('class' => 'form-control', 'id'=>'forgot-password-form','placeholder' => 'Email', 'autofocus' => 'autofocus','required' => 'required')) !!} 
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
        <label class="validation-invalid-label">{{ $errors->first('password') }}</label>                
        @endif
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Confirm Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password_confirmation'))
        <label class="validation-invalid-label">{{ $errors->first('password_confirmation') }}</label>                
        @endif
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-6 pull-right">
          {{ Form::button('Change Password',array('class'=>'btn btn-primary btn-block btn-flat','type'=>'submit','title'=>'Change Password')) }}
        </div>
        <!-- /.col -->
      </div>
     {{ Form::close() }}

  </div>
@endsection

@section('js')
{!! HTML::script('js/plugins/validation/validate.min.js') !!}
{!! HTML::script('js/login_validation.js') !!}
@endsection