<div>
    <table id="dtTable" class="table table-bordered table-condensed" style="text-align: center">
        <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Product Name</th>
            <th>Size</th>
            <th>BatchID</th>
            <th>Quantity</th>
            <th>Product Price</th>
            <th>Total Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; $tamt = 0;?>
        @foreach($purchase_details as $list)
            <tr>
                <td>{{$i}}</td>
                <td>{{ $list->product->product_name }}</td>
                <td>{{ $list->size->size_name }}</td>
                <td>{{ $list->batch_id }}</td>
                <td>{{ $list->qty }}</td>
                <td>{{ $list->price }}</td>
                <td>{{ $list->total }}</td>
            </tr>
        <?php $i++; $tamt += $list->total; ?>
        @endforeach
        <tbody>
    </table>
    <h4>Total Amount : {{$tamt}}</h4>
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