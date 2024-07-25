<nav id="sidebar" class="bg-light sidebar shadow-lg">
    <div class="position-sticky py-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active text-success fw-bold' : 'text-dark' }}" aria-current="page" href="{{ route('dashboard') }}">
                    <span><i class="bi bi-house-door me-3 text-success"></i>Dashboard</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('route1', 'route2') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="{{ request()->routeIs('route1', 'route2') ? 'true' : 'false' }}" aria-controls="menu1">
                    <span>สรุปแต่ละฝ่าย</span>
                    <i class="bi bi-chevron-down rotate-icon text-success"></i>
                </a>
                <div class="collapse ms-5 {{ request()->routeIs('route1', 'route2') ? 'show' : '' }}" id="menu1">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="mb-1 sub-menu-custom"><a href="{{ route('route1') }}" class="link-dark rounded text-decoration-none {{ request()->routeIs('route1') ? 'active' : '' }}">ผู้ป่วยนอก</a></li>
                        <li class="mb-1 sub-menu-custom"><a href="{{ route('route2') }}" class="link-dark rounded text-decoration-none {{ request()->routeIs('route2') ? 'active' : '' }}">ผู้ป่วยใน</a></li>
                    </ul>
                </div>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('report_index_authen_code') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#menu2" aria-expanded="{{ request()->routeIs('report_index_authen_code') ? 'true' : 'false' }}" aria-controls="menu2">
                    <span>รายงาน</span>
                    <i class="bi bi-chevron-down rotate-icon text-success"></i>
                </a>
                <div class="collapse ms-5 {{ request()->routeIs('report_index_authen_code') ? 'show' : '' }}" id="menu2">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="mb-1 sub-menu-custom"><a href="{{ route('report_index_authen_code') }}" class="link-dark rounded text-decoration-none {{ request()->routeIs('report_index_authen_code') ? 'active text-success' : 'text-dark' }}">การขอเลข Authen Code</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
