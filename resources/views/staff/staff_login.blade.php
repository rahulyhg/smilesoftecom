<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="Vectorcoder" content="http://ionicecommerce.com">
    @if(!empty($web_setting[86]->value))
        <link rel="icon" href="{{asset('').$web_setting[86]->value}}" type="image/gif">
@endif
<!-- Bootstrap 3.3.6 -->
    <link href="{!! asset('resources/views/admin/bootstrap/css/bootstrap.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <link href="{!! asset('resources/views/admin/bootstrap/css/styles.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <!-- Font Awesome -->
    <link href="{!! asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') !!}"
          media="all" rel="stylesheet" type="text/css"/>
    <title>Staff Panel | Login</title>
    <link href="{!! asset('resources/views/admin/bootstrap/css/bootstrap.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <link href="{!! asset('resources/views/admin/bootstrap/css/styles.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <!-- Font Awesome -->
    <link href="{!! asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') !!}"
          media="all" rel="stylesheet" type="text/css"/>

    <!-- Select2 -->
    <link rel="stylesheet" href="{!! asset('resources/views/admin/plugins/select2/select2.min.css') !!}">

    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
          href="{!! asset('resources/views/admin/plugins/colorpicker/bootstrap-colorpicker.min.css') !!}">
    <!-- Ionicons -->
    <link href="{!! asset('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css') !!}" media="all"
          rel="stylesheet" type="text/css"/>
    <!-- daterange picker -->
    <link rel="stylesheet"
          href="{!! asset('resources/views/admin/plugins/daterangepicker/daterangepicker-bs3.css') !!}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{!! asset('resources/views/admin/plugins/datepicker/datepicker3.css') !!}">
    <!-- jvectormap -->
    <link href="{!! asset('resources/views/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css') !!}" media="all"
          rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="{!! asset('resources/views/admin/dist/css/AdminLTE.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="{!! asset('resources/views/admin/dist/css/skins/_all-skins.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="{!! asset('resources/views/admin/plugins/iCheck/all.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>

    <!-- Bootstrap time Picker -->
    <link rel="stylesheet"
          href="{!! asset('resources/views/admin/plugins/timepicker/bootstrap-timepicker.min.css') !!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  </head>
  <body class="hold-transition login-page">
  <!-- wrapper -->
</head>
<body>
<div class="hold-transition login-page">
    <div class="wrapper">

        <div class="login-box">
            <div class="login-logo">

                @if(empty($web_setting[15]->value))
                    @if($web_setting[66]->value=='1' and $web_setting[67]->value=='0')
                        <img src="{{url('resources/views/admin/images/admin_logo/logo-android-blue-v1.png')}}"
                             class="ionic-hide">
                        <img src="{{url('resources/views/admin/images/admin_logo/logo-ionic-blue-v1.png')}}"
                             class="android-hide">
                    @elseif($web_setting[66]->value=='1' and $web_setting[67]->value=='1' or $web_setting[66]->value=='0' and $web_setting[67]->value=='1')
                        <img src="{{url('resources/views/admin/images/admin_logo/logo-laravel-blue-v1.png')}}"
                             class="website-hide">
                    @endif
                @else
                    {{--<img style="width: 60%" src="{{url('resources/views/admin/images/admin_logo/logo-android-blue-v1.png')}}">--}}
                    <img style="width: 60%" src="{{url('public/sitelogo.png')}}" alt="Logo">

                @endif

                <div style="
    font-size: 25px;
"><b> Welcome </b> To Staff Panel
                </div>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                @if( count($errors) > 0)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">{{ trans('labels.Error') }}:</span>
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                @if(Session::has('loginError'))
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">{{ trans('labels.Error') }}:</span>
                        {!! session('loginError') !!}
                    </div>
                @endif
                {{--<div class="alert alert-danger" role="alert">--}}
                {{--<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>--}}
                {{--<span class="sr-only">Error: </span>--}}
                {{--</div>--}}

                <form action="{{url('staff_loginCheck')}}" method="post" class="form-validate">
                    <input type="hidden" value="{{csrf_token()}}">
                    <div class="form-group has-feedback">
                        <input type="email" name="username" id="username" class="form-control email-validate">
                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                     Please enter your valid Username.
                    </span>
                        <span class="help-block hidden"> Please enter your valid username.</span>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name='password' class='form-control field-validate' value="">
                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    Please enter your passwrod.
                    </span>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <span class="help-block hidden">
                        This field is required.
                    </span>

                    </div>
                    <img src="http://ionicecommerce.com/testcontroller1.php">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <input type="submit" value="Login" id="login" class="btn btn-primary btn-block btn-flat">
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.common.scripts')
</body>
</html>
