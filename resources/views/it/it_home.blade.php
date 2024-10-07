@extends('layout.dashboard_template')

@section('title')
    <title>หน้าแรก</title>
@endsection

@section('content')
    <main class="main-content">
        {{-- Title Start --}}
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
                <div class="d-flex">
                    <h1 class="h2">ระบบงาน IT</h1>
                </div>
                <div class="d-flex">
                    <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                    <p>&nbsp;&nbsp;&nbsp;</p>
                    <p> <span class="fw-bold">Group :</span> {{ $data['groupname'] }}</p>
                </div>
            </div>
        {{-- Title End --}}
        @if(isset($data['error']))
            <div class="alert alert-danger" role="alert">
                {{ $data['error'] }}
            </div>
        @endif
        <div class="row gy-4 mt-2" id="all_repair_notification_system">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg zoom-card">
                    <a href="{{ route('repair_notification_system_index') }}" class="text-decoration-none text-dark d-flex justify-between row">
                        <div class="card-body bg-danger text-light d-flex justify-content-center align-items-center col-4">
                            <i class="bi bi-pc-display-horizontal fs-3"></i>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center col-8">
                            <h5 class="card-title fw-bold">ระบบแจ้งซ่อม</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        
    </script>
@endsection
