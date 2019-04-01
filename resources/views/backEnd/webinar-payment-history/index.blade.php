@extends('backEnd.layouts.admin_app')
@section('content') 
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Webianar Payent History</h3>
          <div class="action pull-right"> 
            <!--  <a href="{{ route('selfstudy-webinar.create') }}" class="btn btn-primary" title="Add Webinar">
                            <b><i class="fa fa-plus-circle"></i></b> Add Self Study Webinar
                        </a> -->
            <?php /*?><a href="{{ route('live-webinar.delete-all') }}" class="btn btn-danger delete-all" title="Delete All">Delete All</a><?php */?>
          </div>
        </div>
        <div class="box-body">
          <table id="webinar-list" class="table table-bordered table-hover datatable-highlight">
            <thead>
              <tr class="heading">
                <?php /*?><th class="listing-id"><input type="checkbox" id="check-all" name="check-all"></th><?php */?>
                <th width="10%">User Name</th>
                <th width="10%">User Email</th>
                <th width="15%">Webinar name</th>
                <th width="15%">Webinar Type</th>
                <th width="05%">Webinar Fee</th>
                <th width="10%">Transection Id</th>
                <th width="20%">Payment date</th>
                <th class="listing-action">Action</th>
              </tr>
            </thead>
            <tfoot>
            <form name="Filter" id="Filter" action="" method="get" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <tr class="filter">
                <td><input type="text" class="form-control form-filter input-sm" name="user_name" id="user_name" value="@if(isset($_REQUEST['user_name']) && !empty($_REQUEST['user_name'])){{$_REQUEST['user_name']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" name="email" id="email" value="@if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){{$_REQUEST['email']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" name="title" id="title" value="@if(isset($_REQUEST['title']) && !empty($_REQUEST['title'])){{$_REQUEST['title']}}@endif"></td>
                <td><select name="webinar_type" id="webinar_type" class="form-control select2 select-search form-filter-dropdown">
                    <option>Select Webinar Type</option>
                    <option value="live" @if(isset($_REQUEST['webinar_type']) && $_REQUEST['webinar_type'] == 'live')  selected @endif>
                    Live
                    </option>
                    <option value="archived" @if(isset($_REQUEST['webinar_type']) && $_REQUEST['webinar_type'] == 'archived')  selected @endif>
                    Archived
                    </option>
                    <option value="self_study" @if(isset($_REQUEST['webinar_type']) && $_REQUEST['webinar_type'] == 'self_study')  selected @endif>
                    Self Study
                    </option>
                  </select></td>
                <td></td>
                <td><input type="text" class="form-control form-filter input-sm" name="transection_id" id="transection_id" value="@if(isset($_REQUEST['transection_id']) && !empty($_REQUEST['transection_id'])){{$_REQUEST['transection_id']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" autocomplete="off" name="created_at" id="created_at" value="@if(isset($_REQUEST['created_at']) && !empty($_REQUEST['created_at'])){{$_REQUEST['created_at']}}@endif"></td>
                <td><button class="btn btn-sm btn-default filter-submit" type="submit" title="Search"><i class="fa fa-search"></i> Search</button>
                  <a href="/webinar-payment-history" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Reset</a></td>
              </tr>
            </form>
            @include('backEnd/webinar-payment-history/index-ajax')
            </tfoot>
            
            <tbody>
            </tbody>
          </table>
          <div class="pull-right">@if($webinar_user_register->total() > env('PAGINATION'))
          	{{$webinar_user_register->links()}}
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

         $('#webinar_type').select2();
		$('#created_at').datetimepicker({
			format: 'yyyy-mm-dd',
			minView:"month",
			autoclose: true
		});
		
	});
</script> 
@endSection 