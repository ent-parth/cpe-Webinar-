@extends('backEnd.layouts.app')

@section('content')

<section class="content-header">
    <h1>{{ $administrator->full_name }} <small>View Details</small> </h1>    
    {!! Breadcrumbs::render('administrators-view') !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @php
                    $avatar = !empty($administrator->avatar) && file_exists(config('app.ADMIN_CONST.ADMIN_IMAGE_PATH') . $administrator->avatar) ? config('app.ADMIN_CONST.ADMIN_IMAGE_URL') . $administrator->avatar : config('app.ADMIN_CONST.DEFAULT_IMAGE_URL')
                    @endphp
                    <img class="profile-user-img img-responsive img-circle" src="{{ $avatar }}" alt="User profile picture">
                    <h3 class="profile-username text-center">{{ $administrator->full_name }}</h3>
                    <p class="text-muted text-center">{{ $administrator->role->name }}</p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#personalInfo" data-toggle="tab">Personal Info</a></li>
                    <li class="edit-icon-info">
                        <?php
                        echo ((\App\Helpers\RolePermissionHelper::hasAccess('edit-administrator')) ? '<a href="' . route('administrators-edit', ['domain' => config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME'), $administrator->id]) . '" title="Edit administrator "><i class="fa fa-edit"></i></a>' : '');
                        ?>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="personalInfo">
                        {!! Form::open(['name' => 'view-admin-form', 'id' => 'view-admin-form', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            {{ Form::label('Name', 'Name', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
                                <span class="info-box-user">{{ $administrator->full_name }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Username', 'Username', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
                                <span class="info-box-user">{{ $administrator->username }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Email', 'Email', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
                                <span class="info-box-user">{{ $administrator->email }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('role', 'Role', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
                                <span class="info-box-user">{{ $administrator->role->name }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('status', 'Status', ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
                                <span class="info-box-user">{{ $statusList[$administrator->status] }}</span>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if (\App\Helpers\RolePermissionHelper::hasAccess('administrators-listing')) 
                            <a href="{{ route('administrators',['domain'=>config('app.ADMIN_CONST.ADMIN_DOMAIN_NAME')]) }}" class="btn btn-default pull-right margin-r-5" title="Back"><i class="fa fa-mail-reply"></i> Back </a>
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>    
</section>

@endSection