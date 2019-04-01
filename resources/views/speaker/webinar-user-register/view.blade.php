@extends('backEnd.layouts.admin_app')
@section('content')
<section class="content">
  
  
  <!-- general form elements -->
  <div class="box box-primary"> 
    <!-- /.box-header --> 
    <!-- form start -->
      <section class="content-header">
  <h1>User Details <span class="pull-right small"><a href="{{route('users')}}{{(Request::getQueryString() ? ('?' .  Request::getQueryString()) : '')}}"><b>List view</b></a></span></h1>
</section>
<section class="content-header">

</section>
     
      @if($Users_view->status !=1)
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Name : </label>
              {{$Users_view->first_name}} {{$Users_view->last_name}}</div>
          </div>
        
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> email : </label>
              {{$Users_view->email }} </div>
          </div>
        
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label"> Conatct No : </label>
              {{$Users_view->contact_no }} </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Company Name : </label>
              {{$Users_view->firm_name }} </div>
          </div>
         
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Status :</label>
             @if($Users_view->status == 'active') Active @else Inactive  @endif	</div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Topic Of Interest :</label>
              @php $interest = ''; @endphp
               @foreach($tag_query as $tq)
               		@php
                    	$interest .= $tq->tag.', ';
                    @endphp
               @endforeach
               {{rtrim($interest,', ')}}
            	</div>
          </div>
          
          <div class="col-md-6"> 
            <div class="form-group">
              <label class="control-label">Created At : </label>
              {{ date("F j Y",strtotime($Users_view->created_at))  }} </div>
          </div>
          
          
       
        </div>
      </div>
      <!-- /.box-body --> 
      
      @endif </div>
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
{{ HTML::script('js/plugins/validation/validate.min.js') }}

  

@endSection 