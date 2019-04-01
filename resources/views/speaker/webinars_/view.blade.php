@extends('backEnd.layouts.admin_app')

@section('content')
<section class="content-header">
  <h1>
    View Webinar Detail
  </h1>
</section>
<!-- Breadcrumbs -->
<!-- Content area -->
<div class="content">    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <legend class="font-weight-semibold">
                        <h3>{{ $webinar->name ?? ''}} <small><?= __(' view'); ?></small> </h3>
                    </legend>                    
                </div>

                <div class="card-body border-top-0">
                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Name:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">{{$webinar->name}}</div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Type:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">{{$webinar->webinar_type}}</div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Date:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">{{$webinar->date}}</div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Time:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">{{$webinar->time}}</div>
                    </div>


                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Description:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">{!! $webinar->description !!}</div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Faq:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">{!! $webinar->faq !!}</div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">CPE Credit:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">{!! $webinar->cpe_credit !!}</div>
                    </div>

                    <div class="d-sm-flex flex-sm-wrap mb-3">
                        <div class="font-weight-semibold">Status:</div>
                        <div class="ml-sm-auto mt-2 mt-sm-0">{{$webinar->status}}</div>
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

