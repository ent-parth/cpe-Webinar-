@extends('backEnd.layouts.admin_app')
@section('content') 
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Webinar Attendies</h3>
          <div class="action pull-right"> 
         </div>
        </div>
        <div class="box-body">
          <table id="webinar-list" class="table table-bordered table-hover datatable-highlight">
            <thead>
              <tr class="heading">
                <?php /*?><th class="listing-id"><input type="checkbox" id="check-all" name="check-all"></th><?php */?>
                <th width="5%">#</th>
                <th width="15%">Attendee name</th>
                <th width="10%"> Attendee email </th>
                <th width="10%"> Webinar name </th>
                <th width="10%">Webinar type</th>
                <th width="10%">Webinar Fee</th>
                <th width="10%">Webinar Date in UTC</th>
                <th width="10%">Registered date</th>
                <th width="10%">Join link </th>
                <th width="10%">Payment Status</th>
                <?php /*?><th width="20%"> Rgistration Status </th><?php */?>
                <th class="listing-action">Action</th>
              </tr>
            </thead>
            <tfoot>
            <form name="Filter" id="Filter" action="" method="get" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <tr class="filter">
                <td></td>
                <td><input type="text" class="form-control form-filter input-sm" name="name" id="name" value="@if(isset($_REQUEST['name']) && !empty($_REQUEST['name'])){{$_REQUEST['name']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" name="email" id="email" value="@if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){{$_REQUEST['email']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" name="title" id="title" value="@if(isset($_REQUEST['title']) && !empty($_REQUEST['title'])){{$_REQUEST['title']}}@endif"></td>
                <td><select name="webinar_type" id="webinar_type" class="form-control">
                    <option value="">All</option>
                    <option @if(isset($_REQUEST['webinar_type']) && $_REQUEST['webinar_type'] == 'self_study') selected="selected" @endif value="self_study" >
                    Self Study
                    </option>
                    <option @if(isset($_REQUEST['webinar_type']) && $_REQUEST['webinar_type'] == 'live') selected="selected" @endif value="live">
                    Live
                    </option>
                    <option @if(isset($_REQUEST['webinar_type']) && $_REQUEST['webinar_type'] == 'archived') selected="selected" @endif value="archived">
                    Archived
                    </option>
                  </select></td>
                <td></td>
                <td><input type="text" class="form-control form-filter input-sm" autocomplete="off" name="recorded_date" id="recorded_date" value="@if(isset($_REQUEST['recorded_date']) && !empty($_REQUEST['recorded_date'])){{$_REQUEST['recorded_date']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" autocomplete="off" name="created_at" id="created_at" value="@if(isset($_REQUEST['created_at']) && !empty($_REQUEST['created_at'])){{$_REQUEST['created_at']}}@endif"></td>
                <td></td>
                <td></td>
                <?php /*?><td>{{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search form-filter-dropdown', 'select'=>'select']) }}</td><?php */?>
                <td><button class="btn btn-sm btn-default filter-submit" type="submit" title="Search"><i class="fa fa-search"></i> Search</button>
                  <a href="/webinar-user-register" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Reset</a></td>
              </tr>
            </form>
            @include('backEnd/webinar-user-register/index-ajax')
              </tfoot>
            
            <tbody>
            </tbody>
          </table>
          <div class="pull-right">@if($WebinarUserRegister->total() > env('PAGINATION'))
          	{{$WebinarUserRegister->links()}}
          @else
          	 <ul class="pagination">
             	<li class="disabled"><span>←</span></li><li class="active"><span>1</span></li><li class="disabled"><span>→</span></li>
            </ul>
          @endif</div>
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
			minView:"month",
			autoclose: true
		});
		
	});
	$(function() {
		$('#created_at').datetimepicker({
			format: 'yyyy-mm-dd',
			minView:"month",
			autoclose: true
		});
		
	});
</script> 
@endSection 