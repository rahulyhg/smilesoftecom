@extends('warehouse.warehouse_master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Add Staff Member
                <small>Add Staff Member...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('warehouse_dashboard') }}"><i
                                class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ url('warehouse_staff') }}"><i class="fa fa-dashboard"></i> List All Staff Members</a>
                </li>
                <li class="active">Add Staff Member</li>
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
                            <h3 class="box-title">Add New Staff Member </h3>
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
                                            <form action="insert_staff" method="post"
                                                  enctype="multipart/form-data"
                                                  class="form-horizontal form-validate">

                                                <input type="hidden" name="warehouse_id" id="warehouse_id" value="{{session('warehouse')->id}}">

                                                <div class="form-group">
                                                    <label for="name"
                                                           class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }}</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text"
                                                               class='form-control  field-validate'
                                                               name="name"
                                                               id="name">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Staff such as "Ashish Patel" etc.</span>
                                                        <span class="help-block hidden">This field is required.</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="contact"
                                                           class="col-sm-2 col-md-3 control-label">Mobile Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="tel"
                                                               class='form-control  field-validate'
                                                               name="contact"
                                                               id="contact"
                                                        minlength="10"
                                                        maxlength="10">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Contact such as "9981435702" etc.</span>
                                                        <span class="help-block hidden">This field is required.</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="username"
                                                           class="col-sm-2 col-md-3 control-label">Create Username</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="email"
                                                               class='form-control  field-validate'
                                                               name="username"
                                                               id="username">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Username such as "staff@warehouse.com" etc.</span>
                                                        <span class="help-block hidden">This field is required.</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password"
                                                           class="col-sm-2 col-md-3 control-label">Password</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="password"
                                                               class='form-control  field-validate'
                                                               name="password"
                                                               id="password">
                                                        <span class="help-block"
                                                              style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Your password must be at least 8 characters in length and contain an uppercase letter, a lower case letter, at least one number and one special character (i.e. !, $, #, *)</span>
                                                        <span class="help-block hidden">This field is required.</span>
                                                    </div>
                                                </div>

                                                <!-- /.box-body -->
                                                <div class="box-footer text-center">
                                                    <button type="submit"
                                                            class="btn btn-primary">Add Staff Member</button>
                                                    <a href="{{ URL::to('admin/manufacturers')}}" type="button"
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
    <script>
        $("#username").focusout(function () {
                    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    var email = $('#username').val();
                    if (reg.test(email) == false)
                    {
                        alert('Staff member has invalid username');
                        $('#username').val('');
                        return false;
                    }
                    return true;
                }
        );
    </script>
@endsection 