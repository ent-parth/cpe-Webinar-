@extends('backEnd.layouts.admin_app')

<?php /* @section('content')
    <div class="content-wrapper">
        <div class="page-header page-header-light">
            {!! Breadcrumbs::render('dashboard') !!}
        </div>
        <div class="content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        @permission('manage-dashboard')
                        <div class="col-lg-4">
                            <a href="{{ route('companies') }}">
                            <div class="card bg-teal-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">{{ $companyCount ?? ''}}</h3>
                                    </div>
                                    <div>{{ __('messages.total_companies')}}</div>
                                </div>
                                <div id="members-online">
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ route('drivers') }}">
                            <div class="card bg-blue-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">{{ $driverCount ?? ''}}</h3>
                                    </div>
                                    <div>
                                        <div>{{ __('messages.total_drivers')}}</div>
                                    </div>
                                </div>
                                <div id="today-revenue">
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ route('customers') }}">
                                <div class="card bg-pink-400">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <h3 class="font-weight-semibold mb-0">{{ $customerCount ?? ''}}</h3>
                                        </div>
                                        <div>{{ __('messages.total_customers')}}</div>
                                    </div>
                                    <div id="server-load"></div>
                                </div>
                            </a>
                        </div>
                        @endpermission
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {!! HTML::script('js/dashboard.js') !!}
    {!! HTML::script('js/plugins/forms/styling/switchery.min.js') !!}
    {!! HTML::script('js/plugins/pickers/daterangepicker.js') !!}
    {!! HTML::script('js/plugins/ui/moment/moment.min.js') !!}
    {!! HTML::script('js/plugins/visualization/d3/d3.min.js') !!}
    {!! HTML::script('js/plugins/visualization/d3/d3_tooltip.js') !!}
@endsection */ ?>