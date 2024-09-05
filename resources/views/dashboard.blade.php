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
                <div class="spinner-border ms-3" id="loadingIcon" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="d-flex">
                <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                <p>&nbsp;&nbsp;&nbsp;</p>
                <p> <span class="fw-bold">Group :</span> {{ $data['groupname'] }}</p>
            </div>
        </div>
        {{-- Title End --}}
        <div class="row gy-5 mt-2" id="all_dashboard">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg rounded-2 zoom-card">
                    <a href="{{ route('indexOvst') }}" class="text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <h5 class="card-title fw-bold">ผู้เข้ามารับบริการ</h5>
                        </div>
                        <div class="card-footer bg-success text-light d-flex justify-content-center align-items-center">
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="ovst_count"></span> <span>ราย</span></p>
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
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="er_regist_count"></span> <span>ราย</span></p>
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
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="refer_out_count"></span> <span>ราย</span></p>
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
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="refer_in_count"></span> <span>ราย</span></p>
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
                            <p class="card-text"><span>ภายในวันนี้ : </span><span id="ipt_count"></span> <span>ราย</span></p>
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
        $(document).ready(function() {

            // $('#loadingIcon').hide();

            $('#all_dashboard').ready(function() {
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('query_all_count_data') }}',
                    method: 'GET',
                    success: function(response) {
                        hideLoadingIcon()
                        // อัพเดทข้อมูลที่ดึงมา
                        $('#ovst_count').text(response.ovst_count);
                        $('#er_regist_count').text(response.er_regist_count);
                        $('#refer_out_count').text(response.refer_out_count);
                        $('#refer_in_count').text(response.refer_in_count);
                        $('#ipt_count').text(response.ipt_count);
                        $('#all_dashboard').show();  // แสดง Element เมื่อโหลดข้อมูลเสร็จแล้ว
                    }
                });
            });

            function showLoadingIcon() {
                $('#loadingIcon').show();
                $('#all_dashboard').hide();
            }

            function hideLoadingIcon() {
                $('#loadingIcon').hide();
                $('#all_dashboard').show();
            }
        });
    </script>
@endsection
