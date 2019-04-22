@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Add Warehouse
                <small>Add Warehouse...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i
                                class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{ URL::to('admin/warehouse')}}"><i
                                class="fa fa-dashboard"></i>  List All Manufacturer </a></li>
                <li class="active">Add Warehouse</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add New Warehouse </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <br>
                                        @if (count($errors) > 0)
                                            @if($errors->any())
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    {{$errors->first()}}
                                                </div>
                                        @endif
                                    @endif
                                    <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            <form action="{{ url('admin/insert_warehouse') }}" method="post"
                                                  class="form-horizontal form-validate"
                                                  id="insert_store">

                                            <div class="form-group">
                                                <label for="name"
                                                       class="col-sm-2 col-md-3 control-label">Warehouse Name</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="text" name="name" id="name" autocomplete="off"
                                                           class="form-control field-validate"
                                                           placeholder="Enter Name"
                                                    maxlength="50">
                                                    <span class="help-block"
                                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        Warehouse such as "Samsung or iphone" etc.</span>
                                                    <span class="help-block hidden">Warehouse Name is mandaotry</span>
                                                </div>
                                            </div>
                                                <div class="form-group">
                                                    <label for="location"
                                                           class="col-sm-2 col-md-3 control-label">Location</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="location" id="location" autocomplete="off"
                                                               class="form-control field-validate"
                                                               placeholder="Enter Location"
                                                        maxlength="100">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        Location such as Area/Street/City/State (Pincode)</span>
                                                        <span class="help-block hidden">Warehouse Name is mandaotry</span>
                                                    </div>
                                                </div>
                                            <div class="form-group">
                                                <label for="username"
                                                       class="col-sm-2 col-md-3 control-label">Username</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="email" name="username" id="username" autocomplete="off"
                                                           class="form-control field-validate"
                                                           placeholder="Enter Username">
                                                    <span class="help-block"
                                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        Username such as ashu@7eye.com etc.</span>
                                                    <span class="help-block hidden">Username is mandaotry</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password"
                                                       class="col-sm-2 col-md-3 control-label">Create Password</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="password" name="password" id="password" autocomplete="off"
                                                           class="form-control field-validate"
                                                           placeholder="Enter Name"
                                                    minlength="6"
                                                    maxlength="16">
                                                    <span class="help-block"
                                                          style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        Your password must be at least 8 characters in length and contain an uppercase letter, a lower case letter, at least one number and one special character (i.e. !, $, #, *) </span>
                                                    <span class="help-block hidden">Warehouse Name is mandaotry</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit"
                                                        class="btn btn-primary">Add Warehouse</button>
                                                <a href="{{ URL::to('admin/manufacturers')}}" type="button"
                                                   class="btn btn-default">Back</a>
                                            </div>
                                            <!-- /.box-footer -->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection 