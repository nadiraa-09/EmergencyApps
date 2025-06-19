<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        {{-- <a href="/pages/" class="nav-link  {{ $title === 'Dashboard' ? 'active' : '' }}"> --}}
        {{-- <a href="/pages/" class="nav-link  {{ Request::is('dashboard') ? 'active' : '' }}"> --}}
        <a href="{{ asset('pages/') }}" class="nav-link {{ Request::routeIs('') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li>
    <li class="nav-item {{ $menu === 'Master Data' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ $menu === 'Master Data' ? 'active' : '' }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('user') }}" class="nav-link {{ Request::routeIs('user') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ asset('pages/employee') }}" class="nav-link {{ Request::routeIs('employee') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Employee</p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="{{ asset('pages/emergency') }}" class="nav-link {{ Request::routeIs('emergency') ? 'active' : '' }}">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>
                Emergency Attendance
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ asset('pages/shift') }}" class="nav-link {{ Request::routeIs('shift') ? 'active' : '' }}">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>
                Shift Employee
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ asset('pages/report') }}" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                Report
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ asset('/logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
                Logout
            </p>
        </a>
    </li>
</ul>