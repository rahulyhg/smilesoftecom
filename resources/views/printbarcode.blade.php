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
    <div class="row">
            @php 
            $b_id = session('bar_id'); 
            $mqty = session('bar_qty'); 
            $data = \App\BarcodeModel::whereproduct_id($b_id)->first(); 
            @endphp 
            @for($i = 1; $i<=$mqty; $i++) 
            <div style="margin-bottom: 15px; width:640;">
                    <b>{{ $data->product_id }}</b>
                    {!! \Milon\Barcode\DNS1D::getBarcodeHTML($data->barcode, 'C128A') !!} 
                    <b>{{$data->barcode}} - MRP: {{ $data->selling_price }} Rs.</b>
                    
            </div>
        
            @endfor
    </div>
       

      
        
    

  



</body>

</html>