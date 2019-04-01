<!DOCTYPE html>
<html lang="en">
    <head>
        @auth("administrator")
        @include('company.includes.admin_head')
        @endauth
        @auth("company")
        @include('company.includes.company_head')
        @endauth
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Main navbar -->
            <header class="main-header">
                @auth("administrator")
                @include('company.includes.header')
                @endauth
                @auth("company")
                @include('company.includes.header')
                @endauth
            </header>
            <!-- /main navbar -->
            <!-- main sidebar -->
            <aside class="main-sidebar">
                @auth("administrator")
                @include('company.includes.admin_sidebar')                
                @endauth
                @auth("company")
                @include('company.includes.sidebar')
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
                @include('company.includes.admin_footer')
                @endauth

                @auth("company")
                @include('company.includes.footer')
                @endauth
            </footer>

            <!-- Need To include FOOTER JS -->
            @auth("administrator")
            @include('company.includes.admin_footer_js')
            @endauth

            @auth("company")
            @include('company.includes.company_footer_js')
            @endauth
            <!-- /page content -->
        </div>
    </body>
</html>
