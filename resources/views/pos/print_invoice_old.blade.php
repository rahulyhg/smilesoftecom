<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bil Generate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="shortcut icon" type="images/png" href="images/dashbaord_fevicon.png"/>
    {{--<link rel="stylesheet" href="css/bootstrap.css"/>--}}
    <link rel="stylesheet" href="{{url('public/pos/css/bootstrap.min.css')}}"/>
    {{--<link rel="stylesheet" href="css/materialdesignicons.min.css"/>--}}
    {{--<script src="js/jquery-3.2.1.min.js"></script>--}}
    <script src="public/pos/js/bootstrap.min.js"></script>
    <style type="text/css">
        .body_color {
            background-color: #e9e9e9;
            margin: 0px;
            padding: 0px;
            font-family: Verdana;
            font-size: 10px;
        }

        .kot_table {
            background: #fff;
            position: relative;
            margin: 0px;
            padding: 0px;
        }

        .kot_table tbody tr td {
            padding: 0px;
        }

        .kot_table tbody tr td {
            border: none;
        }

        .kot_table tbody tr td hr {
            margin: 5px 0px;
            border: dashed thin #ccc;
        }

        .letter_txt {
            letter-spacing: -.5px;
            font-size: 10px;
        }

        .center_headtxt {
            display: inline-block;
            width: 100%;
            font-size: 12px;
        }

        .small_head {
            display: inline-block;
            width: 100%;
            font-size: 10px;
        }

        .right_txt {
            text-align: right;
        }
    </style>
    <script>
        function myFunction() {
//            window.print();
        }
    </script>
</head>
<body class="body_color" onload="myFunction();">
<div class="container">
    <table class="kot_table table">
        <tbody>
        <tr>
            <td colspan="6" style="text-align: center;">
                <img style="" src="{{url('public/sitelogo.png')}}" alt="Logo">
                {{--<br>--}}
                <span class="center_headtxt">  SMILE SHOP ONLINE STORES PVT LTD </span>
                <span class="small_head">CIN No. : 23729162058</span>
                <span class="small_head">PH NO. : 0788 - 4911210</span>
                <span class="small_head">GSTIN : 23AACCD5322K1ZX</span>
                <span class="small_head">SMILE SHOP BHILAI</span>
                <span class="small_head">600, KP Singh House, Opp Dwarika Restrarent</span>

                <span class="small_head">TAX INVOICE</span>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>
        <tr>
            {{--<td colspan="2">Bill No : {{$pos->invoice_no}}</td>--}}
            <td colspan="2">Bill No : {{$pos_main->invoice_no}}</td>
            {{--<td class="right_txt" colspan="2">Store Code # {{$pos->table_no}}</td>--}}
            <td class="" colspan="4">Store Code # 13</td>
        </tr>
        <tr>
            <td colspan="4">Date : {{ date_format(date_create($pos_main->invoice_date), "d-M-Y h:i A")}}</td>
            {{--<td colspan="2">Date : {{ Carbon\Carbon::now()->format('d-M-Y h:i A')}}</td>--}}
        </tr>
        <tr>
            <td colspan="2">Counter Person : {{$pos_main->staff->name}}</td>
{{--            <td colspan="4">Counter Person : {{$pos_main->staff->name}}</td>--}}
{{--            <td class="right_txt" colspan="2">Covers:{{$pos->covers}}</td>--}}
        </tr>
        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>
        <tr>
            {{--<td>HSN</td>--}}
            <td >Particular</td>
            <td class="">GST</td>
            <td class="">Qty</td>
            <td class="">MRP</td>
            <td class="">Rate</td>
            <td class="">Total</td>
        </tr>
        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>
        @php $counter = 1; $gst = 0; $vat = 0; $net_amount = 0; @endphp
        @foreach($pos_info as $item)
            @php
                $pro = \App\Products_Description::find($item->product_id);
                $product = \App\ProductsModel::find($item->product_id);
            $tax_rate = \App\TaxRatesModel::where(['tax_class_id'=>$product->products_tax_class_id])->first();

            $actual_price = ($item->price*100)/(100+(isset($tax_rate)?$tax_rate->tax_rate:'0'));
            $actual_price = round($actual_price,2);
            @endphp
            <tr>
                {{--<td>1</td>--}}
                {{--<td>2</td>--}}
                {{--<td>3</td>--}}
                {{--<td>4</td>--}}
                {{--<td>5</td>--}}
                {{--                <td class="letter_txt">{!!"KJGKJG"!!}</td>--}}
                <td class="letter_txt">{!!$pro->products_name!!}</td>
                <td class=" letter_txt">{{ round(isset($tax_rate)?$tax_rate->tax_rate:'0') }}</td>
                <td class=" letter_txt">{{ $item->qty }}</td>
                <td class="letter_txt">{{ $item->price }}</td>
                <td class=" letter_txt">{{  $actual_price}}</td>
                <td class=" letter_txt">{{ $item->qty * $actual_price}}</td>
            </tr>

            @php
                $net_amount += $item->qty * $actual_price;

        $gst += $net_amount * (isset($tax_rate)?$tax_rate->tax_rate:'0') / 100;

            @endphp
        @endforeach

        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="letter_txt">BILL AMOUNT</td>
            {{--<td colspan="2" class="right_txt letter_txt">{{$net_amount}}</td>--}}
            <td colspan="4" class="right_txt letter_txt">{{round($net_amount,2)}}</td>
        </tr>

        <tr>
            <td colspan="2" class="letter_txt">SGST ({{isset($tax_rate)?$tax_rate->tax_rate/2:'0'}}%)</td>
            <td colspan="4" class="right_txt letter_txt">{{round(($gst/2),2)}}</td>
        </tr>

        <tr>
            <td colspan="2" class="letter_txt">CGST ({{isset($tax_rate)?$tax_rate->tax_rate/2:'0'}}%)</td>
            <td colspan="4" class="right_txt letter_txt">{{round(($gst/2),2)}}</td>
        </tr>

        {{--<tr>--}}
        {{--<td colspan="2" class="letter_txt">VAT (5%)</td>--}}
        {{--<td colspan="2" class="right_txt letter_txt">{{$vat}}</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<td colspan="2" class="letter_txt">Round Off</td>--}}
        {{--<td colspan="2" class="right_txt letter_txt">0.22</td>--}}
        {{--</tr>--}}
        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="letter_txt">NET AMOUNT</td>
            <td colspan="4" class="right_txt letter_txt">{{round($net_amount+$gst)}}</td>
            {{--<td colspan="2" class="right_txt letter_txt">500</td>--}}
        </tr>
        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>

        <tr>
            <td colspan="6"><br><br></td>
        </tr>
        {{--<tr colspan="4">--}}
        {{--<td colspan="1" class="letter_txt">CASHIER</td>--}}
        {{--<td colspan="3" class="right_txt letter_txt">GUEST SIGNATURE</td>--}}
        {{--</tr>--}}
        <tr>
            {{--            <td colspan="4"> {{$pos->user->name}}</td>--}}
        </tr>
        <tr>
            <td colspan="6"><br><br></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;">
                <span class="center_headtxt">  ** YOU SAVED RS 7.00 ON MRP ** </span>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;">
                <span class="center_headtxt">  This is computer generated invoice </span>
            </td>
        </tr>
        <tr>
            <td colspan="6"><br></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>