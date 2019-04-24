<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{url('public/images/default.png')}}" class="img-circle"
                     alt="Image">
            </div>
            <div class="pull-left info">
                <p></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">NAVIGATION</li>

                <li class="treeview">
                    <a href="{{ url('warehouse_dashboard')}}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="{{ url('warehouse_products')}}">
                        <i class="fa fa-dashboard"></i> <span>Products</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="{{ url('warehouse_staff')}}">
                        <i class="fa fa-home"></i> <span>Staff</span>
                    </a>
                </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>