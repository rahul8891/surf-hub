<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- https://fontawesome.com/icons?d=gallery&c=users-people -->
    <a href="{{ route('adminIndex')}}" class="brand-link">
        <img src="{{ asset("/AdminLTE/dist/img/user2-160x160.jpg")}}" class="brand-image img-circle elevation-3"
            alt="User Image">
        <span
            class="brand-text font-weight-light">{{ucwords(Auth::user()->user_profiles->first_name.' '.Auth::user()->user_profiles->last_name)}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview ">
                    <a href="{{ route('adminIndex')}}" class="nav-link {{ activeMenu('adminIndex')}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ menuOpen('users') }}">
                    <a href="javascript:void(0);" class="nav-link {{ activeMainMenu('users') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('adminUserListIndex')}}"
                                class="nav-link {{ activeMenu('adminUserListIndex') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users Listing</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ menuOpen('pages') }}">
                    <a href="javascript:void(0);" class="nav-link {{ activeMainMenu('pages') }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Page Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('adminPageIndex')}}" class="nav-link {{ activeMenu('adminPageIndex') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Page Listing</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>