@extends('backEnd.layouts.admin_app')
@section('content') 
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">User Management</h3>
            <div class="action pull-right">
               <a href="new_administrator" class="btn btn-primary" title="Add New"> 
                   <b><i class="fa fa-plus-circle"></i></b> Add New 
                </a>
            </div>
        </div> 

        <div class="box-body">
            <table id="administrator-list" class="table table-bordered table-hover datatable-highlight">
                <thead>
                <tr class="heading">
                    <?php /*?><th class="listing-id"><input type="checkbox" id="check-all" name="check-all"></th><?php */?>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th> 
                    <th>Act</th> 
                    <th>Action</th>  
                </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($data as $usr){  
                        echo "<tr>";
                            echo "<td>".$usr->first_name."</td>";
                            echo "<td>".$usr->last_name."</td>";
                            echo "<td>".$usr->email."</td>";
                            echo "<td>Administrator</td>";  
                            echo "<td><a href='/new_administrator/".$usr->id."' class='btn btn-primary'><i class='fa fa-edit'></i></a>
                                <a href='/removeAdministrator/".$usr->id."' class='btn btn-primary'><i class='fa fa-remove'></i></a></td>";
                        echo "</tr>";    
                    } ?>
                </tbody>
            </table> 
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