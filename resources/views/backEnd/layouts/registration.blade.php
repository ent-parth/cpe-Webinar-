<!DOCTYPE html>
<html lang="en">
    <head>
        @extends('backEnd.includes.admin_head');
        {!! HTML::style('js/plugins/iCheck/square/blue.css') !!}
    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href="javascript:void(0)">Speaker Sign Up</a>
            </div>
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
        @extends('backEnd.includes.admin_footer_js');
        </div>
    </body>
</html>