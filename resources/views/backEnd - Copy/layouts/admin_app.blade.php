<!DOCTYPE html>
<html lang="en">
    <head>
        @include('backEnd.includes.admin_head')
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Main navbar -->
            <header class="main-header">
                @auth("administrator")
                @include('backEnd.includes.admin_header')
                @endauth

                @auth("speaker")
                @include('speaker.includes.header')
                @endauth
            </header>
            <!-- /main navbar -->
            <!-- main sidebar -->
            <aside class="main-sidebar">
                @auth("administrator")
                @include('backEnd.includes.admin_sidebar')                
                @endauth
                @auth("speaker")
                @include('speaker.includes.sidebar')
                @endauth
            </aside>
            <!-- /main sidebar -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                @auth("administrator")
                @include('backEnd.includes.admin_footer')
                @endauth

                @auth("speaker")
                @include('speaker.includes.footer')
                @endauth
            </footer>

            <!-- Need To include FOOTER JS -->
            @auth("administrator")
            @include('backEnd.includes.admin_footer_js')
            @endauth

            @auth("speaker")
            @include('backEnd.includes.admin_footer_js')
            @endauth
            <!-- /page content -->
        </div>
    </body>
</html>
