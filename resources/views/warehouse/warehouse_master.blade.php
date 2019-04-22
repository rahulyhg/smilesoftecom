<!DOCTYPE html>
<html>

<!-- meta contains meta taga, css and fontawesome icons etc -->
@include('warehouse.warehouse_meta')
<!-- ./end of meta -->

<body class=" hold-transition skin-blue sidebar-mini">
<!-- wrapper -->
<div class="wrapper">

    <!-- header contains top navbar -->
@include('warehouse.warehouse_header')
<!-- ./end of header -->

    <!-- left sidebar -->
@include('warehouse.sidebar')
<!-- ./end of left sidebar -->

    <!-- dynamic content -->
@yield('content')
<!-- ./end of dynamic content -->

    <!-- right sidebar -->
@include('admin.common.controlsidebar')
<!-- ./right sidebar -->
    @include('admin.common.footer')
</div>
<!-- ./wrapper -->

<!-- all js scripts including custom js -->
@include('admin.common.scripts')
<!-- ./end of js scripts -->

</body>
</html>
