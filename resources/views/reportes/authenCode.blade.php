@extends('layout.dashboard_template')

@section('title')
    <title>Authen Code</title>
@endsection

@section('style')
    <style>
        #myChart {
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('content')
    <main class="main-content mb-5">
        {{-- Title Start --}}
            <div class="card shadow-lg full-width-bar" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="d-flex justify-content-between align-items-center p-2 px-3">
                    <div class="" >
                        <h1 class="h2">รายงานการขอเลข Authen Code</h1>
                    </div>
                    <div class="d-flex pt-3">
                        <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                        <p>&nbsp;&nbsp;&nbsp;</p>
                        <p> <span class="fw-bold">Group :</span> {{ $data['groupname'] }}</p>
                    </div>
                </div>
            </div>
        {{-- Title End --}}
        <div class="mt-3 card shadow-lg">
            <div class="row p-5">
                <div class="col-xl-5 col-12 col-sm-6 col-md-12">
                    <div class="container px-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="fw-bold p-2">กราฟแสดงการขอเลข Authen Code</h3>
                        </div>
                        <div class="mt-5">
                            <div class="">
                                <div class="">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-12 col-sm-6 col-md-12">
                    <div class="container px-md-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="fw-bold p-2">สรุปรายการขอ Authen Code ภายในวัน</h3>
                        </div>
                        <table class="table table-hover table-bordered" style="overflow-x: auto; max-width: 100%;" id="summarize_count">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">รายการ</th>
                                    <th class="text-center">OFC/LGO</th>
                                    <th class="text-center">SSS</th>
                                    <th class="text-center">UCS</th>
                                    <th class="text-center">WEL</th>
                                    <th class="text-center">NRH</th>
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

        <div class="mt-3 card shadow-lg">
            <div class="p-5">
                <div class="d-flex align-items-center justify-content-between">
                    <h3>รายชื่อคนไข้ที่ยังไม่ได้มีการขอเลข Authen Code</h3>
                    {{-- <a class="btn btn-success" href="{{ route('exportNotAuthenCode') }}">Excel</a> --}}
                    {{-- <a class="btn btn-success" id="exportNotAuthenCode">Excel</a> --}}
                </div>
                <div class="">
                    <div class="mt-5" id="table-not-authen-code"></div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            var chart;

            function fetch_one_year() {
                
                // Show Swal with loading icon
                let loadingSwal = Swal.fire({
                    title: 'กำลังโหลดข้อมูล...',
                    text: 'โปรดรอสักครู่',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading(); // Show spinner inside the Swal
                    }
                });

                $.ajax({
                    url: '{{ route('getAuthenCodeCount') }}',
                    type: 'GET',
                    success: function(response) {
                        Swal.close();
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
                        Swal.close();
                        alert('Error: ' + error);
                    }
                });
            }

            fetch_one_year(); // เรียกฟังก์ชันเพื่อโหลดข้อมูลเมื่อเอกสารพร้อม

            fetchAllAuthenCode();

            function fetchAllAuthenCode() {
                
                // Show Swal with loading icon
                let loadingSwal = Swal.fire({
                    title: 'กำลังโหลดข้อมูล...',
                    text: 'โปรดรอสักครู่',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading(); // Show spinner inside the Swal
                    }
                });

                $.ajax({
                    url: '{{ route('authenCodeFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        Swal.close();
                        $("#table-not-authen-code").html(response);
                        $("#table-list-authen-code").DataTable({
                            responsive: true,
                            order: [0, 'asc'],
                            autoWidth: false,
                            columnDefs: [
                                {
                                    targets: "_all",
                                    className: "dt-head-center dt-body-center"
                                }
                            ],
                            dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                            buttons: [
                                {
                                    extend: 'copyHtml5',
                                    text: 'Copy'
                                },
                                {
                                    extend: 'csvHtml5',
                                    text: 'CSV'
                                },
                                {
                                    extend: 'excelHtml5',
                                    text: 'Excel'
                                }
                            ]
                        });
                    }
                });
            }

            $('#exportNotAuthenCode').on('click', function() {

                // Show Swal with loading icon
                let loadingSwal = Swal.fire({
                    title: 'กำลังโหลดข้อมูล...',
                    text: 'โปรดรอสักครู่',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading(); // Show spinner inside the Swal
                    }
                });

                $.ajax({
                    url: '{{ route('exportNotAuthenCode') }}',
                    method: 'get',
                    success: function(response) {
                        Swal.close();
                        if (response.status === 200) {
                            swal.fire({
                                title: response.status,
                                text: response.message,
                                icon: response.icon
                            }).then((result) => {
                                window.location.href = response.download_url;
                            });
                        }
                    }
                })
            });

            $("#summarize_count").DataTable({
                responsive: true,
                order: [0, 'asc'],
                autoWidth: false,
                columnDefs: [
                    {
                        targets: "_all",
                        className: "dt-head-center dt-body-center"
                    }
                ],
                dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: 'Copy'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel'
                    }
                ]
            });

        });
    </script>
@endsection
