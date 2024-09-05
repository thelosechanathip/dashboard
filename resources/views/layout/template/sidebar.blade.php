<nav id="sidebar" class="bg-light sidebar shadow-lg">
    <div class="position-sticky py-3">
        <ul class="nav flex-column">
            <li class="nav-item menu-custom">
                <a class="nav-link {{ request()->routeIs($dashboard) ? 'active text-success fw-bold' : 'text-dark' }}" aria-current="page" href="{{ route($dashboard) }}">
                    <span><i class="bi bi-house-door-fill me-3 text-success"></i>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('palliative_care') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#pcu" aria-expanded="{{ request()->routeIs('palliative_care') ? 'true' : 'false' }}" aria-controls="pcu">
                    <span>PCU</span>
                    <i class="bi bi-chevron-down rotate-icon text-success"></i>
                </a>
                <div class="collapse ms-5 {{ request()->routeIs('palliative_care') ? 'show' : '' }}" id="pcu">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="mb-1 sub-menu-custom"><a href="{{ route('palliative_care') }}" id="palliative_care" data-value="{{ $palliativeCareId->module_name }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('palliative_care') ? 'active text-success fw-bold' : 'text-dark' }}">Palliative Care</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('report_index_authen_code') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#menu2" aria-expanded="{{ request()->routeIs('report_index_authen_code') ? 'true' : 'false' }}" aria-controls="menu2">
                    <span>ห้องบัตร</span>
                    <i class="bi bi-chevron-down rotate-icon text-success"></i>
                </a>
                <div class="collapse ms-5 {{ request()->routeIs('report_index_authen_code') ? 'show' : '' }}" id="menu2">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="mb-1 sub-menu-custom"><a href="{{ route('report_index_authen_code') }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('report_index_authen_code') ? 'active text-success fw-bold' : 'text-dark' }}">Authen Code</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" id="menu_setting_admin">
                <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('mcarc_index') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#menu_setting" aria-expanded="{{ request()->routeIs('mcarc_index') ? 'true' : 'false' }}" aria-controls="menu_setting">
                    <span>Setting</span>
                    <i class="bi bi-chevron-down rotate-icon text-success"></i>
                </a>
                <div class="collapse ms-5 {{ request()->routeIs('mcarc_index') ? 'show' : '' }}" id="menu_setting">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="mb-1 sub-menu-custom"><a href="{{ route('mcarc_index') }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('mcarc_index') ? 'active text-success fw-bold' : 'text-dark' }}">Module access rights</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
