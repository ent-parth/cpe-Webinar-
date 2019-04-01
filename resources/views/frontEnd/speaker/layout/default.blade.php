<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>

  <!-- BEGIN INCLUDED META DETAILS LIKE FAVICON,META TAGS -->
  @include('frontEnd.speaker.partials.metatag')
  <!-- END INCLUDED META DETAILS LIKE FAVICON,META TAGS -->

  <!-- BEGIN INCLUDED CSS -->
  @include('frontEnd.speaker.partials.css')
  <!-- END INCLUDED CSS -->
  <style>
      .inner-banner-row .inner-banner-caption{max-width: 100%;padding: 50px 0;}
      .login-area{margin-top: 60px;}
      .inner-banner-row ol{text-align: left;padding: 10px 0}
      .inner-banner-row ol li{position: relative;padding-left: 25px;    }
      .inner-banner-row ol li:before{background-image: url({{config('constants.FRONT_END_SPEAKER.IMAGE_PATH')}}check-icon.png);background-position: center center;width: 15px; height:15px;position: absolute;content: '';left:0;background-repeat: no-repeat;background-size: 100% auto;top: 6px}
      .inner-banner-row .inner-banner-caption h1{font-size: 30px;margin-bottom: 20px}
      .inner-banner-row p{text-align: left}
      
      @media (max-width:767px){
          .inner-banner-row .inner-banner-caption h1{font-size: 24px;margin-bottom: 20px;line-height: normal}
          .inner-banner-row p{text-align: center}
          .inner-banner-row .inner-banner-caption{padding: 30px 0}
      }
      .select2
      {
          width:100% !important;
      }
  </style>
</head>
<!--START BODY -->
<body>
  <div id="wrapper">
    <header>
      @include('frontEnd.speaker.partials.header')
    </header>
    <!-- BEGIN CONTENT -->
    @yield('content')
    <!-- END CONTENT -->
    <!-- BEGIN INCLUDED JS -->
    @include('frontEnd.speaker.partials.js')
    <!-- END INCLUDED JS -->

    <!-- BEGIN FOOTER -->
    @include('frontEnd.speaker.partials.footer')
    <!-- END FOOTER -->
</div>
<!-- END BODY -->
</html>