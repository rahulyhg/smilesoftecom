@extends('warehouse.warehouse_master')
@section('title','Staff Report | Warehouse')
@section('content')

    {{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>--}}
    {{--<script>--}}
    {{--$(document).ready(function () {--}}
    {{--$('#example').DataTable();--}}
    {{--});--}}
    {{--</script>--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">--}}
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">--}}
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Staff Report
                <small>Listing All The Staff Report...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('warehouse_dashboard') }}"><i
                                class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Staff Report</li>
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
                            <h3 class="box-title">Listing All The Staff Reports</h3>
                            {{--<div class="box-tools pull-right">--}}
                            {{--<a href="{{url('add_staff')}}" type="button"--}}
                            {{--class="btn btn-block btn-primary">Add New Staff Member</a>--}}
                            {{--</div>--}}
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
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Today's Total</th>
                                    <th>Today's Invoice Count</th>
                                    <th>Invoice Count</th>
                                    <th>Grand Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($staff as $temp=>$record)
                                    @php
                                        $warehouse_id = session('warehouse')->id;
                                        $rupee = '₹';
                                        //$today = \App\POSModel::where('created_time', '=', \Carbon\Carbon::today()->toDateString(),['wid'=>$warehouse_id, 'sid'=>$record->id]);
                                        $dates = \App\POSModel::where('wid','=',$warehouse_id)
                                        ->whereBetween('created_time', array(\Carbon\Carbon::today(), \Carbon\Carbon::yesterday()))
                                        ->sum('grand_total');
                                        $invoice_today = \App\POSModel::where('wid','=',$warehouse_id)
                                        ->whereBetween('created_time', array(\Carbon\Carbon::today(), \Carbon\Carbon::yesterday()))
                                        ->count('invoice_no');
                                        //dd($dates);
                                        $grand_total = \App\POSModel::where(['wid'=>$warehouse_id, 'sid'=>$record->id])->sum('grand_total');
                                    $invouce_count = \App\POSModel::where(['wid'=>$warehouse_id, 'sid'=>$record->id])->count('invoice_no');
                                    @endphp
                                    <tr>
                                        <td>{{++$temp}}</td>
                                        <td>{{$record->name}}</td>
                                        <td>{{$rupee }} {{number_format("$dates",2,".",",")}}</td>
                                        <td>{{$invoice_today}}</td>
                                        <td>{{$invouce_count}}</td>
                                        <td>{{$rupee }} {{number_format("$grand_total",2,".",",")}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Today's Total: {{$rupee }} {{number_format("$dates",2,".",",")}}</th>
                                    <th>Today's Invoice Count</th>
                                    <th>Invoice Count</th>
                                    <th>Grand Total: {{$rupee }} {{number_format("$grand",2,".",",")}}</th>
                                </tr>
                                </tfoot>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop