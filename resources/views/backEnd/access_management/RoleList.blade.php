@extends('backEnd.layouts.admin_app')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> Roles </h3>
                    <div class="action pull-right">
                        <a href="role_management" class="btn btn-primary" title="Add Company"> 
                            <b><i class="fa fa-plus-circle"></i></b> Add Role 
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <h4>Role List</h4>
                    <table id="role-list" class="table table-bordered table-hover datatable-highlight"> 
                        <thead>
                            <tr class="heading">
                                <th width="45%">Name</th>
                                <th width="30%">Status</th>
                                <th class="listing-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($paginator as $rl)
                                <tr>
                                    <td>{!! $rl->display_name; !!}</td>
                                    <td>{!! $rl->status; !!}</td>
                                    <td>
                                        <a href="role_management/{!! $rl->id; !!}" class="btn btn-primary"><span><i class="fa fa-edit"></i></span></a>
                                        <a href="remove_role/{!! $rl->id; !!}" class="btn btn-primary"><span><i class="fa fa-remove"></i></span></a>  
                                    </td>
                                </tr>  
                            @endforeach
                        </tbody> 
                    </table>
                    @if ($paginator->lastPage() > 1)
                        <ul class="pagination">
                            <!-- si la pagina actual es distinto a 1 y hay mas de 5 hojas muestro el boton de 1era hoja -->
                            <!-- if actual page is not equals 1, and there is more than 5 pages then I show first page button -->
                            @if ($paginator->currentPage() != 1 && $paginator->lastPage() >= 5)
                                <li>
                                    <a href="{{ $paginator->url($paginator->url(1)) }}" class="btn btn-warning" >
                                        <<
                                    </a>
                                </li>
                            @endif

                            <!-- si la pagina actual es distinto a 1 muestra el boton de atras -->
                            @if($paginator->currentPage() != 1)
                                <li>
                                    <a href="{{ $paginator->url($paginator->currentPage()-1) }}" class="btn btn-warning" >
                                        <
                                    </a>
                                </li>
                            @endif

                            <!-- dibuja las hojas... Tomando un rango de 5 hojas, siempre que puede muestra 2 hojas hacia atras y 2 hacia adelante -->
                            <!-- I draw the pages... I show 2 pages back and 2 pages forward -->
                            
                            <!-- si la pagina actual es distinto a la ultima muestra el boton de adelante -->
                            <!-- if actual page is not equal last page then I show the forward button-->
                            @if ($paginator->currentPage() != $paginator->lastPage())
                                <li>
                                    <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="btn btn-warning" >
                                        >
                                    </a>
                                </li>
                            @endif

                            <!-- si la pagina actual es distinto a la ultima y hay mas de 5 hojas muestra el boton de ultima hoja -->
                            <!-- if actual page is not equal last page, and there is more than 5 pages then I show last page button -->
                            @if ($paginator->currentPage() != $paginator->lastPage() && $paginator->lastPage() >= 5)
                                <li>
                                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="btn btn-warning" >
                                        >>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .datatable-highlight tfoot {
        display: table-header-group;
    }	
</style>
@endsection
@section('js') 
{{ HTML::script('/js/plugins/tables/datatables/datatables.min.js') }}
@endSection