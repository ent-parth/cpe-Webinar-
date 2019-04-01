
<a href="{{route('administrator.dashboard')}}" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><b>A</b>LT</span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>Admin</b>LTE</span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
  <?php /*?>@php  
  $notification  = CommonHelper::getAdminNotification(Auth::guard('administrator')->user()->id); 
  @endphp
  @if (count($notification) > 0)
        <li class="dropdown messages-menu" id="message_li">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success" id="notification_count">{{count($notification)}}</span>
              </a>
              <ul class="dropdown-menu">
               
               @foreach($notification as $n_data)
                <li id="{{$n_data['id']}}">
                  <ul class="menu">
                    <li>
                      <a href="#" onclick=AdminNotification({{$n_data->id}},'{{url('/')}}/{{$n_data->link}}');>
                        
                        <h4>
                        {{$n_data->notification_text}}
                         
                        </h4>
                        <small><i class="fa fa-clock-o"></i>  {{ Carbon\Carbon::parse($n_data->created_at)->diffForHumans()}} </small>
                      </a> 
                      <button type="button" onclick=AdminNotification({{$n_data->id}},'nolink');>Read</button>
                      <li>
                    </li>
                  </ul>
                </li>
                @endforeach
              
              </ul>
        </li>
  @endif<?php */?>
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="{{asset(Auth::guard('administrator')->user()->avatar_url)}}" class="user-image" alt="User Image">
          <span class="hidden-xs">{{  Auth::guard('administrator')->user()->full_name ?: ''}}</span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="{{asset(Auth::guard('administrator')->user()->avatar_url)}}" class="img-circle" alt="User Image">

            <p>
              {{  Auth::guard('administrator')->user()->full_name ?: ''}}
              <!-- <small>Member since Nov. 2012</small> -->
            </p>
          </li>
          <!-- Menu Body -->
          <!-- <li class="user-body">
            <div class="row">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
          </li>-->
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{route('administrator.edit.form')}}" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
              <a href="{{ route('administrator.logout') }}" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
      <!-- <li>
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li> -->
    </ul>
  </div>
</nav>