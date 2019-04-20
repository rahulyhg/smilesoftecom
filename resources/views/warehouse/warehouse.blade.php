@extends('admin.layout')
@section('content')
    <style>
        .myheading {
            border-bottom: 1px solid #00000038;
            padding-left: 30px;
            padding-right: 30px;
        }

        .mybg {
            padding: 20px 25px;
            background: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15), 0 6px 6px rgba(0, 0, 0, 0.16);
        }

        .errorClass {
            border: red 1px solid;
        }
    </style>
    <div class="content-wrapper" style="background: #3c8dbc">
        <div class="container">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center m-t-lg mybg">
                            <h1>
                                <b>Store</b>
                            </h1>
                        {{--
                                        <hr> --}}


                        <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#store">Store List &nbsp;<i
                                                class="fa fa-home"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#addstore">Add Store &nbsp;<i
                                                class="fa fa-plus"></i></a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="store" class="tab-pane active"><br>
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-inverse">
                                        <tr>
                                            <th style="text-align: center">#</th>
                                            <th style="text-align: center">Name</th>
                                            <th style="text-align: center">Location</th>
                                            <th style="text-align: center">Username</th>
                                            <th style="text-align: center">Password</th>
                                            <th style="text-align: center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($warehouselist as $index => $item)
                                            <tr>
                                                <td>{{ $index+1 }}</td>
                                                <td>{{ ucwords($item->name) }}</td>
                                                <td>{{ ucwords($item->location) }}</td>
                                                <td><b>{{ $item->username }}</b></td>
                                                <td><b>{{ $item->password }}</b></td>
                                                <td><a href="{{ url('edit_store').'/'.base64_encode($item->id)}}">
                                                        <button class="btn btn-success btn-sm">Edit</button>
                                                    </a>
                                                    <button onclick="del_store({{ $item->id }});"
                                                            class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                                <div id="addstore" class="tab-pane fade"><br>
                                    <form action="{{ url('admin/insert_warehouse') }}" method="post" id="insert_warehouse">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="" class="pull-left">Store Name</label>
                                                    <input type="text" name="name" autocomplete="off"
                                                           class="form-control required" placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="" class="pull-left">Location</label>
                                                    <input type="text" name="location" autocomplete="off"
                                                           class="form-control required" placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="" class="pull-left">Username</label>
                                                    <input type="text" name="username" maxlength="25" id="username"
                                                           autocomplete="off" class="form-control required nospc"
                                                           placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="" class="pull-left">Password</label>
                                                    <input type="password" maxlength="25" name="password"
                                                           autocomplete="off"
                                                           class="form-control required" placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary pull-left">Create
                                                        Branch
                                                        &nbsp;<i
                                                                class="fa fa-home"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $("#username").focusout(function () {
            var username = $('#username').val();
            $.get('{{ url('check_store_username') }}', {
                username: username
            }, function (data) {
                if (data == 'Not Available') {
                    $('#username').val('');
                    // return false;
                    setTimeout(function () {
                        Swal.fire({
                            position: 'bottom',
                            title: 'Username Not Available',
                            showConfirmButton: false,
                            timer: 1200,
                            animation: false,
                            customClass: {
                                popup: 'animated fadeInDown'
                            }
                        })
                    }, 500);
                }
                //     console.log(data);
                //    alert(data);
            });
        });

        function del_store(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete This Store",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) = > {
                if (result.value
        )
            {

                $.get('{{ url('del_store') }}', {
                    did: id
                }, function (data) {


                    // return false;
                    setTimeout(function () {
                        Swal.fire({
                            position: 'bottom',
                            title: 'Store has Been Deleted',
                            showConfirmButton: false,
                            timer: 1200,
                            animation: false,
                            customClass: {
                                popup: 'animated fadeInDown'
                            }
                        })
                    }, 500);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);

                    //     console.log(data);
                    //    alert(data);
                });
            }
        })
        }
    </script>

@endsection