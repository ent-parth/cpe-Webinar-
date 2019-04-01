{!! HTML::script('js/plugins/jquery/dist/jquery.min.js') !!}
{!! HTML::script('js/plugins/bootstrap/dist/js/bootstrap.min.js') !!}
{!! HTML::script('js/plugins/iCheck/icheck.min.js') !!}
{!! HTML::script('js/plugins/notifications/pnotify.min.js') !!}
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