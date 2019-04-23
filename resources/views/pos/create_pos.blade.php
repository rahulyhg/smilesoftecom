<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="aVMpzwECPpX04VJ7m6cZfcnnGQyy6bicxVym2RYP">

    <title>POS - Smile Shop</title>

    <link rel="stylesheet" href="https://pos.ultimatefosters.com/AdminLTE/plugins/pace/pace.css?v=35">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/plugins/jquery-ui/jquery-ui.min.css?v=35">--}}
<!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="https://pos.ultimatefosters.com/bootstrap/css/bootstrap.min.css?v=35">


    <!-- Ionicons -->
{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/plugins/ionicons/css/ionicons.min.css?v=35">--}}
<!-- Select2 -->
    <link rel="stylesheet" href="https://pos.ultimatefosters.com/AdminLTE/plugins/select2/select2.min.css?v=35">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://pos.ultimatefosters.com/AdminLTE/css/AdminLTE.min.css?v=35">
    <!-- iCheck -->
{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/AdminLTE/plugins/iCheck/square/blue.css?v=35">--}}

<!-- bootstrap datepicker -->
{{--<link rel="stylesheet"--}}
{{--href="https://pos.ultimatefosters.com/AdminLTE/plugins/datepicker/bootstrap-datepicker.min.css?v=35">--}}

<!-- DataTables -->
{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/AdminLTE/plugins/DataTables/datatables.min.css?v=35">--}}

<!-- Toastr -->
    <link rel="stylesheet" href="https://pos.ultimatefosters.com/plugins/toastr/toastr.min.css?v=35">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="https://pos.ultimatefosters.com/plugins/bootstrap-fileinput/fileinput.min.css?v=35">

{{--<!-- AdminLTE Skins.-->--}}
{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/AdminLTE/css/skins/_all-skins.min.css?v=35">--}}


{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/AdminLTE/plugins/daterangepicker/daterangepicker.css?v=35">--}}
{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/plugins/bootstrap-tour/bootstrap-tour.min.css?v=35">--}}
{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/plugins/calculator/calculator.css?v=35">--}}

{{--<link rel="stylesheet" href="https://pos.ultimatefosters.com/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v=35">--}}

<!-- app css -->
    <link rel="stylesheet" href="https://pos.ultimatefosters.com/css/app.css?v=35">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style type="text/css">
        .content {
            padding-bottom: 0px !important;
        }
    </style>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            var availableTags = [];

            $.get('{{ url('admin/getCustomer') }}', function (data) {
                for (var i = 0; i < data.length; i++) {
                    availableTags[i] = data[i].name;
//                    custids[i] = data[i].id;
                }
            });
            $("#tags").autocomplete({
                source: availableTags,
            });
        });

        {{--function cust_id() {--}}
        {{--$.get('{{ url('admin/getCustID') }}', function (data) {--}}
        {{--for (var i = 0; i < data.length; i++) {--}}
        {{--availableTags[i] = data[i].name;--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}
    </script>

    <!-- Facebook Pixel Code -->
{{--<script>--}}
{{--!function(f,b,e,v,n,t,s)--}}
{{--{if(f.fbq)return;n=f.fbq=function(){n.callMethod?--}}
{{--n.callMethod.apply(n,arguments):n.queue.push(arguments)};--}}
{{--if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';--}}
{{--n.queue=[];t=b.createElement(e);t.async=!0;--}}
{{--t.src=v;s=b.getElementsByTagName(e)[0];--}}
{{--s.parentNode.insertBefore(t,s)}(window, document,'script',--}}
{{--'https://connect.facebook.net/en_US/fbevents.js');--}}
{{--fbq('init', '2114584372094607');--}}
{{--fbq('track', 'PageView');--}}
{{--</script>--}}
{{--<noscript><img height="1" width="1" style="display:none"--}}
{{--src="https://www.facebook.com/tr?id=2114584372094607&ev=PageView&noscript=1"--}}
{{--/></noscript>--}}
<!-- End Facebook Pixel Code -->
</head>

<body class=" hold-transition lockscreen ">
<div class="wrapper">
    {{--<script type="text/javascript">--}}
    {{--if(localStorage.getItem("upos_sidebar_collapse") == 'true'){--}}
    {{--var body = document.getElementsByTagName("body")[0];--}}
    {{--body.className += " sidebar-collapse";--}}
    {{--}--}}
    {{--</script>--}}
    <div class="col-md-12 no-print pos-header">
        {{--<input type="hidden" id="pos_redirect_url" value="https://pos.ultimatefosters.com/pos/create">--}}
        <div class="row">

            <div class="col-md-10">

                <a href="#" onClick="history.go(-1);" title="Go Back" data-toggle="tooltip" data-placement="bottom"
                   class="btn btn-info btn-flat m-6 btn-xs m-5 pull-right">
                    <strong><i class="fa fa-backward fa-lg"></i></strong>
                </a>

            </div>

            <div class="col-md-2">
                <div class="m-6 pull-right mt-15 hidden-xs"><strong>04/20/2019</strong></div>
            </div>

        </div>
    </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="">

        <!-- Add currency related field-->
        <input type="hidden" id="__code" value="USD">
        <input type="hidden" id="__symbol" value="$">
        <input type="hidden" id="__thousand" value=",">
        <input type="hidden" id="__decimal" value=".">
        <input type="hidden" id="__symbol_placement" value="before">
        <input type="hidden" id="__precision" value="2">
        <input type="hidden" id="__quantity_precision" value="2">
        <!-- End of currency related field-->


        <!-- Content Header (Page header) -->
        <!-- <section class="content-header">
            <h1>Add Purchase</h1> -->
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
        </ol> -->
        <!-- </section> -->

        <!-- Main content -->
        <section class="content no-print">
            <div class="row">
                <div class=" col-md-7  col-sm-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <div class="col-sm-6">
                                <h3 class="box-title">POS Terminal <i class="fa fa-keyboard-o hover-q text-muted"
                                                                      aria-hidden="true" data-container="body"
                                                                      data-toggle="popover" data-placement="bottom"
                                                                      data-content="<table class='table table-condensed table-striped'>
	<tr>
	    <th>Operations</th>
	    <th>Keyboard Shortcut</th>
	</tr>

			<tr>
		    <td>Express <br/>Checkout:</td>
		    <td>
			    			    	shift+e
			    		    </td>
		</tr>
	
			<tr>
		    <td>Pay & Checkout:</td>
		    <td>
		    				    	shift+p
			    		    </td>
		</tr>
	
			<tr>
		    <td>Draft:</td>
		    <td>
		    				    	shift+d
			    		    </td>
		</tr>
	
	<tr>
	    <td>Cancel:</td>
	    <td>
	    			    	shift+c
		    	    </td>
	</tr>

			<tr>
		    <td>Edit Discount:</td>
		    <td>
		    				    	shift+i
			    		    </td>
		</tr>
	
			<tr>
		    <td>Edit Order Tax:</td>
		    <td>
		    				    	shift+t
			    		    </td>
		</tr>
	
			<tr>
		    <td>Add Payment Row:</td>
		    <td>
		    				    	shift+r
			    		    </td>
		</tr>
	
			<tr>
		    <td>Finalize Payment:</td>
		    <td>
		    				    	shift+f
			    		    </td>
		</tr>
		
	<tr>
	    <td>Go to product quantity:</td>
	    <td>
	    			    	f2
		    	    </td>
	</tr>

	<tr>
	    <td>Add new product:</td>
	    <td>
	    			    	f4
		    	    </td>
	</tr>
	
</table>" data-html="true" data-trigger="hover" data-original-title="" title=""></i></h3>
                            </div>
                            <input type="hidden" id="item_addition_method" value="1">
                        </div>

                        <div class="box-body">
                            <form action="{{ url('admin/store_pos') }}" id="store_pos" method="post"
                                  enctype="multipart/form-data">
                                {{--<form method="POST" action="{{url('admin/store_pos')}}" accept-charset="UTF-8"--}}
                                {{--id="">--}}
                                <input name="_token" type="hidden"
                                       value="aVMpzwECPpX04VJ7m6cZfcnnGQyy6bicxVym2RYP">

                                <input id="location_id" data-receipt_printer_type="browser" name="location_id"
                                       type="hidden" value="1">

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <input id="price_group" name="price_group" type="hidden" value="0">

                                    </div>
                                    <div class="row">
                                        <div class=" col-sm-6 ">
                                            <div class="form-group" style="width: 100% !important">
                                                <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
                                                    <input type="hidden" id="default_customer_id"
                                                           value="1">
                                                    <input type="hidden" id="default_customer_name"
                                                           value="Walk-In Customer">
                                                    {{--<input type="text" class="form-control" name="tags" id="tags" onchange="cust_id();">--}}
                                                    {{--<input type="hidden" class="form-control" name="customer_id" id="customer_id">--}}
                                                    @php
                                                        $customer = \App\CustomerModel::where(['is_del'=>0])->get();
                                                    @endphp

                                                    <select class="form-control" id="" required
                                                            style="width: 100%;" name="customer_id">
                                                        @foreach($customer as $cust)
                                                            <option value="{{$cust->id}}">{{$cust->name}}
                                                                -{{$cust->contact}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat add_new_customer"
                                                data-name=""><i
                                                    class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="pay_term_number" id="pay_term_number" value="">
                                        <input type="hidden" name="pay_term_type" id="pay_term_type" value="">


                                        <div class=" col-sm-6 ">
                                            <div class="form-group">
                                                <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-barcode"></i>
									</span>
                                                    <input class="form-control mousetrap"
                                                           onkeypress="getProductRowScan(this);" id="search_product"
                                                           placeholder="Enter Product name / SKU / Scan bar code"
                                                           autofocus name="search_product"
                                                           type="text">
                                                    <span class="input-group-btn">
										<button type="button"
                                                class="btn btn-default bg-white btn-flat pos_add_quick_product"
                                                data-href="https://pos.ultimatefosters.com/products/quick_add"
                                                data-container=".quick_add_product_modal"><i
                                                    class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <!-- Call restaurant module if defined -->
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 pos_product_div">
                                            <input type="hidden" name="sell_price_tax" id="sell_price_tax"
                                                   value="includes">

                                            <!-- Keeps count of product rows -->
                                            <input type="hidden" id="product_row_count"
                                                   value="0">
                                            <table class="table table-condensed table-bordered table-striped table-responsive"
                                                   id="pos_table">
                                                <thead>
                                                <tr>
                                                    <th class="tex-center  col-md-4 ">
                                                        Product <i class="fa fa-info-circle text-info hover-q no-print "
                                                                   aria-hidden="true"
                                                                   data-container="body" data-toggle="popover"
                                                                   data-placement="auto bottom"
                                                                   data-content="Click <i>product name</i> to edit price, discount & tax. <br/>Click <i>Comment Icon</i> to enter serial number / IMEI or additional note.<br/><br/>Click <i>Modifier Icon</i>(if enabled) for modifiers"
                                                                   data-html="true" data-trigger="hover"></i></th>
                                                    <th class="text-center col-md-3">
                                                        Quantity
                                                    </th>
                                                    <th class="text-center col-md-2 ">
                                                        Price inc. tax
                                                    </th>
                                                    <th class="text-center col-md-2">
                                                        Subtotal
                                                    </th>
                                                    <th class="text-center"><i class="fa fa-close"
                                                                               aria-hidden="true"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--<tr class="product_row" data-row_index="1">--}}
                                                {{--<td>--}}

                                                {{--<div data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit product Unit Price and Tax">--}}
                                                {{--<span class="text-link text-info cursor-pointer" data-toggle="modal" data-target="#row_edit_product_price_modal_1">--}}
                                                {{--Acer Aspire E 15 (Color:Black)<br>AS0017-1 Acer--}}
                                                {{--&nbsp;<i class="fa fa-info-circle"></i>--}}
                                                {{--</span>--}}
                                                {{--</div>--}}
                                                {{--<input type="hidden" class="enable_sr_no" value="0">--}}
                                                {{--<div data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Add Description">--}}
                                                {{--<i class="fa fa-commenting cursor-pointer text-primary add-pos-row-description" data-toggle="modal" data-target="#row_description_modal_1"></i>--}}
                                                {{--</div>--}}


                                                {{--<div class="modal fade row_edit_product_price_model" id="row_edit_product_price_modal_1" tabindex="-1" role="dialog" style="display: none;">--}}
                                                {{--<div class="modal-dialog" role="document">--}}
                                                {{--<div class="modal-content">--}}
                                                {{--<div class="modal-header">--}}
                                                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
                                                {{--<h4 class="modal-title" id="myModalLabel">Acer Aspire E 15 (Color:Black) - AS0017-1</h4>--}}
                                                {{--</div>--}}
                                                {{--<div class="modal-body">--}}
                                                {{--<div class="row">--}}
                                                {{--<div class="form-group col-xs-12 ">--}}
                                                {{--<label>Unit Price</label>--}}
                                                {{--<input type="text" name="products[1][unit_price]" class="form-control pos_unit_price input_number mousetrap valid" value="437.50" aria-invalid="false">--}}
                                                {{--</div>--}}

                                                {{--<div class="form-group col-xs-12 col-sm-6 ">--}}
                                                {{--<label>Discount Type</label>--}}
                                                {{--<select class="form-control row_discount_type valid" name="products[1][line_discount_type]" aria-invalid="false"><option value="fixed" selected="selected">Fixed</option><option value="percentage">Percentage</option></select>--}}
                                                {{--</div>--}}
                                                {{--<div class="form-group col-xs-12 col-sm-6 ">--}}
                                                {{--<label>Discount Amount</label>--}}
                                                {{--<input class="form-control input_number row_discount_amount" name="products[1][line_discount_amount]" type="text" value="0.00">--}}
                                                {{--</div>--}}
                                                {{--<div class="form-group col-xs-12 ">--}}
                                                {{--<label>Tax</label>--}}

                                                {{--<input class="item_tax" name="products[1][item_tax]" type="hidden" value="0.00">--}}

                                                {{--<select class="form-control tax_id" name="products[1][tax_id]"><option selected="selected" value="">Select</option><option value="" selected="selected">None</option><option value="2" data-rate="10">CGST@10%</option><option value="3" data-rate="10">SGST@8%</option><option value="4" data-rate="20">GST@18%</option></select>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="modal-footer">--}}
                                                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--</div>		</div>--}}

                                                {{--<!-- Description modal start -->--}}
                                                {{--<div class="modal fade row_description_modal" id="row_description_modal_1" tabindex="-1" role="dialog">--}}
                                                {{--<div class="modal-dialog" role="document">--}}
                                                {{--<div class="modal-content">--}}
                                                {{--<div class="modal-header">--}}
                                                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
                                                {{--<h4 class="modal-title" id="myModalLabel">Acer Aspire E 15 (Color:Black) - AS0017-1</h4>--}}
                                                {{--</div>--}}
                                                {{--<div class="modal-body">--}}
                                                {{--<div class="form-group">--}}
                                                {{--<label>Description</label>--}}
                                                {{--<textarea class="form-control" name="products[1][sell_line_note]" rows="3"></textarea>--}}
                                                {{--<p class="help-block">Add product IMEI, Serial number or other informations here.</p>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="modal-footer">--}}
                                                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<!-- Description modal end -->--}}



                                                {{--</td>--}}

                                                {{--<td>--}}


                                                {{--<input type="hidden" name="products[1][product_id]" class="form-control product_id" value="17">--}}

                                                {{--<input type="hidden" value="57" name="products[1][variation_id]" class="row_variation_id">--}}

                                                {{--<input type="hidden" value="1" name="products[1][enable_stock]">--}}


                                                {{--<div class="input-group input-number">--}}
                                                {{--<span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-down"><i class="fa fa-minus text-danger"></i></button></span>--}}
                                                {{--<input type="text" data-min="1" class="form-control pos_quantity input_number mousetrap input_quantity" value="1.00" name="products[1][quantity]" data-allow-overselling="false" data-decimal="0" data-rule-abs_digit="true" data-msg-abs_digit="Decimal value not allowed" data-rule-required="true" data-msg-required="This field is required" data-rule-max-value="27.0000" data-qty_available="27.0000" data-msg-max-value="Only 27.00 Pc(s) available" data-msg_max_default="Only 27.00 Pc(s) available">--}}
                                                {{--<span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-up"><i class="fa fa-plus text-success"></i></button></span>--}}
                                                {{--</div>--}}

                                                {{--<input type="hidden" name="products[1][product_unit_id]" value="1">--}}
                                                {{--Pc(s)--}}

                                                {{--<input type="hidden" class="base_unit_multiplier" name="products[1][base_unit_multiplier]" value="1">--}}

                                                {{--<input type="hidden" class="hidden_base_unit_sell_price" value="437.5">--}}

                                                {{--</td>--}}
                                                {{--<td class="">--}}
                                                {{--<input type="text" name="products[1][unit_price_inc_tax]" class="form-control pos_unit_price_inc_tax input_number" value="437.50">--}}
                                                {{--</td>--}}
                                                {{--<td class="text-center v-center">--}}
                                                {{--<input type="hidden" class="form-control pos_line_total " value="437.50">--}}
                                                {{--<span class="display_currency pos_line_total_text " data-currency_symbol="true">$ 437.50</span>--}}
                                                {{--</td>--}}
                                                {{--<td class="text-center">--}}
                                                {{--<i class="fa fa-close text-danger pos_remove_row cursor-pointer" aria-hidden="true"></i>--}}
                                                {{--</td>--}}
                                                {{--</tr>--}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body bg-gray disabled"
                                                     style="margin-bottom: 0px !important">


                                                    <table class="table table-condensed"
                                                           style="margin-bottom: 0px !important">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                {{--<div class="col-sm-1 col-xs-3 d-inline-table">--}}
                                                                {{--<b>Items:</b>--}}
                                                                {{--<br/>--}}
                                                                {{--<span class="total_quantity">0</span>--}}
                                                                {{--</div>--}}

                                                                {{--<div class="col-sm-2 col-xs-3 d-inline-table">--}}
                                                                {{--<b>Total:</b>--}}
                                                                {{--<br/>--}}
                                                                {{--<span class="price_total">0</span>--}}
                                                                {{--</div>--}}

                                                                {{--<div class="col-sm-2 col-xs-6 d-inline-table">--}}

                                                                {{--<span class="">--}}

                                                                {{--<b>Discount(-): <i class="fa fa-info-circle text-info hover-q " aria-hidden="true"--}}
                                                                {{--data-container="body" data-toggle="popover" data-placement="auto"--}}
                                                                {{--data-content="Set 'Default Sale Discount' for all sales in Business Settings. Click on the edit icon below to add/update discount."--}}
                                                                {{--data-html="true" data-trigger="hover"></i></b>--}}
                                                                {{--<br/>--}}
                                                                {{--<i class="fa fa-pencil-square-o cursor-pointer" id="pos-edit-discount"--}}
                                                                {{--title="Edit Discount" aria-hidden="true" data-toggle="modal"--}}
                                                                {{--data-target="#posEditDiscountModal"></i>--}}
                                                                {{--<span id="total_discount">0</span>--}}
                                                                {{--<input type="hidden" name="discount_type" id="discount_type" value="percentage"--}}
                                                                {{--data-default="percentage">--}}

                                                                {{--<input type="hidden" name="discount_amount" id="discount_amount" value=" 10.00 "--}}
                                                                {{--data-default="10.00">--}}

                                                                {{--</span>--}}
                                                                {{--</div>--}}

                                                                {{--<div class="col-sm-2 col-xs-6 d-inline-table">--}}

                                                                {{--<span class="">--}}

                                                                {{--<b>Order Tax(+): <i class="fa fa-info-circle text-info hover-q " aria-hidden="true"--}}
                                                                {{--data-container="body" data-toggle="popover" data-placement="auto"--}}
                                                                {{--data-content="Set 'Default Sale Tax' for all sales in Business Settings. Click on the edit icon below to add/update Order Tax."--}}
                                                                {{--data-html="true" data-trigger="hover"></i></b>--}}
                                                                {{--<br/>--}}
                                                                {{--<i class="fa fa-pencil-square-o cursor-pointer" title="Edit Order Tax"--}}
                                                                {{--aria-hidden="true" data-toggle="modal" data-target="#posEditOrderTaxModal"--}}
                                                                {{--id="pos-edit-tax"></i>--}}
                                                                {{--<span id="order_tax">--}}
                                                                {{--0--}}
                                                                {{--</span>--}}

                                                                {{--<input type="hidden" name="tax_rate_id"--}}
                                                                {{--id="tax_rate_id"--}}
                                                                {{--value="  "--}}
                                                                {{--data-default="">--}}

                                                                {{--<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount"--}}
                                                                {{--value=" 0.00 " data-default="">--}}

                                                                {{--</span>--}}
                                                                {{--</div>--}}
                                                                {{--<!-- shipping -->--}}
                                                                {{--<div class="col-sm-2 col-xs-6 d-inline-table">--}}

                                                                {{--<span class="">--}}

                                                                {{--<b>Shipping(+): <i class="fa fa-info-circle text-info hover-q " aria-hidden="true"--}}
                                                                {{--data-container="body" data-toggle="popover" data-placement="auto"--}}
                                                                {{--data-content="Set shipping details and shipping charges. Click on the edit icon below to add/update shipping details and charges."--}}
                                                                {{--data-html="true" data-trigger="hover"></i></b>--}}
                                                                {{--<br/>--}}
                                                                {{--<i class="fa fa-pencil-square-o cursor-pointer" title="Shipping" aria-hidden="true"--}}
                                                                {{--data-toggle="modal" data-target="#posShippingModal"></i>--}}
                                                                {{--<span id="shipping_charges_amount">0</span>--}}
                                                                {{--<input type="hidden" name="shipping_details" id="shipping_details" value=""--}}
                                                                {{--data-default="">--}}

                                                                {{--<input type="hidden" name="shipping_charges" id="shipping_charges" value="0.00 "--}}
                                                                {{--data-default="0.00">--}}

                                                                {{--</span>--}}
                                                                {{--</div>--}}


                                                                <div class="col-sm-3 col-xs-12 d-inline-table">
                                                                    <b>Total Payable:</b>
                                                                    <br/>
                                                                    <input type="hidden" name="final_total"
                                                                           id="final_total_input" value=0>
                                                                    <span id="total_payable"
                                                                          class="text-success lead text-bold">0</span>
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-flat btn-xs pull-right"
                                                                            onclick="reset_pos_form()"
                                                                            id="pos-cancel">Cancel
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                {{--<div class="col-sm-2 col-xs-6 col-2px-padding">--}}

                                                                {{--<button type="button"--}}
                                                                {{--class="btn btn-warning btn-block btn-flat "--}}
                                                                {{--id="pos-draft">Draft</button>--}}

                                                                {{--<button type="button"--}}
                                                                {{--class="btn btn-info btn-block btn-flat"--}}
                                                                {{--id="pos-quotation">Quotation</button>--}}
                                                                {{--</div>--}}
                                                                {{--<div class="col-sm-3 col-xs-6 col-2px-padding">--}}
                                                                {{--<button type="button"--}}
                                                                {{--class="btn bg-maroon btn-block btn-flat no-print  pos-express-finalize"--}}
                                                                {{--data-pay_method="card"--}}
                                                                {{--title="Express checkout using card" >--}}
                                                                {{--<div class="text-center">--}}
                                                                {{--<i class="fa fa-check" aria-hidden="true"></i>--}}
                                                                {{--<b>Card</b>--}}
                                                                {{--</div>--}}
                                                                {{--</button>--}}
                                                                {{--<button type="button"--}}
                                                                {{--class="btn bg-red btn-block btn-flat no-print pos-express-finalize"--}}
                                                                {{--data-pay_method="suspend"--}}
                                                                {{--title="Suspend Sales (pause)" >--}}
                                                                {{--<div class="text-center">--}}
                                                                {{--<i class="fa fa-pause" aria-hidden="true"></i>--}}
                                                                {{--<b>Suspend</b>--}}
                                                                {{--</div>--}}
                                                                {{--</button>--}}
                                                                {{--</div>--}}
                                                                {{--<div class="col-sm-4 col-xs-12 col-2px-padding">--}}
                                                                {{--<button type="button" class="btn bg-navy  btn-block btn-flat btn-lg no-print  pos-express-btn" id="pos-finalize" title="Checkout using multiple payment methods">--}}
                                                                {{--<div class="text-center">--}}
                                                                {{--<i class="fa fa-check" aria-hidden="true"></i>--}}
                                                                {{--<b>Multiple Pay</b>--}}
                                                                {{--</div>--}}
                                                                {{--</button>--}}
                                                                {{--</div>--}}
                                                                <div class="col-sm-3 col-xs-12 col-2px-padding">
                                                                    <button type="submit" id="btnStorePOS"
                                                                            class="btn btn-success btn-block btn-flat btn-lg no-print  pos-express-btn pos-express-finalize"
                                                                            data-pay_method="cash"
                                                                            title="Mark complete paid &amp; checkout">
                                                                        <div class="text-center">
                                                                            <i class="fa fa-check"
                                                                               aria-hidden="true"></i>
                                                                            <b>Cash</b>
                                                                        </div>
                                                                    </button>
                                                                </div>

                                                                <div class="div-overlay pos-processing"></div>
                                                            </td>
                                                        </tr>

                                                        </tbody>
                                                    </table>

                                                    <!-- Button to perform various actions -->
                                                    <div class="row">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit discount Modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog" id="posEditDiscountModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Edit Discount</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="discount_type_modal">Discount Type:*</label>
                                                                <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
                                                                    <select class="form-control" required
                                                                            id="discount_type_modal"
                                                                            name="discount_type_modal">
                                                                        <option value="">Please Select</option>
                                                                        <option value="fixed">Fixed</option>
                                                                        <option value="percentage" selected="selected">
                                                                            Percentage
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="discount_amount_modal">Discount
                                                                    Amount:*</label>
                                                                <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
                                                                    <input class="form-control input_number"
                                                                           name="discount_amount_modal" type="text"
                                                                           value="10.00" id="discount_amount_modal">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            id="posEditDiscountModalUpdate">Update
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <!-- Edit Order tax Modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog" id="posEditOrderTaxModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Edit Order Tax</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="order_tax_modal">Order Tax:*</label>
                                                                <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
                                                                    <select class="form-control" id="order_tax_modal"
                                                                            name="order_tax_modal">
                                                                        <option selected="selected" value="">Please
                                                                            Select
                                                                        </option>
                                                                        <option value="" selected="selected">None
                                                                        </option>
                                                                        <option value="1" data-rate="10">VAT@10%
                                                                        </option>
                                                                        <option value="2" data-rate="10">CGST@10%
                                                                        </option>
                                                                        <option value="3" data-rate="8">SGST@8%</option>
                                                                        <option value="4" data-rate="18">GST@18%
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            id="posEditOrderTaxModalUpdate">Update
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <!-- Edit Shipping Modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog" id="posShippingModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Shipping</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            recur_interval>--}}
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="shipping_charges_modal">Shipping
                                                                    Charges:*</label>
                                                                <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
                                                                    <input class="form-control input_number"
                                                                           placeholder="Shipping Charges"
                                                                           name="shipping_charges_modal" type="text"
                                                                           value="0.00" id="shipping_charges_modal">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            id="posShippingModalUpdate">Update
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog" id="modal_payment">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Payment</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="row">
                                                                <div id="payment_rows_div">


                                                                    <div class="col-md-12">
                                                                        <div class="box box-solid payment_row bg-lightgray">


                                                                            <div class="box-body">
                                                                                <div class="row">
                                                                                    <input type="hidden"
                                                                                           class="payment_row_index"
                                                                                           value="0">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="amount_0">Amount:*</label>
                                                                                            <div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-money"></i>
				</span>
                                                                                                <input class="form-control payment-amount input_number"
                                                                                                       required
                                                                                                       id="amount_0"
                                                                                                       placeholder="Amount"
                                                                                                       name="payment[0][amount]"
                                                                                                       type="text"
                                                                                                       value="0.00">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="method_0">Payment
                                                                                                Method:*</label>
                                                                                            <div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-money"></i>
				</span>
                                                                                                <select class="form-control col-md-12 payment_types_dropdown"
                                                                                                        required
                                                                                                        id="method_0"
                                                                                                        style="width:100%;"
                                                                                                        name="payment[0][method]">
                                                                                                    <option value="cash"
                                                                                                            selected="selected">
                                                                                                        Cash
                                                                                                    </option>
                                                                                                    <option value="card">
                                                                                                        Card
                                                                                                    </option>
                                                                                                    <option value="cheque">
                                                                                                        Cheque
                                                                                                    </option>
                                                                                                    <option value="bank_transfer">
                                                                                                        Bank Transfer
                                                                                                    </option>
                                                                                                    <option value="other">
                                                                                                        Other
                                                                                                    </option>
                                                                                                    <option value="custom_pay_1">
                                                                                                        Custom Payment 1
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="clearfix"></div>
                                                                                    <div class="payment_details_div  hide "
                                                                                         data-type="card">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="card_number_0">Card
                                                                                                    Number</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Card Number"
                                                                                                       id="card_number_0"
                                                                                                       name="payment[0][card_number]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="card_holder_name_0">Card
                                                                                                    holder name</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Card holder name"
                                                                                                       id="card_holder_name_0"
                                                                                                       name="payment[0][card_holder_name]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="card_transaction_number_0">Card
                                                                                                    Transaction
                                                                                                    No.</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Card Transaction No."
                                                                                                       id="card_transaction_number_0"
                                                                                                       name="payment[0][card_transaction_number]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="clearfix"></div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label for="card_type_0">Card
                                                                                                    Type</label>
                                                                                                <select class="form-control"
                                                                                                        id="card_type_0"
                                                                                                        name="payment[0][card_type]">
                                                                                                    <option value="credit">
                                                                                                        Credit Card
                                                                                                    </option>
                                                                                                    <option value="debit">
                                                                                                        Debit Card
                                                                                                    </option>
                                                                                                    <option value="visa">
                                                                                                        Visa
                                                                                                    </option>
                                                                                                    <option value="master">
                                                                                                        MasterCard
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label for="card_month_0">Month</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Month"
                                                                                                       id="card_month_0"
                                                                                                       name="payment[0][card_month]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label for="card_year_0">Year</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Year"
                                                                                                       id="card_year_0"
                                                                                                       name="payment[0][card_year]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label for="card_security_0">Security
                                                                                                    Code</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Security Code"
                                                                                                       id="card_security_0"
                                                                                                       name="payment[0][card_security]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="clearfix"></div>
                                                                                    </div>
                                                                                    <div class="payment_details_div  hide "
                                                                                         data-type="cheque">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="cheque_number_0">Cheque
                                                                                                    No.</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Cheque No."
                                                                                                       id="cheque_number_0"
                                                                                                       name="payment[0][cheque_number]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="payment_details_div  hide "
                                                                                         data-type="bank_transfer">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="bank_account_number_0">Bank
                                                                                                    Account No</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Bank Account No"
                                                                                                       id="bank_account_number_0"
                                                                                                       name="payment[0][bank_account_number]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="payment_details_div  hide "
                                                                                         data-type="custom_pay_1">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="transaction_no_1_0">Transaction
                                                                                                    No.</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Transaction No."
                                                                                                       id="transaction_no_1_0"
                                                                                                       name="payment[0][transaction_no_1]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="payment_details_div  hide "
                                                                                         data-type="custom_pay_2">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="transaction_no_2_0">Transaction
                                                                                                    No.</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Transaction No."
                                                                                                       id="transaction_no_2_0"
                                                                                                       name="payment[0][transaction_no_2]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="payment_details_div  hide "
                                                                                         data-type="custom_pay_3">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="transaction_no_3_0">Transaction
                                                                                                    No.</label>
                                                                                                <input class="form-control"
                                                                                                       placeholder="Transaction No."
                                                                                                       id="transaction_no_3_0"
                                                                                                       name="payment[0][transaction_no_3]"
                                                                                                       type="text"
                                                                                                       value="">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="note_0">Payment
                                                                                                note:</label>
                                                                                            <textarea
                                                                                                    class="form-control"
                                                                                                    rows="3" id="note_0"
                                                                                                    name="payment[0][note]"
                                                                                                    cols="50"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" id="payment_row_index" value="1">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <button type="button"
                                                                            class="btn btn-primary btn-block"
                                                                            id="add-payment-row">Add Payment Row
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="sale_note">Sell note:</label>
                                                                        <textarea class="form-control" rows="3"
                                                                                  placeholder="Sell note"
                                                                                  name="sale_note" cols="50"
                                                                                  id="sale_note"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="staff_note">Staff note:</label>
                                                                        <textarea class="form-control" rows="3"
                                                                                  placeholder="Staff note"
                                                                                  name="staff_note" cols="50"
                                                                                  id="staff_note"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="box box-solid bg-orange">
                                                                <div class="box-body">
                                                                    <div class="col-md-12">
                                                                        <strong>
                                                                            Total Items:
                                                                        </strong>
                                                                        <br/>
                                                                        <span class="lead text-bold total_quantity">0</span>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <hr>
                                                                        <strong>
                                                                            Total Payable:
                                                                        </strong>
                                                                        <br/>
                                                                        <span class="lead text-bold total_payable_span">0</span>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <hr>
                                                                        <strong>
                                                                            Total Paying:
                                                                        </strong>
                                                                        <br/>
                                                                        <span class="lead text-bold total_paying">0</span>
                                                                        <input type="hidden" id="total_paying_input">
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <hr>
                                                                        <strong>
                                                                            Change Return:
                                                                        </strong>
                                                                        <br/>
                                                                        <span class="lead text-bold change_return_span">0</span>
                                                                        <input class="form-control change_return input_number"
                                                                               required id="change_return"
                                                                               placeholder="Amount" readonly
                                                                               name="change_return" type="hidden"
                                                                               value="0">
                                                                        <!-- <span class="lead text-bold total_quantity">0</span> -->
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <hr>
                                                                        <strong>
                                                                            Balance:
                                                                        </strong>
                                                                        <br/>
                                                                        <span class="lead text-bold balance_due">0</span>
                                                                        <input type="hidden" id="in_balance_due"
                                                                               value=0>
                                                                    </div>


                                                                </div>
                                                                <!-- /.box-body -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary" id="pos-save">Finalize
                                                        Payment
                                                    </button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <!-- Used for express checkout card transaction -->
                                    <div class="modal fade" tabindex="-1" role="dialog" id="card_details_modal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Card transaction details</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="card_number">Card Number</label>
                                                                    <input class="form-control"
                                                                           placeholder="Card Number" id="card_number"
                                                                           autofocus name="" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="card_holder_name">Card holder
                                                                        name</label>
                                                                    <input class="form-control"
                                                                           placeholder="Card holder name"
                                                                           id="card_holder_name" name="" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="card_transaction_number">Card
                                                                        Transaction No.</label>
                                                                    <input class="form-control"
                                                                           placeholder="Card Transaction No."
                                                                           id="card_transaction_number" name=""
                                                                           type="text">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="card_type">Card Type</label>
                                                                    <select class="form-control select2" id="card_type"
                                                                            name="">
                                                                        <option value="visa" selected="selected">Visa
                                                                        </option>
                                                                        <option value="master">MasterCard</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="card_month">Month</label>
                                                                    <input class="form-control" placeholder="Month"
                                                                           id="card_month" name="" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="card_year">Year</label>
                                                                    <input class="form-control" placeholder="Year"
                                                                           id="card_year" name="" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="card_security">Security Code</label>
                                                                    <input class="form-control"
                                                                           placeholder="Security Code"
                                                                           id="card_security" name="" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="pos-save-card">
                                                        Finalize Payment
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit Shipping Modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog" id="confirmSuspendModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Suspend Sale</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label for="additional_notes">Suspend Note:</label>
                                                                <textarea class="form-control" rows="4"
                                                                          name="additional_notes" cols="50"
                                                                          id="additional_notes"></textarea>
                                                                <input id="is_suspend" name="is_suspend" type="hidden"
                                                                       value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="pos-suspend">
                                                        Save
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <!-- Edit discount Modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog" id="recurringInvoiceModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Subscribe </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            {{--<div class="form-group">--}}
                                                            {{--<label for="recur_interval">Subscription--}}
                                                            {{--Interval:*</label>--}}
                                                            {{--<div class="input-group">--}}
                                                            {{--<input class="form-control" required--}}
                                                            {{--style="width: 50%;" name="recur_interval"--}}
                                                            {{--type="number" id="recur_interval">--}}

                                                            {{--<select class="form-control" required--}}
                                                            {{--style="width: 50%;"--}}
                                                            {{--name="recur_interval_type">--}}
                                                            {{--<option value="days" selected="selected">Days--}}
                                                            {{--</option>--}}
                                                            {{--<option value="months">Months</option>--}}
                                                            {{--<option value="years">Years</option>--}}
                                                            {{--</select>--}}

                                                            {{--</div>--}}
                                                            {{--</div>--}}
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="recur_repetitions">No. of
                                                                    Repetitions:</label>
                                                                <input class="form-control" name="recur_repetitions"
                                                                       type="number" id="recur_repetitions">
                                                                <p class="help-block">If blank invoice will be generated
                                                                    infinite times</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->                                    </div>
                                <!-- /.box-body -->
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-5 col-sm-12">
                    <div class="box box-widget">
                        <div class="box-header with-border">

                            {{--<select class="select2" id="product_category" style="width:45% !important">--}}

                            {{--<option value="all">All Categories</option>--}}
                            {{--@if(!empty(session('categories_id')))--}}
                            {{--@php--}}
                            {{--$cat_array = explode(',', session('categories_id'));--}}
                            {{--@endphp--}}
                            {{--@foreach ($result['categories'] as $categories)--}}
                            {{--@if(in_array($categories->id,$cat_array))--}}

                            {{--<option value="{{ $categories->id }}">{{ $categories->name }}</option>--}}

                            {{--@endif--}}
                            {{--@if(!empty($categories->sub_categories))--}}
                            {{--<optgroup label="{{ $categories->name }}">--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="{{ $sub_category->sub_id }}">{{ $sub_category->sub_name }}</option>--}}
                            {{--</optgroup>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--@else--}}
                            {{--@foreach ($result['categories'] as $categories)--}}
                            {{--<option value="{{ $categories->id }}">{{ $categories->name }}</option>--}}

                            {{--@if(!empty($categories->sub_categories))--}}

                            {{--@foreach ($categories->sub_categories as $sub_category)--}}

                            {{--<optgroup label="{{ $categories->name }}">--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="{{ $sub_category->sub_id }}">{{ $sub_category->sub_name }}</option>--}}
                            {{--</optgroup>--}}
                            {{--@endforeach--}}


                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--@endif--}}
                            {{--<option value="3">Accessories</option>--}}
                            {{--<option value="18">Books</option>--}}
                            {{--<option value="12">Electronics</option>--}}
                            {{--<option value="21">Food &amp; Grocery</option>--}}
                            {{--<option value="1">Men&#039;s</option>--}}
                            {{--<option value="15">Sports</option>--}}
                            {{--<option value="2">Women&#039;s</option>--}}

                            {{--<optgroup label="Accessories">--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="6">Belts</option>--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="10">Sandal</option>--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="8">Shoes</option>--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="11">Wallets</option>--}}
                            {{--</optgroup>--}}
                            {{--<optgroup label="Books">--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="19">Autobiography</option>--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="20">Children&#039;s books</option>--}}
                            {{--</optgroup>--}}
                            {{--<optgroup label="Electronics">--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="13">Cell Phones</option>--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="14">Computers</option>--}}
                            {{--</optgroup>--}}
                            {{--<optgroup label="Men&#039;s">--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="4">Jeans</option>--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="5">Shirts</option>--}}
                            {{--</optgroup>--}}
                            {{--<optgroup label="Sports">--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="16">Athletic Clothing</option>--}}
                            {{--<i class="fa fa-minus"></i>--}}
                            {{--<option value="17">Exercise &amp; Fitness</option>--}}
                            {{--</optgroup>--}}
                            {{--</select>--}}

                            {{--&nbsp;--}}
                            {{--<select id="product_brand" class="select2" name="size" style="width:45% !important"><option value="all">All Brands</option><option value="1">Levis</option><option value="2">Espirit</option><option value="3">U.S. Polo Assn.</option><option value="4">Nike</option><option value="5">Puma</option><option value="6">Adidas</option><option value="7">Samsung</option><option value="8">Apple</option><option value="9">Acer</option><option value="10">Bowflex</option><option value="11">Oreo</option><option value="12">Sharewood</option><option value="13">Barilla</option><option value="14">Lipton</option></select>--}}
                            <h4>Product List</h4>


                            {{--<div class="form-group">--}}
                            {{--<label for="name"--}}
                            {{--class="col-sm-2 col-md-3 control-label">{{ trans('labels.Manufacturers') }} </label>--}}
                            {{--<div class="col-sm-10 col-md-4">--}}
                            {{--<select class="form-control" name="manufacturers_id">--}}
                            {{--<option value="">{{ trans('labels.ChooseManufacturers') }}</option>--}}
                            {{--@foreach ($result['manufacturer'] as $manufacturer)--}}
                            {{--<option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>--}}
                            {{--@endforeach--}}
                            {{--</select><span class="help-block"--}}
                            {{--style="font-weight: normal;font-size: 11px;margin-bottom: 0;">--}}
                            {{--{{ trans('labels.ChooseManufacturerText') }}.</span>--}}
                            {{--</div>--}}
                            {{--</div>--}}


                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                            </div>

                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <input type="hidden" id="suggestion_page" value="1">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="input-group add-on glo_searchbox">
                                        <input class="form-control" placeholder="Search by item name" name="srch-term"
                                               id="Search" type="text" onkeyup="getBuyEItem()">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="eq-height-row" id="product_list_body"></div>
                                </div>
                                <div class="col-md-12 text-center" id="suggestion_page_loader" style="display: none;">
                                    {{--<i class="fa fa-spinner fa-spin fa-2x"></i>--}}
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class="box box-widget  collapsed-box ">
                        <div class="box-header with-border">
                            <h3 class="box-title">Your Recent Transactions</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_final" data-toggle="tab" aria-expanded="true"><b><i
                                                        class="fa fa-check"></i> Final</b></a></li>

                                    {{--<li class=""><a href="#tab_quotation" data-toggle="tab" aria-expanded="false"><b><i--}}
                                    {{--class="fa fa-terminal"></i> Quotation</b></a></li>--}}

                                    {{--<li class=""><a href="#tab_draft" data-toggle="tab" aria-expanded="false"><b><i--}}
                                    {{--class="fa fa-terminal"></i> Draft</b></a></li>--}}
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_final">
                                    </div>
                                    <div class="tab-pane" id="tab_quotation">
                                    </div>
                                    <div class="tab-pane" id="tab_draft">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </section>

        <!-- This will be printed -->
        <section class="invoice print_section" id="receipt_section">
        </section>
        <div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="post" action="{{url('admin/customer_add')}}">
                        <input name="_token" type="hidden" value="{{@csrf_token()}}">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Add a new contact</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="cname">Customer Name:*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <input class="form-control" placeholder="Customer's Full Name" required
                                                   name="cname"
                                                   type="text" id="cname">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="contact">Contact Number:*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-mobile"></i>
                                            </span>
                                            <input class="form-control" required placeholder="Enter Contact No."
                                                   name="contact"
                                                   type="text" id="contact">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Customer Full Address:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-map-marker"></i>
                                            </span>
                                            <input class="form-control" placeholder="Enter Full Address" name="address"
                                                   type="text"
                                                   id="address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Customer Details</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog --></div>
        <!-- /.content -->
        <div class="modal fade register_details_modal" tabindex="-1" role="dialog"
             aria-labelledby="gridSystemModalLabel">
        </div>

        <div class="modal fade close_register_modal" tabindex="-1" role="dialog"
             aria-labelledby="gridSystemModalLabel">
        </div>
        <!-- quick product modal -->
        <div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>


        <!-- This will be printed -->
        <section class="invoice print_section" id="receipt_section">
        </section>

    </div>
    <div class="modal fade" id="todays_profit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Today's profit</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modal_today" value="2019-04-19">
                    <table class="table table-striped">
                        <tr>
                            <th>Opening Stock:</th>
                            <td>
                <span class="modal_opening_stock">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                            </td>
                            <th>Closing stock:</th>
                            <td>
                <span class="modal_closing_stock">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Total purchase:</th>
                            <td>
                 <span class="modal_total_purchase">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                            </td>
                            <th>Total Sales:</th>
                            <td>
                 <span class="modal_total_sell">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Stock Adjustment:</th>
                            <td>
                 <span class="modal_total_adjustment">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                            </td>
                            <th>Total Stock Recovered:</th>
                            <td>
                 <span class="modal_total_recovered">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Expense:</th>
                            <td colspan="3">
                 <span class="modal_total_expense">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Transfer Shipping Charges:</th>
                            <td colspan="3">
                 <span class="modal_total_transfer_shipping_charges">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                            </td>
                        </tr>
                    </table>
                    <h3 class="text-center">Net Profit: <span class="modal_net_profit">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>            <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="no-print text-center text-info">
        <!-- To the right -->
        <!-- <div class="pull-right hidden-xs">
          Anything you want
        </div> -->
        <!-- Default to the left -->
        <small>
            <b>7 EYE IT Solutions | Copyright &copy; 2019 All rights reserved.</b>
        </small>
    </footer>
    <audio id="success-audio">
        <source src="https://pos.ultimatefosters.com/audio/success.ogg?v=35" type="audio/ogg">
        <source src="https://pos.ultimatefosters.com/audio/success.mp3?v=35" type="audio/mpeg">
    </audio>
    <audio id="error-audio">
        <source src="https://pos.ultimatefosters.com/audio/error.ogg?v=35" type="audio/ogg">
        <source src="https://pos.ultimatefosters.com/audio/error.mp3?v=35" type="audio/mpeg">
    </audio>
    <audio id="warning-audio">
        <source src="https://pos.ultimatefosters.com/audio/warning.ogg?v=35" type="audio/ogg">
        <source src="https://pos.ultimatefosters.com/audio/warning.mp3?v=35" type="audio/mpeg">
    </audio>

</div>

<script type="text/javascript">
    base_path = "https://pos.ultimatefosters.com";
</script>

<!--[if lt IE 9]>
<!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=$asset_v"></script>-->
<!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=$asset_v"></script>-->
{{--<![endif]-->--}}

<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/pace/pace.min.js?v=35"></script>

<!-- jQuery 2.2.3 -->
<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/plugins/jquery-ui/jquery-ui.min.js?v=35"></script>
<!-- Bootstrap 3.3.6 -->
<script src="https://pos.ultimatefosters.com/bootstrap/js/bootstrap.min.js?v=35"></script>
<!-- iCheck -->
<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/iCheck/icheck.min.js?v=35"></script>
<!-- Select2 -->
<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/select2/select2.full.min.js?v=35"></script>
<!-- Add language file for select2 -->
<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/select2/lang/en.js?v=35"></script>
<!-- bootstrap datepicker -->
<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/datepicker/bootstrap-datepicker.min.js?v=35"></script>
<!-- DataTables -->
<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/DataTables/datatables.min.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/DataTables/pdfmake-0.1.32/pdfmake.min.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/DataTables/pdfmake-0.1.32/vfs_fonts.js?v=35"></script>

<!-- jQuery Validator -->
<script src="https://pos.ultimatefosters.com/js/jquery-validation-1.16.0/dist/jquery.validate.min.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/js/jquery-validation-1.16.0/dist/additional-methods.min.js?v=35"></script>

<!-- Toastr -->
<script src="https://pos.ultimatefosters.com/plugins/toastr/toastr.min.js?v=35"></script>
<!-- Bootstrap file input -->
<script src="https://pos.ultimatefosters.com/plugins/bootstrap-fileinput/fileinput.min.js?v=35"></script>
<!--accounting js-->
<script src="https://pos.ultimatefosters.com/plugins/accounting.min.js?v=35"></script>

<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/daterangepicker/moment.min.js?v=35"></script>

<script src="https://pos.ultimatefosters.com/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js?v=35"></script>

<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/daterangepicker/daterangepicker.js?v=35"></script>

{{--<script src="https://pos.ultimatefosters.com/AdminLTE/plugins/ckeditor/ckeditor.js?v=35"></script>--}}

<script src="https://pos.ultimatefosters.com/plugins/sweetalert/sweetalert.min.js?v=35"></script>

<script src="https://pos.ultimatefosters.com/plugins/bootstrap-tour/bootstrap-tour.min.js?v=35"></script>

<script src="https://pos.ultimatefosters.com/plugins/printThis.js?v=35"></script>

<script src="https://pos.ultimatefosters.com/plugins/screenfull.min.js?v=35"></script>

<script src="https://pos.ultimatefosters.com/plugins/moment-timezone-with-data.min.js?v=35"></script>
<script>
    moment.tz.setDefault('America/Phoenix');
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.fn.dataTable.ext.errMode = 'throw';
    });

    var financial_year = {
        start: moment('2019-01-01'),
        end: moment('2019-12-31'),
    }
    //Default setting for select2
    $.fn.select2.defaults.set("language", "en");

    var datepicker_date_format = "mm/dd/yyyy";
    var moment_date_format = "MM/DD/YYYY";
    var moment_time_format = "HH:mm";

    var app_locale = "en";
    var non_utf8_languages = [
        "ar",
        "hi",
    ];
</script>

<!-- Scripts -->
<script src="https://pos.ultimatefosters.com/js/AdminLTE-app.js?v=35"></script>

<script src="https://pos.ultimatefosters.com/js/lang/en.js?v=35"></script>

{{--<script src="https://pos.ultimatefosters.com/js/functions.js?v=35"></script>--}}
<script src="{!! URL::to('public/pos/js/functions.js?v=35') !!}"></script>

<script src="https://pos.ultimatefosters.com/js/common.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/js/app.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/js/help-tour.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/plugins/calculator/calculator.js?v=35"></script>

<script src="{!! URL::to('public/js/pos.js?v=35') !!}"></script>
<script src="https://pos.ultimatefosters.com/js/printer.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/js/product.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/js/opening_stock.js?v=35"></script>
<script src="https://pos.ultimatefosters.com/plugins/mousetrap/mousetrap.min.js?v=35"></script>

<script type="text/javascript">

    $(function () {
        var availableTags = [];

        $.get('{{ url('admin/getproducts') }}', function (data) {
            for (var i = 0; i < data.length; i++) {
                availableTags[i] = data[i].products_name;
            }
        });
        $("#search_product").autocomplete({
            source: availableTags
        });
    });

    var append_norecord_e = '<div class="col-sm-12 no_block" id="no_record_found_block_e"><div class="adver_list_row"><span class="list_no_record">' +
            '< No Record Available ></span></div></div>';
    function getBuyEItem() {
        var check_rowcount = $('.target').length;
        if (check_rowcount > 0) {
            var input = document.getElementById("Search");
            var filter = input.value.toLowerCase();
            var nodes = document.getElementsByClassName('target');
            for (i = 0; i < nodes.length; i++) {
                if (nodes[i].innerText.toLowerCase().includes(filter)) {
                    nodes[i].style.display = "block";
                    $('#no_record_found_block_e').remove();
                } else {
                    nodes[i].style.display = "none";
                }
            }
            if ($('.target:visible').length == 0) {
                $('.no_block').remove();
                $('#product_list_body').append(append_norecord_e);
            } else {
                $('#product_list_body').find('.no_block').remove();
            }
        }
    }

    function product_list_body() {
        $.get('{{ url('admin/product_list_body') }}', {tid: 1}, function (data) {
            $('#product_list_body').html(data);
        });
    }

    function getProductRow(pid) {
        $.get('{{ url('admin/getProductRow') }}', {pid: pid}, function (data) {
//            $('#product_list_body').html(data);
            $('table#pos_table tbody').append(data).find('input.pos_quantity');
            pos_total_row();
        });
    }
    function getProductRowScan(dis) {
        $.get('{{ url('admin/getProductRowScan') }}', {barcode: $(dis).val()}, function (data) {
//            $('#product_list_body').html(data);
            console.log(data);
            if (data != 'Not Available') {
                $(dis).val('');
                $('table#pos_table tbody').append(data).find('input.pos_quantity');
                pos_total_row();
            } else {
                toastr.error('Product Not Available');
            }
        });
    }

    $(document).ready(function () {

        product_list_body();
        //shortcut for express checkout
        Mousetrap.bind('shift+e', function (e) {
            e.preventDefault();
//            $('button.pos-express-finalize[data-pay_method="cash"]').trigger('click');
//            btnStorePOS
            $('form#store_pos').submit();
        });

        //shortcut for cancel checkout
        Mousetrap.bind('shift+c', function (e) {
            e.preventDefault();
            $('#pos-cancel').trigger('click');
        });

        //shortcut for draft checkout
//        Mousetrap.bind('shift+d', function (e) {
//            e.preventDefault();
//            $('#pos-draft').trigger('click');
//        });
//
//        //shortcut for draft pay & checkout
//        Mousetrap.bind('shift+p', function (e) {
//            e.preventDefault();
//            $('#pos-finalize').trigger('click');
//        });
//
//        //shortcut for edit discount
//        Mousetrap.bind('shift+i', function (e) {
//            e.preventDefault();
//            $('#pos-edit-discount').trigger('click');
//        });
//
//        //shortcut for edit tax
//        Mousetrap.bind('shift+t', function (e) {
//            e.preventDefault();
//            $('#pos-edit-tax').trigger('click');
//        });
//
//        //shortcut for add payment row
//        var payment_modal = document.querySelector('#modal_payment');
//        Mousetrap.bind('shift+r', function (e, combo) {
//            if ($('#modal_payment').is(':visible')) {
//                e.preventDefault();
//                $('#add-payment-row').trigger('click');
//            }
//        });

        //shortcut for add finalize payment
        var payment_modal = document.querySelector('#modal_payment');
        Mousetrap(payment_modal).bind('shift+f', function (e, combo) {
            if ($('#modal_payment').is(':visible')) {
                e.preventDefault();
                $('#pos-save').trigger('click');
            }
        });

        //Shortcuts to go recent product quantity
        shortcut_length_prev = 0;
        shortcut_position_now = null;

        Mousetrap.bind('f2', function (e, combo) {
            var length_now = $('table#pos_table tr').length;

            if (length_now != shortcut_length_prev) {
                shortcut_length_prev = length_now;
                shortcut_position_now = length_now;
            } else {
                shortcut_position_now = shortcut_position_now - 1;
            }

            var last_qty_field = $('table#pos_table tr').eq(shortcut_position_now - 1).contents().find('input.pos_quantity');
            if (last_qty_field.length >= 1) {
                last_qty_field.focus().select();
            } else {
                shortcut_position_now = length_now + 1;
                Mousetrap.trigger('f2');
            }
        });

        //On focus of quantity field go back to search when stop typing
        var timeout = null;
        $('table#pos_table').on('focus', 'input.pos_quantity', function () {
            var that = this;

            $(this).on('keyup', function (e) {

                if (timeout !== null) {
                    clearTimeout(timeout);
                }

//                var code = e.keyCode || e.which;
//                if (code != '9') {
//                    timeout = setTimeout(function () {
//                        $('input#search_product').focus().select();
//                    }, 5000);
//                }
            });
        });

        //shortcut to go to add new products
        Mousetrap.bind('f4', function (e) {
//            $('input#search_product').focus().select();
        });
    });


    //    toastr.success(result.msg);
</script>
@if(session()->has('message'))
    <script type="text/javascript">
        setTimeout(function () {
            toastr.success('{{ session()->get('message') }}');// success_noti("");
        }, 500);
    </script>
@endif

@if(session()->has('errmessage'))
    <script type="text/javascript">
        setTimeout(function () {
            toastr.error('{{ session()->get('errmessage') }}');
        }, 500);

    </script>
@endif
<!-- Call restaurant module if defined -->
<div class="modal fade view_modal" tabindex="-1" role="dialog"
     aria-labelledby="gridSystemModalLabel"></div>
</body>

</html>
