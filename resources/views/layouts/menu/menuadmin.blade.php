<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        {{-- <a href="/pages/" class="nav-link  {{ $title === 'Dashboard' ? 'active' : '' }}"> --}}
        {{-- <a href="/pages/" class="nav-link  {{ Request::is('dashboard') ? 'active' : '' }}"> --}}
        <a href="{{ asset('pages/') }}" class="nav-link {{ Request::routeIs('Dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li>
    <li class="nav-item {{ $menu === 'Leave Form' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ $menu === 'Leave Form' ? 'active' : '' }}">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>
                Leave Form
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ asset('pages/leaveform') }}" class="nav-link {{ Request::routeIs('leaveform') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Leave Request</p>
                </a>
            </li>
        </ul>
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