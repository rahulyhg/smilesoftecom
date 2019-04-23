<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Barcode</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

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

            @php $b_id = session('bar_id'); $mqty = session('bar_qty'); $data = \App\BarcodeModel::whereproduct_id($b_id)->first(); $i=1;
            @endphp 
            <tr>
                @for($j = 1; $j
                <=$mqty; $j++)
                 <td style="padding:15px 20px"><b>{{ $data->prodis->products_name }}</b> {!! \Milon\Barcode\DNS1D::getBarcodeHTML($data->barcode, 'C128A',1.2,23) !!}
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