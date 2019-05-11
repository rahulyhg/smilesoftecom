<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Error Log</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>

    <table class="table table-striped  table-bordered">
        <thead class="thead-inverse">
            <tr>
                <th width="3%">#</th>
                <th width="85%">Error</th>
                <th width="12%">Time</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($errors as $in => $error) @if($in == 0)
            <tr style="background-color : #f3756e;">
                <td scope="row" style="color:white;">{{ $in+1 }}</td>
                <td style="color:white;"><b>{{ $error->error_msg }}</b></td>
                <td style="color:white;">{{ \Carbon\Carbon::parse($error->created_time)->format('d-M-Y H:i s') }}</td>
            </tr>
            @else
            <tr>
                <td scope="row">{{ $in+1 }}</td>
                <td><b>{{ $error->error_msg }}</b></td>
                <td>{{ \Carbon\Carbon::parse($error->created_time)->format('d-M-Y H:i s') }}</td>
            </tr>
            @endif @endforeach
        </tbody>
    </table>


</body>

</html>