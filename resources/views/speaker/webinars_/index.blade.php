@extends('speaker.layouts.speaker_app')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Webinars</h3>
                    <a href="{{ route('speaker.create.webinar') }}" class="btn btn-primary pull-right" title="Add Webinars">
                        <b><i class="fa fa-plus-circle"></i></b> Add Webinars
                    </a>
                </div>
                <div class="box-body">
                    <table id="role-list" class="table table-bordered table-hover datatable-highlight">
                        <thead>
                            <tr class="heading">
                                <th class="listing-id">#</th>
                                <th width="20%">Name</th>
                                <th width="10%">Type</th>
                                <th width="10%">Date</th>
                                <th width="10%">Metting Code</th>
                                <th width="15%">Status</th>
                                <th class="listing-action">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="filter">
                                <td></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="name" id="name"></td>
                                <td>
                                   <!--  {{ Form::select('webinar_type',[
                                    config('constants.WEBINAR_TYPE.LIVE')=>config('constants.WEBINAR_TYPE.LIVE'),
                                    config('constants.WEBINAR_TYPE.SELF_STUDY')=>config('constants.WEBINAR_TYPE.SELF_STUDY')], null, ["id" => "webinar_type", "placeholder" => "Select Webinar Type", 'class' => 'form-control select2 select-search form-filter-dropdown']) }} -->

                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    {{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search form-filter-dropdown']) }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-default filter-submit" title="Search"><i class="fa fa-search"></i> <?= __('Search'); ?></button>
                                    <button class="btn btn-sm btn-default filter-cancel" title="Reset"><i class="fa fa-times"></i> <?= __('Reset'); ?></button>
                                </td>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /content area -->
<style>
    .datatable-highlight tfoot {
        display: table-header-group;
    }
</style>
@endsection
@section('css')
{{ HTML::style('/css/custom.css') }}
@endSection

@section('js')
{{ Html::script('/js/datatables/speaker_webinars.js') }}
{{ Html::script('/js/plugins/tables/datatables/datatables.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
@endSection

