<nav id="sidebar" class="bg-light sidebar shadow-lg mt-3">
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
            @if($data['groupname'] == 'ผู้ดูแลระบบ')
                <li class="nav-item" id="menu_setting_admin_it">
                    <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('it_index') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#menu_it" aria-expanded="{{ request()->routeIs('it_index') ? 'true' : 'false' }}" aria-controls="menu_it">
                        <span>IT</span>
                        <i class="bi bi-chevron-down rotate-icon text-success"></i>
                    </a>
                    <div class="collapse ms-5 {{ request()->routeIs('it_index') ? 'show' : '' }}" id="menu_it">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="mb-1 sub-menu-custom"><a href="{{ route('it_index') }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('it_index') ? 'active text-success fw-bold' : 'text-dark' }}">ระบบงาน IT</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item" id="menu_setting_admin">
                    <a class="nav-link dropdown-toggle text-dark {{ request()->routeIs('mcarc_index', 'sm_index', 'announcement_and_version_index') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#menu_setting" aria-expanded="{{ request()->routeIs('mcarc_index', 'sm_index', 'announcement_and_version_index') ? 'true' : 'false' }}" aria-controls="menu_setting">
                        <span>Setting</span>
                        <i class="bi bi-chevron-down rotate-icon text-success"></i>
                    </a>
                    <div class="collapse ms-5 {{ request()->routeIs('mcarc_index', 'sm_index', 'announcement_and_version_index') ? 'show' : '' }}" id="menu_setting">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="mb-1 sub-menu-custom"><a href="{{ route('mcarc_index') }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('mcarc_index') ? 'active text-success fw-bold' : 'text-dark' }}">กำหนดสิทธิ์การเข้าถึง</a></li>
                            <li class="mb-1 sub-menu-custom"><a href="{{ route('sm_index') }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('sm_index') ? 'active text-success fw-bold' : 'text-dark' }}">ตั้งค่า Sidebar</a></li>
                            <li class="mb-1 sub-menu-custom"><a href="{{ route('announcement_and_version_index') }}" class="link-dark p-1 rounded text-decoration-none {{ request()->routeIs('announcement_and_version_index') ? 'active text-success fw-bold' : 'text-dark' }}">ตั้งค่าอื่นๆ</a></li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>
