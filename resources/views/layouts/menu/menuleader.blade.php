<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="{{ asset('pages/emergency') }}" class="nav-link {{ Request::routeIs('emergency') ? 'active' : '' }}">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>
                Evacuation Attendance
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