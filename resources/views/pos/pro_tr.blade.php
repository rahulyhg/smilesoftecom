{{--$prod = \App\BarcodeModel::whereproduct_id($product->products_id)->first();--}}
@php
    $prod = \App\ProductsModel::find($products->products_id);

@endphp
<tr class="product_row" data-row_index="{{$products->products_id}}">
    <td>

        <div data-toggle="tooltip" data-placement="bottom" title=""{{--
             data-original-title="Edit product Unit Price and Tax"--}}>
		<span class="text-link text-info cursor-pointer" >
			{{$products->products_name}}

		</span>
        </div>
        <input type="hidden" class="enable_sr_no" value="0">
    </td>

    <td>


        <input type="hidden" name="products[1][product_id]" class="form-control product_id" value="{{$products->products_id}}">

        <input type="hidden" value="{{$products->products_id}}" name="products_id[]" class="row_variation_id">

        {{--<input type="hidden" value="{{$products->products_id}}" name="products_id[1][enable_stock]">--}}


        <div class="input-group input-number">
            <span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-down"><i
                            class="fa fa-minus text-danger"></i></button></span>
            <input type="text" data-min="1" id="qty{{$products->products_id}}" class="form-control pos_quantity input_number mousetrap input_quantity"
                   value="1.00" name="quantity[]" data-allow-overselling="false" data-decimal="0"
                   data-rule-abs_digit="true" data-msg-abs_digit="Decimal value not allowed" data-rule-required="true"
                   data-msg-required="This field is required" data-rule-max-value="30.0000" data-qty_available="30.0000"
                   data-msg-max-value="Only 30.00 Pc(s) available" data-msg_max_default="Only 30.00 Pc(s) available">
            <span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-up"><i
                            class="fa fa-plus text-success"></i></button></span>
        </div>

        <input type="hidden" name="products[1][product_unit_id]" value="1">
        {{--Pc(s)--}}

        <input type="hidden" class="base_unit_multiplier" name="products[1][base_unit_multiplier]" value="1">

        <input type="hidden" class="hidden_base_unit_sell_price" value="{{$prod->products_price}}">

    </td>
    <td class="">
        <input type="text" readonly name="price[]"
               class="form-control pos_unit_price_inc_tax input_number" value="{{$prod->products_price}}">
    </td>
    <td class="text-center v-center">
        <input type="hidden" name="totalAmt[]" class="form-control pos_line_total " value="{{$prod->products_price}}">
        <span class="display_currency pos_line_total_text " data-currency_symbol="true">₹ {{$prod->products_price}}</span>
    </td>
    <td class="text-center">
        <i class="fa fa-close text-danger pos_remove_row cursor-pointer" aria-hidden="true"></i>
    </td>
</tr>