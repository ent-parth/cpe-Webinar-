@extends('backEnd.layouts.admin_app')
@section('content') 
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Users </h3>
          <div class="action pull-right"> 
            <!--<a href="{{ route('series.create') }}" class="btn btn-primary" title="">
                            <b><i class="fa fa-plus-circle"></i></b>Add 
                        </a>-->
            <?php /*?><a href="{{ route('live-webinar.delete-all') }}" class="btn btn-danger delete-all" title="Delete All">Delete All</a><?php */?>
          </div>
        </div>
        <div class="box-body">
          <table id="webinar-list" class="table table-bordered table-hover datatable-highlight">
            <thead>
              <tr class="heading">
                <?php /*?><th class="listing-id"><input type="checkbox" id="check-all" name="check-all"></th><?php */?>
                <th width="20%">Name</th>
                <th width="20%"> Email </th>
                <th width="10%"> Company/Firm name </th>
                <th width="10%"> Register Date </th>
                <th width="15%">Status</th>
                <th class="listing-action">Action</th>
              </tr>
            </thead>
            <tfoot>
            <form name="Filter" id="Filter" action="" method="get" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <tr class="filter">
                <td><input type="text" class="form-control form-filter input-sm" name="name" id="name" value="@if(isset($_REQUEST['name']) && !empty($_REQUEST['name'])){{$_REQUEST['name']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" name="email" id="email" value="@if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){{$_REQUEST['email']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" name="firm_name" id="firm_name" value="@if(isset($_REQUEST['firm_name']) && !empty($_REQUEST['firm_name'])){{$_REQUEST['firm_name']}}@endif"></td>
                <td></td>
                <td>{{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search form-filter-dropdown', 'select'=>'select']) }}</td>
                <td><button class="btn btn-sm btn-default filter-submit" type="submit" title="Search"><i class="fa fa-search"></i> Search</button>
                  <a href="/users" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Reset</a></td>
              </tr>
            </form>
            @include('backEnd/users/index-ajax')
              </tfoot>
            
            <tbody>
            </tbody>
          </table>
          <div class="pull-right">{{$Users->links()}}</div>
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
{!! HTML::style('css/timepicker/timePicker.min.css') !!}
{!! HTML::style('css/datetimepicker/bootstrap-datetimepicker.css') !!} 
@endSection

@section('js')
{{ HTML::script('js/plugins/datetimepicker/bootstrap-datetimepicker.min.js?t=20130302') }}
{{ Html::script('/js/plugins/tables/datatables/datatables.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }} 
<script language="javascript" type="application/javascript">
	$(function() {
		$('#recorded_date').datetimepicker({
			format: 'yyyy-mm-dd',
			minView:"month"
		});
		
	});
</script> 
@endSection 