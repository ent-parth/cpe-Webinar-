@extends('backEnd.layouts.admin_app')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Roles</h3>
                    <a href="javascript:void(0);" id="add-role" class="btn btn-primary pull-right" data-url="{{ route('add-role') }}" title="Add Role" data-toggle="modal" data-target="#modal-default">
                        <b><i class="fa fa-plus-circle"></i></b> Add Role
                    </a>
                </div>
                <div class="box-body">
                    <table id="role-list" class="table table-bordered table-hover datatable-highlight">
                        <thead>
                            <tr class="heading">
                                <th class="listing-id">#</th>
                                <th width="50%">Name</th>
                                <th width="25%">status</th>
                                <th class="listing-action">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="filter">
                                <td></td>
                                <td><input type="text" class="form-control form-filter input-sm" name="name" id="name"></td>
                                <td>
                                    {{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search']) }}
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
<div class="modal fade" id="add-role-modal"></div>
<style>
    .datatable-highlight tfoot {
        display: table-header-group;
    }
</style>
@endsection
@section('js') 
{{ HTML::script('/js/datatables/roles.js') }} 
{{ HTML::script('/js/plugins/tables/datatables/datatables.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
@endSection

