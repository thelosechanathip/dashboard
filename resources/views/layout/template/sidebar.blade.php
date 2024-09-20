<nav id="sidebar" class="bg-light sidebar shadow-lg">
    <div class="position-sticky py-3">
        <ul class="nav flex-column">
                @foreach($sidebarMainMenuModel as $smmm)
                    @if($smmm->link_url_or_route != '')
                        <li class="nav-item menu-custom sidebar-main-menu">
                            <a class="nav-link sidebar-main-menu-a {{ request()->routeIs($smmm->link_url_or_route) ? 'active text-success fw-bold' : 'text-dark' }}" aria-current="page" href="{{ route($smmm->link_url_or_route) }}" data-value="{{ $smmm->status_id }}">
                                <span><i class="bi bi-house-door-fill me-3 text-success"></i>{{ $smmm->sidebar_main_menu_name }}</span>
                            </a>
                        </li>
                    @else
                        @if($smmm->sidebarSub1Menu->isNotEmpty())
                            <li class="nav-item sidebar-main-menu">
                                <a class="nav-link dropdown-toggle text-dark sidebar-main-menu-a {{ request()->routeIs($smmm->sidebarSub1Menu->pluck('link_url_or_route')->toArray()) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#{{ $smmm->sidebar_main_menu_name }}" aria-expanded="{{ request()->routeIs($smmm->sidebarSub1Menu->pluck('link_url_or_route')->toArray()) ? 'true' : 'false' }}" aria-controls="{{ $smmm->sidebar_main_menu_name }}" data-value="{{ $smmm->status_id }}">
                                    <span>{{ $smmm->sidebar_main_menu_name }}</span>
                                    <i class="bi bi-chevron-down rotate-icon text-success"></i>
                                </a>
                                <div class="collapse ms-5 {{ request()->routeIs($smmm->sidebarSub1Menu->pluck('link_url_or_route')->toArray()) ? 'show' : '' }}" id="{{ $smmm->sidebar_main_menu_name }}">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        @foreach($smmm->sidebarSub1Menu as $ssmm)
                                            <li class="mb-1 sub-menu-custom sidebar-sub1-menu">
                                                <a href="{{ route($ssmm->link_url_or_route, ['id' => $ssmm->id]) }}" class="link-dark p-1 rounded text-decoration-none sidebar-sub1-menu-a {{ request()->routeIs($ssmm->link_url_or_route) ? 'active text-success fw-bold' : 'text-dark' }}" data-value="{{ $ssmm->status_id }}">
                                                    {{ $ssmm->sidebar_sub1_menu_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @endif
                @endforeach
            {{-- <li class="nav-item">
                <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('palliative_care') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#pcu" aria-expanded="{{ request()->routeIs('palliative_care') ? 'true' : 'false' }}" aria-controls="pcu">
                    <span>PCU</span>
                    <i class="bi bi-chevron-down rotate-icon text-success"></i>
                </a>
                <div class="collapse ms-5 {{ request()->routeIs('palliative_care') ? 'show' : '' }}" id="pcu">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="mb-1 sub-menu-custom"><a href="{{ route('palliative_care') }}" id="palliative_care" data-value="{{ $palliativeCareStatusId->status_id }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('palliative_care') ? 'active text-success fw-bold' : 'text-dark' }}">Palliative Care</a></li>
                    </ul>
                </div>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('report_index_authen_code') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#test" aria-expanded="{{ request()->routeIs('report_index_authen_code') ? 'true' : 'false' }}" aria-controls="test">
                    <span>ห้องบัตร</span>
                    <i class="bi bi-chevron-down rotate-icon text-success"></i>
                </a>
                <div class="collapse ms-5 {{ request()->routeIs('report_index_authen_code') ? 'show' : '' }}" id="test">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li class="mb-1 sub-menu-custom"><a href="{{ route('report_index_authen_code') }}" id="report_index_authen_code" data-value="{{ $authenCodeStatusId->status_id }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('report_index_authen_code') ? 'active text-success fw-bold' : 'text-dark' }}">Authen Code</a></li>
                    </ul>
                </div>
            </li> --}}
            @if($data['groupname'] == 'ผู้ดูแลระบบ')
                <li class="nav-item" id="menu_setting_admin">
                    <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('mcarc_index', 'sm_index') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#menu_setting" aria-expanded="{{ request()->routeIs('mcarc_index', 'sm_index') ? 'true' : 'false' }}" aria-controls="menu_setting">
                        <span>Setting</span>
                        <i class="bi bi-chevron-down rotate-icon text-success"></i>
                    </a>
                    <div class="collapse ms-5 {{ request()->routeIs('mcarc_index', 'sm_index') ? 'show' : '' }}" id="menu_setting">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="mb-1 sub-menu-custom"><a href="{{ route('mcarc_index') }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('mcarc_index') ? 'active text-success fw-bold' : 'text-dark' }}">Module access rights</a></li>
                            <li class="mb-1 sub-menu-custom"><a href="{{ route('sm_index') }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('sm_index') ? 'active text-success fw-bold' : 'text-dark' }}">Sidebar Menu</a></li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>
