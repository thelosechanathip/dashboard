<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <div class="d-flex justify-center align-items-center">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
            <button id="sidebarToggle" class="shadow-lg rounded-4 border border-2 btn btn-outline-success text-light d-flex justify-content-center align-items-center">
                <i class="bi bi-sliders"></i>
            </button>
        </div>
        <div class="" >
            <div class="dropdown ms-auto">
                <button class="btn btn-outline-success text-light dropdown-toggle " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $data['name'] }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                    {{-- <li><a class="dropdown-item" href="#">Setting</a></li> --}}
                    {{-- <li><hr class="dropdown-divider"></li> --}}
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
