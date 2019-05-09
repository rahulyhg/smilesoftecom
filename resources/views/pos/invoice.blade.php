<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>

    <title>Editable Invoice</title>

    <link rel='stylesheet' type='text/css' href='public/css/style.css'/>
    <link rel='stylesheet' type='text/css' href='public/css/print.css' media="print"/>
    <script type='text/javascript' src='public/js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='public/js/example.js'></script>

    <script>
        $(function () {
            print();
        })
    </script>
</head>

<body>

<div id="page-wrap">
    @php
        $pos_main = \App\POSModel::find($pos_main->id);
        $sid = $pos_main->sid;
        $warehouse = \App\WarehouseModel::where(['id'=>$pos_main->wid])->first();
        $customer = \App\CustomerModel::where(['id'=>$pos_main->customer_id])->first();
        $staff = \App\WarehouseStaffModel::where(['id'=>$sid])->first();
    @endphp

    <textarea id="header" readonly>{{strtoupper($warehouse->name)}}</textarea>

    <div id="identity" style="margin-top: -20px;">
        <label style="alignment: center">
            {{$warehouse->location}}
            Contact: (+91) 99814-35702
        </label>
        <div id="logo">
            {{--<h1>{{$warehouse->name}}</h1>--}}
            {{--<img id="image" src="public/images/logo.png" alt="logo" />--}}
        </div>

    </div>
    <div id="customer">

        {{--<lable id="customer-title">--}}
        {{--{{$customer->name}}--}}
        {{--</lable>--}}

        <table id="meta" style="width: 100%;">
            <tr>
                <td class="meta-head">Customer#</td>
                <td>
                    <label>{{$customer->name}}</label>
                    <input type="hidden" name="cid" id="cid" value="{{$customer->name}}">
                </td>
                <td class="meta-head">Invoice ID#</td>
                <td>
                    <label>{{$pos_main->invoice_no}}</label>
                    <input type="hidden" name="invoice_id" id="invoice_id" value="{{$pos_main->invoice_no}}">
                </td>
                <td class="meta-head">Date#</td>
                <td>
                    <label>{{\Carbon\Carbon::now()->format('M d, Y')}}</label>
                    <input type="hidden" name="invoice_date" id="invoice_date" value="{{\Carbon\Carbon::now()}}">
                </td>
            </tr>
        </table>
    </div>
    <table id="items">
        <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Unit Cost</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        @php
            $pos_description = \App\POSInfoModel::where(['pos_id'=>$pos_main->id])->get();
            $total = 0;
        @endphp
        @foreach($pos_info as $items => $pd)
            @php
                $total += ($pd->price)*($pd->qty)
            @endphp
            <tr class="item-row">
                <td class="item-name">
                    <label>
                        {{++$items}}
                    </label>
                </td>
                <td class="description">
                    <label>
                        @php
                            $product = \App\Products_Description::where('products_id', $pd->product_id)->first();
                        @endphp
                        {{$product->products_name}}
                    </label>
                </td>
                <td>
                    <label class="cost">
                        {{$pd->price}}
                    </label>
                </td>
                <td>
                    <label class="qty">
                        {{$pd->qty}}
                    </label>
                </td>
                <td>
                    <label class="price">
                        {{$pd->qty*$pd->price}}
                    </label>
                </td>
            </tr>
        @endforeach
        <tr id="hiderow">
            <td colspan="5">
                {{--<a id="addrow" href="javascript:;" title="Add a row">Add a row</a>--}}
            </td>
        </tr>

        <tr>
            <td colspan="2" class="blank"></td>
            <td colspan="2" class="total-line">Subtotal</td>
            <td class="total-value">
                <div id="subtotal">{{$total}}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="blank"></td>
            <td colspan="2" class="total-line">Total</td>
            <td class="total-value">
                <div id="total">{{$total}}</div>
            </td>
        </tr>
        {{--<tr>--}}
        {{--<td colspan="2" class="blank"></td>--}}
        {{--<td colspan="2" class="total-line">Amount Paid</td>--}}

        {{--<td class="total-value">--}}
        {{--<textarea id="paid">$0.00</textarea>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<td colspan="2" class="blank"></td>--}}
        {{--<td colspan="2" class="total-line balance">Balance Due</td>--}}
        {{--<td class="total-value balance">--}}
        {{--<div class="due">$875.00</div>--}}
        {{--</td>--}}
        {{--</tr>--}}

    </table>

    <div id="terms">
        <h5>Terms</h5>
        {{--<lable>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</lable>--}}
        <lable>Thank you for shoping from SmileShop. Keep Smiling</lable>
    </div>

</div>

</body>

</html>