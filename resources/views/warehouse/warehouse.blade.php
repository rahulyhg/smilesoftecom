@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Warehouse
                <small>Warehouse List...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i
                                class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Manufacturers') }}</li>
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
                            <h3 class="box-title">Listing All Warehouse's </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/addwarehouse') }}" type="button"
                                   class="btn btn-block btn-primary">Add New Warehouse</a>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Warehouse Name</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($warehouselist)>0)
                                            @foreach ($warehouselist  as $key=>$warehouselists)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $warehouselists->name }}</td>
                                                    <td>{{ $warehouselists->username }}</td>
                                                    <td>{{ $warehouselists->password }}</td>
                                                    <td>{{ $warehouselists->location }}</td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="View Stocks"
                                                           href="{{ url('admin/ViewStock').'/'.$warehouselists->id  }}"
                                                           class="badge bg-light-green"><i class="fa fa-eye"
                                                                                           aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                           href="editWarehouse/{{ $warehouselists->id }}"
                                                           class="badge bg-light-blue"><i class="fa fa-pencil-square-o"
                                                                                          aria-hidden="true"></i></a>

                                                        <a id="manufacturerFrom"
                                                           warehouse_id='{{ $warehouselists->id }}'
                                                           data-toggle="tooltip" data-placement="bottom" title="Delete"
                                                           href="#" class="badge bg-red"><i class="fa fa-trash"
                                                                                            aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
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

            <!-- deleteManufacturerModal -->
            <div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog"
                 aria-labelledby="deleteManufacturerModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"
                                id="deleteManufacturerModalLabel">Delete Warehouse</h4>
                        </div>
                        <form action="{{url('admin/deletewarehouse')}}" name="deletewarehouse" method="post"
                              class="form-horizontal">

                            <input type="hidden" name="delete" id="delete" class="form-control" value="Delete">
                            <input type="hidden" name="warehouse_id" id="warehouse_id" class="form-control">
                            <div class="modal-body">
                                <p>Are you sure you want to delete this Warehouse?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection