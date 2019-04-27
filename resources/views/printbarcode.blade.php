<!DOCTYPE html>
<html>
<head>
    <title>Barcode</title>

    <style type="text/css">
        .row {
            margin: 0px;
        }

        h2 {
            margin-top: 60px;
        }
    </style>
</head>

<body>
<div style="width:100%;">

    <table width="100%" cellspacing="0" cellpadding="0">
        @php $b_id = session('bar_id');
            $mqty = session('bar_qty');
            $data = \App\BarcodeModel::whereproduct_id($b_id)->first();
            $i=1;
        @endphp
        <tr>
            @php $barcode =  \Milon\Barcode\DNS1D::getBarcodeHTML($data->barcode, 'C128A',1.2,23) @endphp
            @for($j = 1; $j<=$mqty; $j++)
                <td style="padding:15px 20px">
                    <b>{{ $data->prodis->products_name }}</b>
                    {!! $barcode !!}
                    <b>{{$data->barcode}} - MRP: {{ $data->selling_price }} Rs</b></td>
                @if($i==3)
        </tr>
        <tr>

        @php $i=0;
        @endphp @endif
        @php $i++;
        @endphp @endfor

    </table>

</div>


</body>

</html>