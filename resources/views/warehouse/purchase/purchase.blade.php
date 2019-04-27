@extends('warehouse.warehouse_master')
@section('title', 'Smileshop | Purchase')
@section('content')
    @php $products = \App\ProductsModel::whereis_del(0)->orderBy('products_id','desc')->get();
    @endphp

    <link rel="stylesheet" href="{{ url('public/css/cropper.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/css/main.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <script src="{{ url('public/js/cropper.min.js') }}"></script>
    <script src="{{ url('public/js/Global.js') }}"></script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Products') }}
                <small>{{ trans('labels.ListingAllProducts') }}...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('warehouse_dashboard') }}"><i
                                class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.Products') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.AddNewProduct') }} </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="container">
                                            <div class="box-body">
                                                @if( count($errors) > 0)
                                                    @foreach($errors->all() as $error)
                                                        <div class="alert alert-danger" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign"
                                                              aria-hidden="true"></span>
                                                            <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                                            {{ $error }}
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div class="row">
                                                    <form action="{{ url('addpurchase') }}" method="POST">
                                                        <input type="hidden" name="csrf" id="{{csrf_token()}}">
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <label for="" class="pull-left">&nbsp;Purchase
                                                                    No.</label>
                                                                <input type="text" class="form-control" name="p_no"
                                                                       placeholder="Puchase No.">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="pull-left">&nbsp;Purchase
                                                                    Date.</label>
                                                                <input type="text" class="form-control"
                                                                       name="p_date"
                                                                       value="{{ date('d-M-Y') }}"
                                                                       placeholder="Puchase Date" disabled>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="pull-left">&nbsp;Invoice
                                                                    No</label>
                                                                <input type="text" class="form-control"
                                                                       name="invoice"
                                                                       placeholder="Invoice No.">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="" class="pull-left">&nbsp;Invoice
                                                                    Date</label>
                                                                <input type="text" class="form-control dateRange"
                                                                       name="invoice_date"
                                                                       id="invoice_date"
                                                                       placeholder="Invoice Date">
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <label for="" class="pull-left">&nbsp;Vendor</label> {{-- <select class=" typeDD requireDD"
                                            name="vendor" style="width: 100%; height:150%"> --}}
                                                                <select class="form-control" name="vendor"
                                                                        style="width: 100%; height:150%">
                                                                    <option value="">Select Vendor</option>
                                                                    {{--@foreach ($vendor as $item)--}}
                                                                    {{--<option value="{{ $item->id }}">{{ ucwords($item->name)}}</option>--}}
                                                                    {{--@endforeach--}}
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label for="" class="pull-left">&nbsp;Product
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                       name="p_name[]"
                                                                       placeholder="Product Name">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="" class="pull-left">&nbsp;Brand</label>
                                                                <select class="form-control typeDD requireDD"
                                                                        name="brand[]"
                                                                        style="width: 100%;">
                                                                    <option value="">Select Brand</option>
                                                                    @foreach ($brand as $item)
                                                                        <option value="{{ $item->manufacturers_id }}">{{ ucwords($item->manufacturers_name)}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Select
                                                                        Category</label>
                                                                    <select class="form-control typeDD requireDD"
                                                                            name="catid[]"
                                                                            id="catid_1"
                                                                            style="width: 100%;" onchange="subCategorylist();">
                                                                        <option value="">Select</option>

                                                                        @foreach ($catlist as $item)
                                                                            <option value="{{ $item->categories_description_id }}">
                                                                                <b>{{ ucwords($item->categories_name)}}</b>
                                                                            </option>
                                                                            {{--@php--}}
                                                                            {{--$sublist = \App\Category::whereis_del(0)->whereparent_id($item->id)->orderBy('id', 'desc')->get();--}}
                                                                            {{--@endphp--}}
                                                                            {{--@foreach ($sublist as $item1)--}}
                                                                            {{--<option value="{{ $item1->id }}">&nbsp;&nbsp;-{{ ucwords($item1->name)}}</option>--}}
                                                                            {{--@endforeach--}}
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Select
                                                                        Sub Category</label>
                                                                    <select class="form-control typeDD requireDD"
                                                                            name="catid[]"
                                                                            style="width: 100%;">
                                                                        <option value="">Select</option>

                                                                        @foreach ($catlist as $item)
                                                                            <option value="{{ $item->categories_description_id }}">
                                                                                <b>{{ ucwords($item->categories_name)}}</b>
                                                                            </option>


                                                                            {{--@php--}}
                                                                            {{--$sublist = \App\Category::whereis_del(0)->whereparent_id($item->id)->orderBy('id', 'desc')->get();--}}
                                                                            {{--@endphp--}}
                                                                            {{--@foreach ($sublist as $item1)--}}
                                                                            {{--<option value="{{ $item1->id }}">&nbsp;&nbsp;-{{ ucwords($item1->name)}}</option>--}}
                                                                            {{--@endforeach--}}
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Unit</label>
                                                                    <select name="unit[]" id="unit"
                                                                            class="form-control typeDD requireDD">
                                                                        <option value="">Select unit</option>
                                                                        @foreach($unit as $unit)
                                                                            <option value="{{$unit->unit_id }}">{{$unit->unit_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Loose /
                                                                        Pack</label>
                                                                    <select name="loose_pack[]" id="loose_pack"
                                                                            class="form-control">
                                                                        <option value="0">Loose</option>
                                                                        <option value="1">Pack</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">CP Excl
                                                                        Tax(₹)</label>
                                                                    <input type="text"
                                                                           class="form-control numberOnly"
                                                                           onkeyup="totamt(1)"
                                                                           name="unit_price[]" id="unit_price1"
                                                                           placeholder="Enter Price">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">QTY</label>
                                                                    <input type="text" onkeyup="totamt(1)"
                                                                           class="form-control numberOnly"
                                                                           name="qty[]" id="qty1"
                                                                           placeholder="Enter Qty">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Free
                                                                        QTY</label>
                                                                    <input type="text"
                                                                           class="form-control numberOnly"
                                                                           name="f_qty[]"
                                                                           id="f_qty" placeholder="Enter Free Qty">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Total
                                                                        Amount</label>
                                                                    <input type="text" onkeypress="return false"
                                                                           onkeydown="return false"
                                                                           class="form-control" name="t_amount[]"
                                                                           id="t_amount1"
                                                                           placeholder="Enter Amount">


                                                                </div>

                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Scheme
                                                                        Discount</label>
                                                                    <input type="text" class="form-control"
                                                                           onkeyup="totamt(1);"
                                                                           name="s_discount[]" id="s_discount1"
                                                                           placeholder="Enter Scheme Discount">


                                                                </div>

                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">GST</label>
                                                                    <input type="text" class="form-control"
                                                                           onkeyup="totamt(1);"
                                                                           name="gst[]" id="gst1"
                                                                           placeholder="Enter GST">


                                                                </div>

                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">CGST</label>
                                                                    <input type="text" class="form-control"
                                                                           name="cgst[]" id="cgst1"
                                                                           placeholder="Enter CGST">


                                                                </div>

                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">SGST</label>
                                                                    <input type="text" class="form-control"
                                                                           name="sgst[]" id="sgst1"
                                                                           placeholder="Enter SGST">


                                                                </div>

                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Total Cost
                                                                        Price (All Qty)</label>
                                                                    <input type="text" class="form-control"
                                                                           name="total_cost_price[]"
                                                                           id="total_cost_price1"
                                                                           placeholder="Enter Cost Price">


                                                                </div>

                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Cost Price
                                                                        (Per Unit)</label>
                                                                    <input type="text" class="form-control"
                                                                           name="cost_price[]"
                                                                           id="cost_price1"
                                                                           placeholder="Enter Cost Price">


                                                                </div>

                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="name" class="pull-left"
                                                                           style="align: center">Selling Price
                                                                        (Per Unit)</label>
                                                                    <input type="text" class="form-control"
                                                                           name="selling_price[]"
                                                                           id="selling_price1"
                                                                           placeholder="Enter Selling Price">

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div id="addhere">


                                                        </div>
                                                        <button type="button" onclick="addprorow();"
                                                                class="btn btn-primary btn-sm">+
                                                        </button>
                                                        <hr>
                                                        <button type="submit" class="btn btn-success btn-block">Done
                                                            & Save
                                                        </button>
                                                    </form>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script>
        var uid = 2;
        function addprorow() {
            $.get('{{ url('addnewrow') }}', {
                uid: uid
            }, function (data) {
                $('#addhere').append(data);
            });
            uid++;
        }

        function removerow(id) {
            $('#thisis' + id).remove();
        }

        function totamt(id) {
            debugger
            var unit_price = $('#unit_price' + id).val() == "" ? 0 : $('#unit_price' + id).val();
            var qty = $('#qty' + id).val() == "" ? 0 : $('#qty' + id).val();
            var s_discount = $('#s_discount' + id).val() == "" ? 0 : $('#s_discount' + id).val();
            var gst = $('#gst' + id).val() == "" ? 0 : $('#gst' + id).val();

            var halfgst = parseFloat(gst) / 2;
            $('#cgst' + id).val(halfgst);
            $('#sgst' + id).val(halfgst);

            var amount = parseFloat(unit_price) * parseFloat(qty);
            $('#t_amount' + id).val(amount);
            var gstprice = ( parseFloat(amount) * parseFloat(gst)) / 100;
            var cost_price = parseFloat(amount) - parseFloat(s_discount);
            cost_price = parseFloat(cost_price) + parseFloat(gstprice);
            $('#total_cost_price' + id).val(cost_price);

            cost_price = parseFloat(cost_price) / qty;
            //  cost_price = cost_price - s_discount;

            $('#cost_price' + id).val(cost_price);
        }
    </script>
    <script>
        $(function () {
            $(".typeDD").select2({
                placeholder: "Select"
            });

            $('input[name="invoice_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2019,
                maxYear: parseInt(moment().format('YYYY'), 10)
            });
        });
        function subCategorylist() {
            var categoryid = $('#catid_1').val();
//            alert(categoryid);
            $.get('{{ url('subCategorylist') }}', {
                categoryid: categoryid
            }, function (data) {
                alert(data);
                console.log(data);
//                $('#catid_1').html(data);
            });

        }
    </script>
    {{--@endsection--}}
@stop