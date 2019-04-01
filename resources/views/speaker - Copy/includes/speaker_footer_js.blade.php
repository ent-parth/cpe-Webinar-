
<!-- AdminLTE App -->

<!-- ChartJS -->
<!-- <script src="bower_components/chart.js/Chart.js"></script>
 --><!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard2.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- Core JS files -->
{!! HTML::script('js/jquery.min.js') !!}
{!! HTML::script('js/plugins/bootstrap/dist/js/bootstrap.min.js') !!}
{!! HTML::script('js/plugins/datatables.net/js/jquery.dataTables.min.js') !!}
{!! HTML::script('js/adminlte.min.js') !!}
{!! HTML::script('js/plugins/notifications/pnotify.min.js') !!}

@yield('js')
<script>

    @if (Session::has('success'))
    new PNotify({
        text: "{{ Session::get('success') }}",
        type: 'success',
        addclass: 'bg-success border-success'
    });
    @endif
    @if (Session::has('error'))
    new PNotify({
        text: "{{ Session::get('error') }}",
        type: 'danger',
        addclass: 'alert bg-danger border-danger alert-styled-right',
    });
    @endif
    @if($errors->has('active'))
        new PNotify({
        text: "{{ $errors->first('active') }}",
                type: 'danger',
                addclass: 'alert bg-danger border-danger alert-styled-right',
        });
    @endif

</script>

<script type="text/javascript">
    
    var dropzone_store_path  = "<?php echo config('constants.DROPZONE.FILES_STORE_PATH') ?>";
    var app_site_url  = "<?php echo env('APP_URL').'/' ?>";


    jQuery(document).ready(function () {
    $(".languages").click(function () {
        $('.languages').removeClass('active');
        $('.select-language').remove();
        var language = $(this).attr("data-id");
        var url = $(this).attr("href");
        $(this).addClass('active');
        $(this).attr("data-toggle", "dropdown");
        $(this).clone().addClass('navbar-nav-link dropdown-toggle select-language').removeClass('dropdown-item languages arabic active').appendTo(".active-language");
        redirect(url)
    });
    checkLanguage();
    function checkLanguage() {
        var oldLanguage = '<?php echo !empty(Illuminate\Support\Facades\Auth::guard('administrator')->user()->language_translation) ? Illuminate\Support\Facades\Auth::guard('administrator')->user()->language_translation : 'en'; ?>';
        $('.languages').each(function () {
            var language = $(this).data('id');
            if (language == oldLanguage) {
                $(this).addClass('active');
                $(this).attr("data-toggle", "dropdown");
                $(this).clone().addClass('navbar-nav-link dropdown-toggle select-language').removeClass('dropdown-item languages arabic active').appendTo(".active-language");
            }
        });
    }
    function redirect(url) {
        window.location.href = url;
        }
    }
    );
</script>




