@extends('speaker.layouts.speaker_app')
@section('content') 
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"> Webinar Questions </h3>
          <a href="{{ route('speaker.webinar-questions.create') }}" class="btn btn-primary pull-right" title="Add webinar-questions"> <b><i class="fa fa-plus-circle"></i></b> Add Webinar Questions </a> </div>
        <div class="box-body">
          <table id="webinar-list" class="table table-bordered table-hover datatable-highlight">
            <thead>
              <tr class="heading">
                <th class="listing-id">#</th>
                <th width="20%">Question </th>
                <th width="10%">Webinar</th>
                <th width="10%">Type</th>
                <th width="15%">Status</th>
                <th class="listing-action">Action</th>
              </tr>
            </thead>
            <tfoot>
            <form name="Filter" id="Filter" action="" method="get" >
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <tr class="filter">
                <td></td>
                <td><input type="text" class="form-control form-filter input-sm" name="question" id="question" value="@if(isset($_REQUEST['question']) && !empty($_REQUEST['question'])){{$_REQUEST['question']}}@endif" placeholder="Serch With Question"></td>
                <td><input type="text" class="form-control form-filter input-sm" name="webinar_id" id="webinar_id" value="@if(isset($_REQUEST['webinar_id']) && !empty($_REQUEST['webinar_id'])){{$_REQUEST['webinar_id']}}@endif" placeholder="Serch With Webinar"></td>
                <td><select name="type" id="type" class="form-control" >
                    <option value="">Select Type </option>
                    <option value="review" @if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'review') selected="selected" @endif>
                    Review
                    </option>
                    <option value="final" @if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'final') selected="selected" @endif>
                    Final
                    </option>
                  </select></td>
                <td> {{ Form::select('status', $statusList, null, ["id" => "status", "placeholder" => "Select Status", 'class' => 'form-control select2 select-search form-filter-dropdown', 'select'=>'select']) }} </td>
                <td><button class="btn btn-sm btn-default filter-submit" type="submit" title="Search"><i class="fa fa-search"></i> Search</button>
                  <a href="/webinar-questions" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Reset</a></td>
              </tr>
            </form>
            @include('speaker/webinar_questions/index-ajax')
              </tfoot>
            
            <tbody>
            </tbody>
          </table>
          <div class="pull-right">{{$WebinarQuestions->links()}}</div>
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
{{ HTML::script('/js/custom.js') }}
@endSection 