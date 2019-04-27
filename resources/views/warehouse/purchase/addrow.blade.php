<div id="thisis{{ $uid }}">

    <div align="right">
        <button type="button" class="btn btn-danger btn-sm" onclick="removerow({{ $uid }});">Remove</button>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <label for="" class="pull-left">&nbsp;Product Name</label>
            <input type="text" class="form-control" name="p_name[]" placeholder="Product Name">
        </div>
        <div class="col-sm-3">
            <label for="" class="pull-left">&nbsp;Brand</label>
            <select class=" typeDD requireDD" name="brand[]" style="width: 100%;">
                <option value="0">Select Brand</option>
                @foreach ($brand as $item)
                    <option value="{{ $item->manufacturers_id }}">{{ ucwords($item->manufacturers_name)}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">Select Category / Sub-Category</label>
                <select class=" typeDD requireDD" name="catid[]" style="width: 100%;">
                    <option value="">Select Category / Sub-Category</option>
                    @foreach ($catlist as $item)
                        <option value="{{ $item->categories_id }}">
                            <b>{{ ucwords($item->categories_slug)}}</b>
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
                <label for="name" class="pull-left" style="align: center">Loose / Pack</label>
                <select name="loose_pack[]" id="loose_pack" class="form-control">
                    <option value="0">Loose</option>
                    <option value="1">Pack</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">CP Excl Tax(₹)</label>
                <input type="text" class="form-control numberOnly" onkeyup="totamt({{ $uid }})" name="unit_price[]"
                       id="unit_price{{ $uid }}" placeholder="Enter Price">
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">QTY</label>
                <input type="text" onkeyup="totamt({{ $uid }})" class="form-control numberOnly" name="qty[]"
                       id="qty{{ $uid }}" placeholder="Enter Qty">
            </div>

        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">Free QTY</label>
                <input type="text" class="form-control numberOnly" name="f_qty[]" id="f_qty"
                       placeholder="Enter Free Qty">
            </div>

        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">Unit</label>
                <select name="unit[]" id="unit" class="form-control typeDD requireDD">
                    <option value="">Select unit</option>
                    @foreach($unit as $unit)
                        <option value="{{$unit->unit_id }}">{{$unit->unit_name}}</option>
                    @endforeach
                </select>

            </div>

        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">Total Amount</label>
                <input type="text" onkeypress="return false" onkeydown="return false" class="form-control"
                       name="t_amount[]" id="t_amount{{ $uid }}" placeholder="Enter Amount">


            </div>

        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">Scheme Discount</label>
                <input type="text" class="form-control" onkeyup="totamt({{ $uid }});" name="s_discount[]"
                       id="s_discount{{ $uid }}" placeholder="Enter Scheme Discount">


            </div>

        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">GST</label>
                <input type="text" class="form-control" onkeyup="totamt({{ $uid }});" name="gst[]" id="gst{{ $uid }}"
                       placeholder="Enter GST">


            </div>

        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">CGST</label>
                <input type="text" class="form-control" name="cgst[]" id="cgst{{ $uid }}" placeholder="Enter CGST">


            </div>

        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">SGST</label>
                <input type="text" class="form-control" name="sgst[]" id="sgst{{ $uid }}" placeholder="Enter SGST">


            </div>

        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">Total Cost Price (All Qty)</label>
                <input type="text" class="form-control" name="total_cost_price[]" id="total_cost_price{{ $uid }}"
                       placeholder="Enter Cost Price">


            </div>

        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">Cost Price (Per Unit)</label>
                <input type="text" class="form-control" name="cost_price[]" id="cost_price{{ $uid }}"
                       placeholder="Enter Cost Price">


            </div>

        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="name" class="pull-left" style="align: center">Selling Price (Per Unit)</label>
                <input type="text" class="form-control" name="selling_price[]" id="selling_price{{ $uid }}"
                       placeholder="Enter Selling Price">

            </div>

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".typeDD").select2({
                placeholder: "Select"
            });
        });
    </script>
    <hr>
</div>