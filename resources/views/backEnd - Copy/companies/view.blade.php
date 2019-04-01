@extends('backEnd.layouts.admin_app')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    {!! Breadcrumbs::render('CompanyView') !!}
</div>
<!-- /page header -->

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <legend class="font-weight-semibold"><h3>{{ $companies->name ?? '' }} <small><?= __(' view'); ?></small></h3></legend>
                    <div class="header-elements">
                    </div>
                </div>                
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.company_id'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companies->company_unique_id ?? '' }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.company_name'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companies->name ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.licence_no'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companies->licence_no ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.bawsala_code'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companies->bawsala_code ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.street_building_details'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companies->building_detail ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.logo'); ?>:</label>
                                <div class="col-md-9">
                                    @if($companies->logo)
                                    <label class="col-form-label text-lg-right"> <img src="{{ asset($companies->logo) ?? '' }}" height="100" width="100"/></label>
                                    @endif
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.first_name'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companyUsers->first_name ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.last_name'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companyUsers->last_name ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.gender'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right">
                                        @if($companyUsers->gender)                                        
                                        {!! ($companyUsers->gender == 1 ) ? '<span class="badge badge-success">Male</span>': '<span class="badge badge-secondary">Female</span>' !!}
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.email'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companyUsers->email ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.contact_no'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companyUsers->contact_no ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.contact_details'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right"> {{ $companyUsers->contact_detail ?? '' }}</label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.user_type'); ?>:</label>
                                <div class="col-md-9">
                                    <label class="col-form-label text-lg-right">  
                                        @if($companyUsers->user_type)
                                        {!! ($companyUsers->user_type === 1 ) ? '<span class="badge badge-success">Owner</span>': '<span class="badge bg-blue">Sub User</span>' !!}
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-md-3 col-form-label text-lg-right"><?= __('messages.status'); ?>:</label>
                                <div class="col-md-9">
                                    <div class="form-check form-check-switchery form-check-switchery-double">
                                        <label class="form-check-label">
                                            <div class="col-md-9">
                                                <?php $checked = ($companies->status == config('constants.ADMIN_CONST.STATUS_ACTIVE')) ? 'checked' : ''; ?>
                                                <input id="switch-status" type="checkbox" <?php echo $checked; ?>  class= "checkbox-switch" data-size="small" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Inactive" value="<?php echo $companies->status; ?>" name="my-checkbox" data-id="<?php echo $companies->id; ?>">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! HTML::script('js/plugins/forms/styling/switch.min.js') !!}
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('input[name="my-checkbox"]').bootstrapSwitch();
        $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function (event, state) {
            var data = {'id': $(this).attr('data-id'), 'status': state}
            var id = parseInt(data.id);
            // debugger;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: data,
                url: '/companies/status/' + id,
                success: function (resp) {
                    if (resp == 'true') {
                        new PNotify({
                            text: "<?= __('messages.company_status_update_success_message') ?>",
                            type: 'success',
                            addclass: 'bg-success border-success'
                        });
                    } else {
                        new PNotify({
                            text: "<?= __('messages.company_status_update_error_message') ?>",
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

