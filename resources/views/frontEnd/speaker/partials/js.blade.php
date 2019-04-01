<script>
if(!window.jQuery)
{
  var jquery_url = "<?php echo env('APP_URL').config('constants.FRONT_END_SPEAKER.JS_PATH').'jquery.min.js'; ?>";
  document.write('<script type="text/javascript" src="'+jquery_url+'"><\/script>');

}
</script>
{{ HTML::script(config('constants.FRONT_END_SPEAKER.JS_PATH').'bootstrap.min.js')}}
{{ HTML::script(config('constants.FRONT_END_SPEAKER.JS_PATH').'slick.js')}}
{{ HTML::script(config('constants.FRONT_END_SPEAKER.JS_PATH').'select2.min.js')}}
{{ HTML::script(config('constants.FRONT_END_SPEAKER.JS_PATH').'custom.js?time='.time())}}
<!-- jQuery page load code -->
<script>
      $(document).ready(function(){
        $('.selecttwo').select2();
        $('.courses-slick').slick({
          dots: false,
          arrow: true,
          infinite: false,
          adaptiveHeight: true,
          speed: 300,
          centerMode: true,
          centerPadding: '0',
          slidesToShow: 1,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: false,
                dots: false
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });
      });
      jQuery(function($) {
        $('.select2-multiple').select2MultiCheckboxes({
          templateSelection: function(selected, total) {
            return "Selected " + selected.length ;
          }
        })
      });
</script>