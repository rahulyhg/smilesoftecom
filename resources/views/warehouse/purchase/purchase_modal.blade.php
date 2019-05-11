<script src="{{ url('js/validate.js') }}" xmlns="http://www.w3.org/1999/html"></script>
<h3>Create New Product</h3>
<hr>
<form action="{{url('purchase/product_upload')}}" id="holiday" method="post" enctype="multipart/form-data">
    {{--@csrf--}}
    <div class="sparkline12-graph">
        <div class="input-knob-dial-wrap">
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-mark-inner mg-b-22">
                        <label>Barcode</label>
                        <input type="text" class="form-control required" name="barcode" id="barcode" autocomplete="off"
                               placeholder="Enter Barcode Name"
                               value="{{ time() }}"
                               maxlength="100">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input-mark-inner mg-b-22">
                        <label>Product Type *</label><br>
                        <select class="form-control" id="products_type" name="products_type">
                            <option value="1">Packed</option>
                            <option value="0">Loose</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Brand Name *</label>
                        <select class="form-control typeDD requireDD" id="manufacturers_id" name="manufacturers_id">
                            <option value="0">-Select Brand-</option>
                            @foreach($brand as $brands)
                                <option value="{{$brands->id}}">{{$brands->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Select Catgeory *</label>
                        <select class="form-control typeDD requireDD" required id="category" name="category">
                            <option value="0">-Select Subcategory-</option>
                            @foreach($category as $brands)
                            <option value="{{$brands->categories_id}}">{{$brands->categories_slug}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-mark-inner mg-b-22">
                        <label>Product Name *</label>
                        <input type="text" class="form-control required" name="products_name" id="products_name" autocomplete="off"
                               placeholder="Enter Product Name">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="input-mark-inner mg-b-22">
                        <label>Select Sub-Category *</label>
                        <select class="form-control typeDD requireDD" required id="category" name="category">
                            <option value="0">-Select Category-</option>
                            @foreach($category as $brands)
                                <option value="{{$brands->categories_id}}">{{$brands->categories_slug}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Upload Image *</label>
                        <input type="file" class="form-control" required
                               type="text" placeholder="e.g. HSN123"
                               name="products_image" id="products_image">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="input-mark-inner mg-b-22">
                        <label>Product Description </label>
                        <textarea required type="text" class="form-control"
                                  style="resize: none"
                                  name="products_description"
                                  id="products_description" autocomplete="off"
                               placeholder="Describe the product..."
                               maxlength="255"></textarea>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Tax Class *</label>
                        <select required class="form-control typeDD requireDD" id="tax_class_id" name="tax_class_id">
                            @foreach($tax_class as $tax)
                                <option value="{{$tax->tax_class_id}}">{{$tax->tax_class_title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Product Purchase Price *</label>
                        <input type="text" class="form-control"
                               value="0.00"
                               required
                               name="products_purchase_price"
                               id="products_purchase_price">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Product Selling Price *</label>
                        <input class="form-control" required
                               type="text" value="0.00" name="selling_price" id="selling_price">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Products Model</label>
                        <input class="form-control" required
                               type="text" placeholder="e.g. HSN123"
                               name="products_model" id="products_model">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Product Weight</label>
                        <input class="form-control" required
                               type="text" placeholder="e.g. 10"
                               name="products_weight" id="products_weight">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-mark-inner mg-b-22">
                        <label>Weight Unit</label>
                        <select required class="form-control typeDD requireDD" id="products_weight_unit" name="products_weight_unit">
                            <option value="gram">Gram</option>
                            <option value="kilogram">Kilogram</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-12">
            <div class="input-mark-inner mg-b-22">
                <button class="btn btn-primary btn-block btn-sm" type="submit">Submit</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    window.onload = function (e) {
//        setTimeout(function () {
        $(".loader_main").css("display", "none");
//        }, 1000);
    };

    $('.dtp').datepicker({
        format: "dd-M-yyyy",
        maxViewMode: 2,
        // endDate: '-18y',
        endDate: '+0d',
        daysOfWeekHighlighted: "0",
        autoclose: true,
    });

</script>
<script>
            {{--Bank Details--}}
    var i = $('#itemTable tr').length;
    $(".addmore").on('click', function () {
        html = '<tr>';
        html += '<td><input class="case" type="checkbox"/></td>';

        html += '<td> ' +
            '<input type="text" class="form-control required" name="accountholder[]" id="accountholder_' + i + '" autocomplete="off" data-content="' + i + '" placeholder="Account Holder Name"> ' +
            '</td> ' +
            '<td> ' +
            '<input type="text" class="form-control required" name="bankname[]" id="bankname_' + i + '" autocomplete="off" data-content="' + i + '" placeholder="Enter Bank Name"> ' +
            '</td> ' +
            '<td> ' +
            '<input type="text" class="form-control required" name="accountnumber[]" id="accountnumber_' + i + '" autocomplete="off" data-content="' + i + '" placeholder="Enter Account Number"> ' +
            '</td> ' +
            '<td> ' +
            '<input type="text" data-content="1" class="form-control required" name="ifsc[]" id="ifsc_' + i + '" autocomplete="off" data-content="' + i + '" placeholder="Enter IFSC Code"> ' +
            '</td>';

        html += '</tr>';
        $('#itemTable').append(html);
        $('#accountholder_' + i).focus();
        i++;
        rowCounter('#itemTable > tbody > tr', '#msg');
    });
    $(document).on('change', '#check_all', function () {
        $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
    });

    //deletes the selected table rows
    $(".delete").on('click', function () {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
//        calculateTotal();
        rowCounter('#itemTable > tbody > tr', '#msg');

    });

    function rowCounter(_table, _msg) {
        //var rowCount = $(_table).length;
        //alert(rowCount);
        if ($(_table).length == 0) {
            $('#btn').addClass('disabled');
            $('#msg').text("Atleast single bank details should be added!!");
        }
        else {
            $('#btn').removeClass('disabled');
            $('#msg').text('');
        }
    }
    //    function calculateGrandTotal() {
    //        grand_total = 0;
    //        $('.row-total').each(function () {
    //            if ($(this).val() != '') grand_total += parseFloat($(this).val());
    //        });
    //        $('#grand_total').val(grand_total.toFixed(2));
    //    }
</script>
<script>
            {{--Personal Details--}}
    var j = $('#itemTable1 tr').length;
    $(".addmorec").on('click', function () {
        html = '<tr> <td><input class="case1" type="checkbox"/></td><td class="hidden"> <input type="text" class="form-control input-sm" id="person_' + j + '" name="person[]"> </td><td> <input type="text" class="form-control required" name="contactperson[]" id="contactperson_' + j + '" autocomplete="off" data-content="' + j + '" placeholder="Contact Person Name"> </td><td> <input type="date" class="form-control required dtp" name="dob[]" id="dob_' + j + '" autocomplete="off" data-content="' + j + '" placeholder="mm/dd/yyyy"> </td><td> <input type="date" class="form-control required dtp" name="marriage[]" id="marriage_' + j + '" autocomplete="off" data-content="' + j + '" placeholder="mm/dd/yyyy"> </td></tr>';

        $('#itemTable1').append(html);
        $('#contactperson_' + j).focus();
        j++;
        rowCounter('#itemTable1 > tbody > tr', '#msg');
    });
    $(document).on('change', '#check_all_person', function () {
        $('input[class=case1]:checkbox').prop("checked", $(this).is(':checked'));
    });


    //deletes the selected table rows
    $(".deletec").on('click', function () {
        $('.case1:checkbox:checked').parents("tr").remove();
        $('#check_all_person').prop("checked", false);
        rowCounter1('#itemTable1 > tbody > tr', '#msg');
    });

    function rowCounter1(_table, _msg) {
        //var rowCount = $(_table).length;
        //alert(rowCount);
        if ($(_table).length == 0) {
            $('#btn').addClass('disabled');
            $('#msg').text("Please provide atleast single person contact information!!");
        }
        else {
            $('#btn').removeClass('disabled');
            $('#msg').text('');
        }
    }

</script>
<script>
    $(function () {
        $(".typeDD").select2({
            placeholder: "Select"
        });

        $('input[name="manufacturers_id"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2019,
            maxYear: parseInt(moment().format('YYYY'), 10)
        });
    });
</script>