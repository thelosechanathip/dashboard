@extends('layout.dashboard_template')

@section('title')
    <title>Authen Code</title>
@endsection

@section('style')
    <style>
        #myChart {
            width: 10px;
            height: 10px;
        }
    </style>
@endsection

@section('content')
    <main class="main-content">
        {{-- Title Start --}}
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
            <div class="">
                <h1 class="h2">รายงานการขอเลข Authen Code</h1>
            </div>
            <div class="d-flex">
                <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                <p>&nbsp;&nbsp;&nbsp;</p>
                <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
            </div>
        </div>
        {{-- Title End --}}
        <div class="mt-5 card shadow-lg">
            <div class="row p-5">
                <div class="col-5">
                    <div class="container px-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="fw-bold p-2">กราฟแสดงการขอเลข Authen Code</h3>
                        </div>
                        <div class="mt-5">
                            <div class="">
                                <div class="spinner-border loadingIcon" style="position: absolute; left: 20%; top: 60%;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="container px-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="fw-bold p-2">สรุปรายการขอ Authen Code ภายในวัน</h3>
                        </div>
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">รายการ</th>
                                    <th class="text-center">OFC_LGO</th>
                                    <th class="text-center">SSS</th>
                                    <th class="text-center">UCS</th>
                                    <th class="text-center">WEL</th>
                                    <th class="text-center">BRH</th>
                                    <th class="text-center">OTHER</th>
                                    <th class="text-center">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-bg-primary">จำนวนคนไข้ที่ได้ทำการขอเลข Authen Code เรียบร้อย</td>
                                    <td class="text-bg-primary text-end">{{ $summarize_count->ofc_lgo_authen }}</td>
                                    <td class="text-bg-primary text-end">{{ $summarize_count->sss_authen }}</td>
                                    <td class="text-bg-primary text-end">{{ $summarize_count->ucs_authen }}</td>
                                    <td class="text-bg-primary text-end">{{ $summarize_count->wel_authen }}</td>
                                    <td class="text-bg-primary text-end">{{ $summarize_count->nrh_authen }}</td>
                                    <td class="text-bg-primary text-end">{{ $summarize_count->other_authen }}</td>
                                    <td class="text-bg-primary text-end">{{ $summarize_count->ovst_authen_all }}</td>
                                </tr>
                                @if ($summarize_count->ovst_not_authen_all != '0')
                                    <tr>
                                        <td class="text-bg-danger">จำนวนคนไข้ที่ยังไม่ได้ขอเลข Authen Code</td>
                                        <td class="text-bg-danger text-end">{{ $summarize_count->ofc_lgo_not_authen }}</td>
                                        <td class="text-bg-danger text-end">{{ $summarize_count->sss_not_authen }}</td>
                                        <td class="text-bg-danger text-end">{{ $summarize_count->ucs_not_authen }}</td>
                                        <td class="text-bg-danger text-end">{{ $summarize_count->wel_not_authen }}</td>
                                        <td class="text-bg-danger text-end">{{ $summarize_count->nrh_not_authen }}</td>
                                        <td class="text-bg-danger text-end">{{ $summarize_count->other_not_authen }}</td>
                                        <td class="text-bg-danger text-end">{{ $summarize_count->ovst_not_authen_all }}</td>
                                    </tr>
                                @else
                                @endif
                                <tr>
                                    <td class="fw-bold">รวม</td>
                                    <td class="text-end">{{ $summarize_count->ofc_lgo_authen + $summarize_count->ofc_lgo_not_authen }}</td>
                                    <td class="text-end">{{ $summarize_count->sss_authen + $summarize_count->sss_not_authen }}</td>
                                    <td class="text-end">{{ $summarize_count->ucs_authen + $summarize_count->ucs_not_authen }}</td>
                                    <td class="text-end">{{ $summarize_count->wel_authen + $summarize_count->wel_not_authen }}</td>
                                    <td class="text-end">{{ $summarize_count->nrh_authen + $summarize_count->nrh_not_authen }}</td>
                                    <td class="text-end">{{ $summarize_count->other_authen + $summarize_count->other_not_authen }}</td>
                                    <td class="text-end">
                                        {{ $summarize_count->ovst_all }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 card shadow-lg">
            <div class="p-5">
                <div class="d-flex align-items-center justify-content-between">
                    <h3>รายชื่อคนไข้ที่ยังไม่ได้มีการขอเลข Authen Code</h3>
                    <a class="btn btn-success" href="{{ route('exportNotAuthenCode') }}">Excel</a>
                </div>
                <div class="">
                    <div class="spinner-border loadingIcon" style="position: absolute; left: 50%; top: 60%;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-5" id="table-not-authen-code"></div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            function showLoadingIcon() {
                $('.loadingIcon').show();
                $('#myChart').hide();
                $('#table-not-authen-code').hide();
            }

            function hideLoadingIcon() {
                $('.loadingIcon').hide();
                $('#myChart').show();
                $('#table-not-authen-code').show();
            }

            var chart;

            function fetch_one_year() {
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('getAuthenCodeCount') }}',
                    type: 'GET',
                    success: function(response) {
                        hideLoadingIcon();
                        var chartData = response.chart;

                        if (chart) {
                            chart.destroy();
                        }

                        var ctx = document.getElementById('myChart').getContext('2d');
                        chart = new Chart(ctx, {
                            type: 'doughnut',
                            data: chartData,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        hideLoadingIcon();
                        alert('Error: ' + error);
                    }
                });
            }

            fetch_one_year(); // เรียกฟังก์ชันเพื่อโหลดข้อมูลเมื่อเอกสารพร้อม

            fetchAllAuthenCode();

            function fetchAllAuthenCode() {
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('authenCodeFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        hideLoadingIcon();
                        $("#table-not-authen-code").html(response);
                        $("#table-list-authen-code").DataTable({
                            responsive: true,
                            order: [0, 'desc']
                        });
                    }
                });
            }

        });
    </script>
@endsection
