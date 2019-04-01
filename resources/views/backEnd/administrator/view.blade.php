@extends('backEnd.layouts.admin_app')

@section('content')
<!-- Breadcrumbs -->
<div class="page-header page-header-light">
    {!! Breadcrumbs::render('AdministratorsView') !!}
</div>
<!-- Breadcrumbs -->
<!-- Content area -->
<div class="content">    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <legend class="font-weight-semibold">
                        <h3>{{ $administrator->full_name ?? ''}} <small><?= __(' view'); ?></small> </h3>
                    </legend>                    
                </div>
                <div class="card-body bg-blue text-center card-img-top" style="background-image: url(http://demo.interface.club/limitless/assets/images/bg.png); background-size: contain;">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img class="img-fluid rounded-circle" src="{{asset($administrator->avatar_url)}}" width="170" height="170" alt="">
                        <div class="card-img-actions-overlay card-img rounded-circle">
                            <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
                                <i class="icon-plus3"></i>
                            </a>
                            <a href="user_pages_profile.html" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                <i class="icon-link"></i>
                            </a>
                        </div>
                    </div>

                    <h6 class="font-weight-semibold mb-0">Victoria Davidson</h6>
                    <span class="d-block opacity-75">Head of UX</span>

                    
                </div>

                <div class="card-body border-top-0">
                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Full name:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">Victoria Anna Davidson</div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Phone number:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">+3630 8911837</div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Corporate Email:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0"><a href="#">corporate@domain.com</a></div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap">
                        <div class="font-weight-semibold">Personal Email:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0"><a href="#">personal@domain.com</a></div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection

@section('js')
{!! HTML::script('js/plugins/forms/styling/switch.min.js') !!}
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('input[name="my-checkbox"]').bootstrapSwitch();
        $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function (event, state) {
            var data = {'id': $(this).attr('data-id'), 'status': state}
            var id = parseInt(data.id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                url: '/administrators/status/' + id,
                success: function (resp) {
                    if (resp == 'true') {
                        new PNotify({
                            text: "<?= __('messages.administrator_status_update_success_message') ?>",
                            type: 'success',
                            addclass: 'bg-success border-success'
                        });
                    } else {
                        new PNotify({
                            text: "<?= __('messages.administrator_status_update_error_message') ?>",
                            type: 'danger',
                            addclass: 'alert bg-danger border-danger alert-styled-right'
                        });
                    }
                },
                error: function (resp) {
                    console.log(resp);
                }
            });
        });
    });
</script>
@endSection

