@extends('layout.dashboard_template')

@section('title')
    <title>หน้าแรก</title>
@endsection

@section('content')
    <main class="main-content mb-5">
        {{-- Title Start --}}
            <div class="card shadow-lg full-width-bar" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="d-flex justify-content-between align-items-center p-2 px-3">
                    <div class="" >
                        <h1 class="h2">ระบบงาน IT</h1>
                    </div>
                    <div class="d-flex pt-3">
                    </div>
                </div>
            </div>
        {{-- Title End --}}
        @if(isset($data['error']))
            <div class="alert alert-danger" role="alert">
                {{ $data['error'] }}
            </div>
        @endif
        <div class="mt-3 card shadow-lg full-width-bar p-3 px-4" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
            <div class="row gy-4" id="all_repair_notification_system">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-lg zoom-card">
                        <a href="{{ route('repair_notification_system_index') }}" class="text-decoration-none text-dark d-flex justify-between row">
                            <div class="card-body bg-success text-light d-flex justify-content-center align-items-center col-4">
                                <i class="bi bi-pc-display-horizontal fs-3"></i>
                            </div>
                            <div class="card-body d-flex justify-content-center align-items-center col-8">
                                <h5 class="card-title fw-bold">ระบบแจ้งซ่อม</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-lg zoom-card">
                        <a href="{{ route('system_info_index') }}" class="text-decoration-none text-dark d-flex justify-between row">
                            <div class="card-body bg-primary text-light d-flex justify-content-center align-items-center col-4">
                                <i class="bi bi-pc-display-horizontal fs-3"></i>
                            </div>
                            <div class="card-body d-flex justify-content-center align-items-center col-8">
                                <h5 class="card-title fw-bold">Check Computer</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-lg zoom-card">
                        <a href="{{ route('test_all_index') }}" class="text-decoration-none text-dark d-flex justify-between row">
                            <div class="card-body bg-primary text-light d-flex justify-content-center align-items-center col-4">
                                <i class="bi bi-pc-display-horizontal fs-3"></i>
                            </div>
                            <div class="card-body d-flex justify-content-center align-items-center col-8">
                                <h5 class="card-title fw-bold">Test All</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        
    </script>
@endsection
