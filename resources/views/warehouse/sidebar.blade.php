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

                <li class="treeview {{ Request::is('products') ? 'active' : '' }} {{ Request::is('addproduct') ? 'active' : '' }} {{ Request::is('editattributes/*') ? 'active' : '' }} {{ Request::is('attributes') ? 'active' : '' }}  {{ Request::is('addattributes') ? 'active' : '' }} {{ Request::is('addproductattribute/*') ? 'active' : '' }} {{ Request::is('addinventory/*') ? 'active' : '' }} {{ Request::is('addproductimages/*') ? 'active' : '' }} ">
                    <a href="#">
                        <i class="fa fa-database"></i> <span>{{ trans('labels.link_products') }}</span> <i
                                class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('products') ? 'active' : '' }} {{ Request::is('addproduct') ? 'active' : '' }} {{ Request::is('editproduct/*') ? 'active' : '' }} {{ Request::is('addproductattribute/*') ? 'active' : '' }} {{ Request::is('addinventory/*') ? 'active' : '' }} {{ Request::is('addproductimages/*') ? 'active' : '' }}">
                            <a href="{{ URL::to('products')}}"><i
                                        class="fa fa-circle-o"></i> {{ trans('labels.link_all_products') }}</a></li>

                        <li class="{{ Request::is('attributes') ? 'active' : '' }}  {{ Request::is('addattributes') ? 'active' : '' }}  {{ Request::is('editattributes/*') ? 'active' : '' }}">
                            <a href="{{ URL::to('attributes' )}}"><i
                                        class="fa fa-circle-o"></i> {{ trans('labels.products_attributes') }}</a></li>
                    </ul>
                </li>
            <li class="treeview">
                <a href="{{ url('warehouse_staff')}}">
                    <i class="fa fa-home"></i> <span>Staff</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ url('purchase')}}">
                    <i class="fa fa-plus-square"></i> <span>Purchase</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ url('warehouse_stock')}}">
                    <i class="fa fa-industry"></i> <span>Stocks</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>