
<div>
    <table id="scc" class="table table-bordered table-condensed" style="text-align: center">
        <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Customer Name</th>
            <th>Total Bill Amount</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice as $key => $inv)
            @php
                $cid = $inv->customer_id;
                $customer = \App\CustomerModel::where(['id'=>$cid])->first();
            @endphp
            <tr>
                <td>{{++$key}}</td>
                <td>{{ $inv->invoice_no }}</td>
                <td>{{ date('d-M-Y', strtotime($inv->invoice_date)) }}</td>
                {{--<td>{{ $inv->customer->name }}</td>--}}
                <td>{{ $customer->name}}</td>
                <td>{{ $inv->grand_total }}</td>
                <td>
                    <button class="btn btn-primary hidden-print" onclick="window.print();"><span class="fa fa-print" aria-hidden="true"></span> </button>
                </td>
            </tr>
        @endforeach
        <tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        var table = $('#dtTable').DataTable({
            "columnDefs": [
                {"width": "20px", "targets": 0}
            ]
        });

        $('.datatable-col').on('keyup change', function () {
            table.column($(this).attr('id')).search($(this).val()).draw();
        });
    });
</script>