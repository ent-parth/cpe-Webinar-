@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content">
  <div class="row">
  <div class="col-md-12">
  <!-- general form elements -->
  <div class="box box-primary"> 
    <!-- /.box-header --> 
    <!-- form start -->
    
    <div class="box-body">
      <div class="box-header">
        <h3 class="box-title">Speaker Invitation for Webinar </h3>
      </div>
      <form id="speaker_invitation_update" name="speaker_invitation_update" action="{{route('speaker.webinar.speaker_invitation_update')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="uri" value="{{Request::getQueryString() ? Request::getQueryString() : ''}}"  />
        <input type="hidden" name="webinar_id" value="{{$webinar_id}}">
        <div class="row">
        <div class="col-md-12"> @foreach($Invitation as $speaker)
          <div class="col-md-3">
            <div class="form-group">
              <p><b>{{$speaker['first_name'].' '.$speaker['last_name']}}</b></p>
              <small>{{$speaker['email']}}</small> <br/>
              <input type="checkbox" name="invitation[]" value="{{$speaker['id']}}" @if($speaker['speaker_invited'] == 'yes') checked disabled @endif>
            </div>
          </div>
          @endforeach
          <div class="box-footer">
            <div class="col-md-12 text-right"> <a href="{{ route('speaker.webinar') }}" class="btn btn-danger" title="Cancel"> Cancel </a>
              <input type="submit" class="btn btn-primary ml-3" value="Save">
            </div>
          </div>
        </div>
      </form>
      <!-- /.box-body --> 
    </div>
    <!-- /.box --> 
  </div>
</section>
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

{{ Html::script('/js/plugins/tables/datatables/datatables.min.js') }}
{{ HTML::script('/js/plugins/select2/dist/js/select2.full.min.js') }}
@endSection 