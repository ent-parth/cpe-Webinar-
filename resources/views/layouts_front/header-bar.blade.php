<header>
  <div class="d-flex justify-content-between align-items-center"> <a href="{{env('APP_URL')}}" class="logo"><img src="{{env('APP_URL')}}/images/logo.png" alt="my cpe" title="my cpe"></a>
    <div class="right-nav-area">
      <ul class="user-cred-area">
        <li><a href="javascrpt:void(0);" class="btn btn-primary text-uppercase">Become a Speaker</a></li>
        @if(Session::get('mycpa_client_id'))
        <li>Welcome {{Session::get('mycpa_client_first_name')}}</li>
        <li><a href="{{route('client-logout')}}" class="btn btn-primary text-uppercase">Log Out</a></li>
        @else
        <li><a href="{{route('client.register')}}" class="btn btn-primary text-uppercase">SIGN IN</a></li>
        <li><a href="{{route('client.register')}}" class="btn btn-primary text-uppercase">SIGN UP</a></li>
        @endif 
        <!-- <li class="search-btn">
                            <a href="javascrpt:void(0);"><img src="images/icon-search.png" alt=""></a>
                        </li> -->
      </ul>
    </div>
  </div>
</header>
<script>
	$(function() {
    setTimeout(function() {
		$(".anyKindOfMesss").hide()
    }, 3000);
});	
</script>
<div class="container contentIos" >
  <?php 
		if (Session::has('mycpa_message_success')) { ?>
  <div class="alert alert-success alert-dismissable messagealert anyKindOfMesss">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Success!</strong> {{ Session::get('mycpa_message_success')}} </div>
  <?php Session::forget('mycpa_message_success');
    	} 
		if (Session::has('mycpa_message_error')) { ?>
  <div class="alert alert-danger alert-dismissable messagealert anyKindOfMesss">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Error!</strong> {{ Session::get('mycpa_message_error')}} </div>
  <?php Session::forget('mycpa_message_error');
    	} 
		if (Session::has('mycpa_message_warning')) { ?>
  <div class="alert alert-warning alert-dismissable messagealert anyKindOfMesss">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Warning!</strong> {{ Session::get('mycpa_message_warning')}} </div>
  <?php Session::forget('mycpa_message_warning');
    	} 
	?>
</div>
