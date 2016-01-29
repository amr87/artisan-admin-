<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Session::get('user_data')['avatar'] }}" class="img-circle" alt="{{ Session::get('user_data')['name'] }}">
            </div>
            <div class="pull-left info">
                <p>{{ Session::get('user_data')['name'] }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!--        <li class="header">HEADER</li>-->
            <!-- Optionally, you can add icons to the links -->

            <li class="treeview">
                <a class="active" href="#"><i class="fa fa-user"></i> <span>Users Management</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li>  <a href="{{url('admin/users')}}"><i class="fa fa-users"></i> <span> Users </span></a></li>
                    <li>  <a  href="{{url('admin/roles')}}"> <i class="fa fa-lock"></i><span> Roles & Permissions </span></a></li>
                </ul>
            </li>

            <li><a href="{{url('admin/news')}}"><i class="fa fa-newspaper-o"></i> <span>News</span></a></li>
            <li ><a href="{{url('admin/places')}}"><i class="fa fa-map-marker"></i>Places<span></span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>