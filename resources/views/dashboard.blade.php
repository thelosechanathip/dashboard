@extends('layout.dashboard_template')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
    <main class="main-content">
        {{-- Title Start --}}
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
                <div class="d-flex">
                    <h1 class="h2">Dashboard</h1>
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
        <div class="row gy-4 mt-2" id="all_dashboard">
            <div class="col-12 col-sm-6 col-md-4" id="ovst_card">
                <div class="card shadow-lg rounded-2 zoom-card">
                    <a href="{{ route('indexOvst') }}" class="text-decoration-none text-dark" id="ovst" data-value="{{ $ovstStatusId->status_id }}">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">ผู้เข้ามารับบริการ</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="ovst_count">{{ $counts->ovst_count }}</span> <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card" id="er_card" >
                    <a href="{{ route('indexErRegist') }}" class="text-decoration-none text-dark" id="er" data-value="{{ $erStatusId->status_id }}">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">ER</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="er_regist_count">{{ $counts->er_regist_count }}</span> <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card" id="refer_out_card">
                    <a href="{{ route('indexReferOut') }}" class="text-decoration-none text-dark" id="refer_out" data-value="{{ $referOutStatusId->status_id }}">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">Refer Out</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="refer_out_count">{{ $counts->refer_out_count }}</span> <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card" id="refer_in_card">
                    <a href="{{ route('indexReferIn') }}" class="text-decoration-none text-dark" id="refer_in" data-value="{{ $referInStatusId->status_id }}">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">Refer In</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="refer_in_count">{{ $counts->refer_in_count }}</span> <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card" id="admit_card">
                    <a href="{{ route('indexIpt') }}" class="text-decoration-none text-dark" id="admit" data-value="{{ $admitStatusId->status_id }}">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">Admit</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="ipt_count">{{ $counts->ipt_count }}</span> <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card" id="opdscreen_card">
                    <a href="{{ route('indexOpdScreen') }}" class="text-decoration-none text-dark" id="opdscreen" data-value="{{ $opdscreenStatusId->status_id }}">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">OPD</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="opdscreen_count">{{ $counts->opdscreen_count }}</span> <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card" id="health_med_service_card">
                    <a href="{{ route('indexHealthMedService') }}" class="text-decoration-none text-dark" id="health_med_service" data-value="{{ $healthMedServiceStatusId->status_id }}">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">แพทย์แผนไทย</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="health_med_service_count">{{ $counts->health_med_service_count }}</span> <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card" id="physic_card">
                    <a href="{{ route('indexPhysic') }}" class="text-decoration-none text-dark" id="physic" data-value="{{ $physicStatusId->status_id }}">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">กายภาพ</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="physic_count">{{ $counts->physic_count }}</span> <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        {{-- <div class="row mt-5">

        </div> --}}
    </main>
@endsection

@section('script')
    <script>
        
    </script>
@endsection
