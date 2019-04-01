@extends('speaker.layouts.speaker_app')
@section('content') 
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Webinar Invitation</h3>
        </div>
        <div class="box-body">
          <table id="webinar-list" class="table table-bordered table-hover datatable-highlight">
            <thead>
              <tr class="heading">
                <th width="20%">Name</th>
                <th width="10%">Date</th>
                <th width="10%">Time in UTC</th>
                <th width="15%">Invitation Status</th>
                <th width="10%">Link</th>
                <th class="listing-action">Action</th>
              </tr>
            </thead>
            <tfoot>
            <form name="Filter" id="Filter" action="" method="get" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <tr class="filter">
                <td><input type="text" class="form-control form-filter input-sm" name="title" id="title" value="@if(isset($_REQUEST['title']) && !empty($_REQUEST['title'])){{$_REQUEST['title']}}@endif"></td>
                <td><input type="text" class="form-control form-filter input-sm" name="recorded_date" id="recorded_date" value="@if(isset($_REQUEST['recorded_date']) && !empty($_REQUEST['recorded_date'])){{$_REQUEST['recorded_date']}}@endif" autocomplete="off"></td>
                <td></td>
                <td><select name="status" id="status" class="form-control select2 select-search form-filter-dropdown" >
                    <option value="">Select Status</option>
                    <option value="accepted" @if(isset($_REQUEST['status'])  && $_REQUEST['status'] == 'accepted') selected @endif>
                    
                    Accepted
                    
                    </option>
                    <option value="rejected" @if(isset($_REQUEST['status'])  && $_REQUEST['status'] == 'rejected') selected @endif>
                    
                    Rejected
                    
                    </option>
                    <option value="pending" @if(isset($_REQUEST['status'])  && $_REQUEST['status'] == 'pending') selected @endif>
                    
                    Pending
                    
                    </option>
                  </select></td>
                <td></td>
                <td><button class="btn btn-sm btn-default filter-submit" type="submit" title="Search"><i class="fa fa-search"></i> Search</button>
                  <a href="/webinar-invitation" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Reset</a></td>
              </tr>
            </form>
            @include('speaker/webinar-invitation/index-ajax')
              </tfoot>
            
            <tbody>
            </tbody>
          </table>
          <div class="pull-right"> @if($webinarInvitation->total() > env('PAGINATION'))
            {{$webinarInvitation->links()}}
            @else
            <ul class="pagination">
              <li class="disabled"><span>←</span></li>
              <li class="active"><span>1</span></li>
              <li class="disabled"><span>→</span></li>
            </ul>
            @endif </div>
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
	

</script> 
@endSection 