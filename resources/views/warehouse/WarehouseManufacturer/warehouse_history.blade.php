@extends('warehouse.warehouse_master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Warehouse Stock History
                <small>Warehouse Stock History List...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('warehouse_dashboard') }}"><i
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
                                <a href="{{ URL::to('addwarehouse') }}" type="button"
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
                                            {{-- <th>Warehouse Name</th> --}}
                                            <th>Product</th>
                                            <th>Stock</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($Warehouse_history)>0)
                                            @foreach ($Warehouse_history  as $key=>$Warehouse_history_list)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ isset($Warehouse_history_list->pname->products_name) ? $Warehouse_history_list->pname->products_name : '-'  }}</td>
                                                    <td>{{ $Warehouse_history_list->stock }}</td>

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
                        <form action="{{url('deletewarehouse')}}" name="deletewarehouse" method="post"
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