@extends('warehouse.warehouse_master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Staff
                <small>Listing All The Staff Members...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('warehouse_dashboard') }}"><i
                                class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Staff</li>
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
                            <h3 class="box-title">Listing All The Staff Members </h3>
                            <div class="box-tools pull-right">
                                <a href="{{url('add_staff')}}" type="button"
                                   class="btn btn-block btn-primary">Add New Staff Member</a>
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
                                            <th>ID</th>
                                            <th>Member Name</th>
                                            <th>Contact</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($staff)>0)
                                            @foreach ($staff  as $key=>$staffs)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $staffs->name }}</td>
                                                    <td>{{ $staffs->contact }}</td>
                                                    <td>{{ $staffs->username }}</td>
                                                    <td>{{ $staffs->password }}</td>
                                                    <td>{{ $staffs->role }}</td>
                                                    <td colspan="2">
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                           href="staff_edit/{{ $staffs->id }}"
                                                           class="badge bg-light-blue"><i class="fa fa-pencil-square-o"
                                                                                          aria-hidden="true"></i></a>
                                                        {{--<a id="manufacturerFrom"--}}
                                                        {{--staff_id='{{ $staffs->id }}'--}}
                                                        {{--data-toggle="tooltip" data-placement="bottom" title="Delete"--}}
                                                        {{--href="" class="badge bg-red">--}}
                                                        {{--<i class="fa fa-trash" aria-hidden="true"></i>--}}
                                                        {{--</a>--}}
                                                        <form action="{{url('staff_del')}}" method="post">
                                                            <input type="hidden" name="csrf" value="{{@csrf_token()}}">
                                                            <input type="hidden" name="sid" value="{{$staffs->id}}">
                                                            <button type="submit" id="del" name="del" title="Delete"
                                                                    data-placement="bottom" class="badge bg-red">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
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
                                    <div class="col-xs-12 text-right">
                                        {{$staff->links('vendor.pagination.default')}}
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

            <!-- deleteManufacturerModal -->
            <div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog"
                 aria-labelledby="deleteManufacturerModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"
                                id="deleteManufacturerModalLabel">Dismiss Staff Member</h4>
                        </div>
                        <form action="{{url('staff_del')}}" method="post" name="deleteManufacturer"
                              enctype="multipart/form-data"
                              class="form-horizontal"
                              id="deleteManufacturer">
                            {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                            {!! Form::hidden('staff_id',  '', array('class'=>'form-control', 'id'=>'staff')) !!}
                            <div class="modal-body">
                                <p>Are you sure you want to delete this Staff Member?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal">{{ trans('labels.Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Delete') }}</button>
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