@extends('backEnd.layouts.admin_app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        {!! Breadcrumbs::render('Permissions') !!}


    </div>


    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Highlighting rows and columns -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Administrators</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a href="{{ route('create.permission') }}" id="add-role" class="btn bg-teal-400 btn-labeled btn-labeled-left btn-sm" title="Add Administrator">
                            <b><i class="icon-reading"></i></b> Add
                        </a>
                    </div>
                </div>
            </div>
            <table id="administrator-list" class="table table-bordered table-hover datatable-highlight">
                <thead>
                <tr class="heading">
                    <th class="listing-id">#</th>
                    <th width="20%">Parent Id</th>
                    <th width="20%">Title</th>
                    <th width="20%">Permisssion Key</th>
                    <th width="15%">Status</th>
                    <th class="listing-action">Action</th>
                </tr>
                <tfoot>
                <tr class="filter">
                    <td></td>
                    <td></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="title" id="title"></td>
                    <td><input type="text" class="form-control form-filter input-sm" name="permission_key" id="permission_key"></td>
                    <td></td>
                    <td>
                        <button class="btn btn-outline-success filter-submit search-button-main" title="Search"><i class="fa fa-search"></i> <?= __(''); ?></button>
                        <button class="btn btn-outline-danger filter-cancel close-button-main" title="Reset"><i class="fa fa-times"></i> <?= __(''); ?></button>
                    </td>
                </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>



        </div>
        <!-- /highlighting rows and columns -->
    </div>

    <!-- /content area -->
    <style>
        .datatable-highlight tfoot {
            display: table-header-group;
        }
    </style>
@endsection

@section('js')
    {{ Html::script('/js/permission.js') }}
    {{ Html::script('/js/plugins/tables/datatables/datatables.min.js') }}
    {{ Html::script('/js/plugins/forms/selects/select2.min.js') }}
    {{ Html::script('/js/form_select2.js') }}
    {{ Html::script('/js/interactions.min.js') }}
@endSection

