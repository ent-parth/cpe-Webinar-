@extends('backEnd.layouts.admin_app')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Speakers</h3>
                    <div class="action pull-right">
                        <!-- <a href="{{ route('create.speaker') }}" class="btn btn-primary pull-right" title="Add Speaker">
                        <b><i class="fa fa-plus-circle"></i></b> Add Speaker
                        </a> -->
                        <a href="{{ route('delete-all.speaker') }}" class="btn btn-danger delete-all" title="Delete All">Delete All</a>
                    </div>
                </div>
                <div class="box-body">
                    <table id="role-list" class="table table-bordered table-hover datatable-highlight">
                        <thead>
                            <tr class="heading">
                                <th class="listing-id"><input type="checkbox" id="check-all" name="check-all"></th>
                                <th width="20%">Name</th>
                                <th width="20%">Email</th>
                                <th width="20%">Contact No</th>
                                <th width="15%">Status</th>
                                <th class="listing-action">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="filter">
                                <td></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="name" id="name"></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="email" id="email"></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="contact_no" id="contact_no"></td>
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
{{ Html::script('/js/datatables/speaker.js') }}
{{ Html::script('/js/plugins/tables/datatables/datatables.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
@endSection

