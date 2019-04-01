@extends('backEnd.layouts.admin_login')

@section('content')
<div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
</div>
<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    {{ Form::open(['id' => 'login-form','class' => 'form-validate']) }}
      @if ($errors->has('email'))
      <label class="validation-invalid-label">{{ $errors->first('email') }}</label>
      @endif
      <div class="form-group has-feedback">
        {!! Form::text('email', null, array('class' => 'form-control', 'id'=>'email','placeholder' => 'Email', 'autofocus' => 'autofocus','required' => 'required')) !!} 
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
     {{ Form::close() }}

    <a href="{{route('administrator.email.reset.form')}}">I forgot my password</a><br>
  </div>
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
