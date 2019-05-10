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

    {{--My Modal--}}
    <div id="my" class="modal modal-adminpro-general fullwidth-popup-InformationproModal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-close-area modal-close-df">
                    {{--<h5 id="mh" class="modal-title">Modal Heading</h5>--}}
                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                </div>
                <div class="modal-body" id="mb">
                    {{--<span class="adminpro-icon adminpro-informatio modal-check-pro information-icon-pro"> </span>--}}
                    {{--<h2>Information!</h2>--}}
                    {{--<p>The Modal plugin is a dialog box/popup window that is displayed on top of the current page</p>--}}
                </div>
                {{--<div class="modal-footer">--}}
                {{--<a data-dismiss="modal" href="#">Close</a>--}}
                {{--<a href="#">Process</a>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

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
@include('warehouse.common.scripts')
<!-- ./end of js scripts -->

</body>
</html>
