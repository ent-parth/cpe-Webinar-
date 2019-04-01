<!DOCTYPE html>
<html lang="en">
    <head>
        @include('backEnd.includes.admin_head')
    </head>
    <body class="hold-transition register-page">
        <div class="wrapper">
            <!-- Content Wrapper. Contains page content -->
            <div class="">
                @yield('content')
            </div>
        @include('backEnd.includes.admin_footer_js')
        </div>
    </body>
</html>
