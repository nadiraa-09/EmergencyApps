<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="{{ asset('pages/shift') }}" class="nav-link {{ Request::routeIs('shift') ? 'active' : '' }}">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>
                Shift Employee
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ asset('pages/report') }}" class="nav-link {{ Request::routeIs('report') ? 'active' : '' }}">
            <i class=" nav-icon fas fa-table"></i>
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