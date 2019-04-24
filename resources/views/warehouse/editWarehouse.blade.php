@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Warehouse
                <small>Edit Warehouse...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i
                                class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/listingManufacturer')}}"><i
                                class="fa fa-dashboard"></i> {{ trans('labels.ListAllManufacturer') }}</a></li>
                <li class="active">{{ trans('labels.EditManufacturer') }}</li>
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
                            <h3 class="box-title">Edit Warehouse </h3>
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

                                            <form action="{{ url('admin/updatewarehouse') }}" method="post"
                                                  class="form-horizontal form-validate"
                                                  id="insert_store">
                                                <input type="hidden" name="wid" id="wid" value="{{$warehouse->id}}">
                                                <div class="form-group">
                                                    <label for="name"
                                                           class="col-sm-2 col-md-3 control-label">Warehouse
                                                        Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="name" id="name" autocomplete="off"
                                                               class="form-control field-validate"
                                                               value="{{$warehouse->name}}"
                                                               placeholder="Enter Name">
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
                                                        <input type="text" name="location" id="location"
                                                               autocomplete="off"
                                                               value="{{$warehouse->location}}"
                                                               class="form-control field-validate"
                                                               placeholder="Enter Location">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        Location such as Area/Street/City/State (Pincode)</span>
                                                        <span class="help-block hidden">Warehouse Name is mandaotry</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="latitude"
                                                           class="col-sm-2 col-md-3 control-label">Latitude</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="latitude" id="latitude"
                                                               autocomplete="off"
                                                               class="form-control field-validate"
                                                               placeholder="Enter Latitude"
                                                               value="{{$warehouse->latitude}}"
                                                               maxlength="100">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        example 20.5937° N</span>
                                                        <span class="help-block hidden">Latitude of the warehouse is mandaotry</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="longitude"
                                                           class="col-sm-2 col-md-3 control-label">Longitude</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="longitude" id="longitude"
                                                               autocomplete="off"
                                                               class="form-control field-validate"
                                                               placeholder="Enter Longitude"
                                                               value="{{$warehouse->longitude}}"
                                                               maxlength="100">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        example 78.9629° E</span>
                                                        <span class="help-block hidden">Longitude of the warehouse is mandaotry</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="username"
                                                           class="col-sm-2 col-md-3 control-label">Username</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="username" id="username"
                                                               autocomplete="off"
                                                               value="{{$warehouse->username}}"
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
                                                           class="col-sm-2 col-md-3 control-label">Create
                                                        Password</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="password" id="password"
                                                               autocomplete="off"
                                                               value="{{$warehouse->password}}"
                                                               class="form-control field-validate"
                                                               placeholder="Enter Name">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        Your password must be at least 8 characters in length and contain an uppercase letter, a lower case letter, at least one number and one special character (i.e. !, $, #, *) </span>
                                                        <span class="help-block hidden">Warehouse Name is mandaotry</span>
                                                    </div>
                                                </div>

                                                <!-- /.box-body -->
                                                <div class="box-footer text-center">
                                                    <button type="submit"
                                                            class="btn btn-primary">Update Warehouse Details</button>
                                                    <a href="{{ URL::to('admin/warehouse')}}" type="button"
                                                       class="btn btn-default">{{ trans('labels.back') }}</a>
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