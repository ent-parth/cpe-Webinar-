@extends('backEnd.layouts.admin_app')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Course</h3>
                    <div class="action pull-right">
                        <a href="javascript:void(0);" id="add-course" class="btn btn-primary" data-url="{{ route('create.course') }}" title="Add Course" data-toggle="modal" data-target="#modal-default">
                            <b><i class="fa fa-plus-circle"></i></b> Add Course
                        </a>
                        <a href="{{ route('delete-all.course') }}" class="btn btn-danger delete-all" title="Delete All">Delete All</a>
                    </div>
                </div>
                <div class="box-body">
                    <table id="course-list" class="table table-bordered table-hover datatable-highlight">
                        <thead>
                            <tr class="heading">
                                <th class="listing-id"><input type="checkbox" id="check-all" name="check-all"></th>
                                <th width="25%">Course Level</th>
                                <th width="25%">Name</th>
                                <th width="25%">status</th>
                                <th class="listing-action">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="filter">
                                <td></td>
                                <td>
                                    {{ Form::select('course_level_id', $courseLevelList, null, ["id" => "course_level_id", "placeholder" => "Select Course Level", 'class' => 'form-control select2 select-search']) }}
                                </td>
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
<div class="modal fade" id="add-course-modal"></div>
<style>
    .datatable-highlight tfoot {
        display: table-header-group;
    }
</style>
@endsection
@section('js') 
{{ HTML::script('/js/datatables/course.js') }} 
{{ HTML::script('/js/plugins/tables/datatables/datatables.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
@endSection

