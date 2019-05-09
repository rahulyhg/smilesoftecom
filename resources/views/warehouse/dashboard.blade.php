@extends('warehouse.warehouse_master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ trans('labels.title_dashboard') }}
                <small>{{ trans('labels.title_dashboard') }} 1.1</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</li>
            </ol>
        </section>

        @php
            $products = DB::table('products')
              ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
              ->where('products_description.language_id', '=', 1)
              ->orderBy('products.products_id', 'DESC')
              ->get();

        $customers = DB::table('customers')
            ->LeftJoin('customers_info', 'customers_info.customers_info_id', '=', 'customers.customers_id')
            ->orderBy('customers_info.customers_info_date_account_created', 'DESC')
            ->get();
        @endphp

        <!-- Main content -->
        <section class="content">
            <div class="row" style="display: none">
                <div class="col-md-12">
                    <div class="box box-default">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-info"></i> Version Info!</h4>
                                You are using the latest <strong>version </strong> of our <strong>Ecommerce
                                    Solution</strong>.<br>
                                This latest version is came up with both <strong>Ecommerce Desktop</strong> and <strong>Application</strong><br>
                                Our old version is not compatible with <strong>Desktop Version</strong>.<br>
                                If you want to choose our <strong>Ecommerce Desktop System</strong> as well. Please
                                <strong>upgrade</strong> your all CMS to our latest <strong>version 3.0</strong>.
                                If you have purchased CMS with <strong>Desktop System package</strong> and want to buy
                                <strong>Application Package</strong>. Please purchase our <strong>CMS and Application
                                    services</strong> and enable these feture from <strong>Admin Panel</strong>.<br>
                                If you have purchased CMS with Application System package and want to buy Desktop
                                Package. Please purchase our <strong>CMS and Desktop services</strong> and enable these
                                feture from <strong>Admin Panel</strong>.<br>
                                Just put your files into your existing system and enjoy with our <strong>Ecommerce
                                    Solution.</strong>.<br>
                                <strong>Now feel free to use!</strong>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3></h3>
                            <p>New Staff</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{url('warehouse_staff')}}" class="small-box-footer" data-toggle="tooltip"
                           data-placement="bottom"
                           title="View All Staff Members">View All Staff Members <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-light-blue">
                        <div class="inner">
                            <h3></h3>
                            <p>Profits</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ URL::to('admin/products')}}" class="small-box-footer" data-toggle="tooltip"
                           data-placement="bottom"
                           title="{{ trans('labels.viewAllProducts') }}">{{ trans('labels.viewAllProducts') }} <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3></h3>
                            <p>Total Money Earned</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ URL::to('orders')}}" class="small-box-footer" data-toggle="tooltip"
                           data-placement="bottom"
                           title="{{ trans('labels.viewAllOrders') }}">{{ trans('labels.viewAllOrders') }} <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">

                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{count($products)}} </h3>
                            <p>Out of Stock</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ URL::to('#')}}" class="small-box-footer" data-toggle="tooltip"
                           data-placement="bottom"
                           title="{{ trans('labels.outOfStock') }}">{{ trans('labels.outOfStock') }} <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{count($customers)}}</h3>

                            <p>{{ trans('labels.customerRegistrations') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ URL::to('admin/customers')}}" class="small-box-footer" data-toggle="tooltip"
                           data-placement="bottom"
                           title="{{ trans('labels.viewAllCustomers') }}">{{ trans('labels.viewAllCustomers') }} <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{count($products)}}</h3>

                            <p>Total Product</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ URL::to('products')}}" class="small-box-footer" data-toggle="tooltip"
                           data-placement="bottom"
                           title="{{ trans('labels.viewAllProducts') }}">{{ trans('labels.viewAllProducts') }} <i
                                    class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

            </div>

        </section>
    </div>

    <script src="{!! asset('resources/views/admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>

    <script src="{!! asset('resources/views/admin/dist/js/pages/dashboard2.js') !!}"></script>
@endsection