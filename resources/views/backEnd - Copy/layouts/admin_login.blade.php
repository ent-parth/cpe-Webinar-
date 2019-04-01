<!DOCTYPE html>
<html lang="en">
    <head>
        @include('backEnd.includes.login_head')
    </head>    
    <body class="hold-transition login-page">
        <!-- Page content -->
        <div class="login-box">
            <!-- Main content -->
                @yield('content')
            <!-- /main content -->
        </div>
        <!-- /page content -->
    </body>
    @include('backEnd.includes.login_footer')
</html>
