@extends('layout.dashboard_template')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
    <main class="main-content">
        {{-- Title Start --}}
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
            <div class="">
                <h1 class="h2">Dashboard</h1>
            </div>
            <div class="d-flex">
                <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                <p>&nbsp;&nbsp;&nbsp;</p>
                <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
            </div>
        </div>
        {{-- Title End --}}
        <div class="row gy-5 mt-2">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card">
                    <a href="{{ route('indexOvst') }}" class="text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">ผู้เข้ามารับบริการ</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span>{{ $ovst_count }} <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card">
                    <a href="{{ route('indexErRegist') }}" class="text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">ER</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span>{{ $er_regist_count }} <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card">
                    <a href="{{ route('indexReferOut') }}" class="text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">Refer Out</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span>{{ $refer_out_count }} <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card">
                    <a href="{{ route('indexReferIn') }}" class="text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">Refer In</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span>{{ $refer_in_count }} <span>ราย</span></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card">
                    <a href="{{ route('indexIpt') }}" class="text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">Admit</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span>{{ $ipt_count }} <span>ราย</span></p>
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

@endsection
