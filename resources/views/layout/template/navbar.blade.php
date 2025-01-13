<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-light fixed-top" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="400">
    <div class="container-fluid">
        <div class="d-flex justify-center align-items-center">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
            <button id="sidebarToggle" class="shadow-lg rounded-4 border border-2 btn btn-outline-warning text-light d-flex justify-content-center align-items-center">
                <i class="bi bi-sliders"></i>
            </button>
        </div>
        <div class="" >
            <div class="dropdown ms-auto d-flex">
                <div class="pt-3 me-3">
                    <p>ชื่อผู้ใช้งาน : <span>{{ $data['name'] }}</p>
                </div>
                <button class="btn btn-outline-warning dropdown-toggle " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-lines-fill"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end w-auto" aria-labelledby="dropdownMenuButton1">
                    {{-- <li><p class="container">ชื่อผู้ใช้งาน : <span>{{ $data['name'] }}</span></p></li>
                    <li><p class="container">แผนก : <span>{{ $data['groupname'] }}</span></p></li> --}}
                    {{-- <hr> --}}
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
