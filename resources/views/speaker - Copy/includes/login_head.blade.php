<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name') }}</title>

<!-- Global stylesheets -->
{!! HTML::style('js/plugins/bootstrap/dist/css/bootstrap.min.css') !!}
{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
{!! HTML::style('js/plugins/Ionicons/css/ionicons.min.css') !!}
{!! HTML::style('css/AdminLTE.min.css') !!}
{!! HTML::style('js/plugins/iCheck/square/blue.css') !!}
{!! HTML::style('css/custom.css') !!}
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
@yield('css')
<!-- Global stylesheets -->
