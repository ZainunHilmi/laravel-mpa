<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">POS BAHRI</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">PB</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('dashboard') }}">General Dashboard</a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Menu</li>
            <li class="nav-item dropdown {{ Request::is('admin/user*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-users"></i><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.user.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.user.index') }}">All Users</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ Request::is('admin/product*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-box"></i><span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.product.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.product.index') }}">All Products</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ Request::is('admin/order*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-shopping-cart"></i><span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.order.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.order.index') }}">All Orders</a>
                    </li>
                </ul>
            </li>
        </ul>

    </aside>
</div>