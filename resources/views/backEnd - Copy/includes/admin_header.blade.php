
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
<?php /*
<div class="navbar-brand">
    <a href="{{route('administrator.dashboard')}}" class="d-inline-block">         
        <span style="
              color: #fff;
              font-size: 16px;
              letter-spacing: 2px;
              font-weight: 600;
              text-transform: uppercase;
              ">{{ 'Bawsala'}}</span>
    </a>
</div>
<div class="collapse navbar-collapse" id="navbar-mobile">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                <i class="icon-paragraph-justify3"></i>
            </a>
        </li>
    </ul>
    <span class="navbar-text ml-md-3 mr-md-auto">
    </span>

    <ul class="navbar-nav">
        

        <li class="nav-item dropdown dropdown-user">
            
            <div class="dropdown-menu dropdown-menu-right">                
                @permission('edit-profile')
                <a href="{{route('administrator.edit.form')}}" class="dropdown-item"><i class="icon-cog5"></i> {{__('messages.account_settings')}}</a>
                @endpermission
                <a href="{{ route('administrator.logout') }}" class="dropdown-item"
                   onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                    <i class="icon-switch2"></i> {{__('messages.logout')}}
                </a>

                <form id="logout-form" action="{{ route('administrator.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
</div>
*/ ?>