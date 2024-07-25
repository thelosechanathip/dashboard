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
                            <canvas id="myChart"></canvas>
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
                                    <th class="text-center">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-bg-primary">จำนวนคนไข้ที่ได้ทำการขอเลข Authen Code เรียบร้อย</td>
                                    <td class="text-end text-bg-primary">{{ $summarize_count->total_authen_success }}</td>
                                </tr>
                                @if ($summarize_count->total_not_authen != '0')
                                    <tr>
                                        <td class="text-bg-danger">จำนวนคนไข้ที่ยังไม่ได้ขอเลข Authen Code</td>
                                        <td class="text-end text-bg-danger">{{ $summarize_count->total_not_authen }}</td>
                                    </tr>
                                @else
                                @endif
                                <tr>
                                    <td class="">สิทธิ์ ( ข้าราชการ/รัฐวิสาหกิจ )</td>
                                    <td class="text-end ">{{ $summarize_count->ofc_lgo }}</td>
                                </tr>
                                <tr>
                                    <td class="">สิทธิ์ ( บัตรประกันสังคม )</td>
                                    <td class="text-end ">{{ $summarize_count->sss }}</td>
                                </tr>
                                <tr>
                                    <td class="">สิทธิ์ ( UC (บัตรทอง ไม่มี ท.) )</td>
                                    <td class="text-end ">{{ $summarize_count->ucs }}</td>
                                </tr>
                                <tr>
                                    <td class="">สิทธิ์ ( สปร. (บัตรทอง มี ท.) )</td>
                                    <td class="text-end ">{{ $summarize_count->wel }}</td>
                                </tr>
                                <tr>
                                    <td class="">สิทธิ์ ( คนต่างด้าวที่ขึ้นทะเบียน )</td>
                                    <td class="text-end ">{{ $summarize_count->nrh }}</td>
                                </tr>
                                <tr>
                                    <td class="">สิทธิ์ ( อื่นๆ (ต่างด้าวไม่ขึ้นทะเบียน / ชำระเงินเอง) )</td>
                                    <td class="text-end ">{{ $summarize_count->other }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">รวม</td>
                                    <td class="text-end">
                                        {{ $summarize_count->total_not_authen + $summarize_count->total_authen_success }}
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
                <div class="mt-5" id="table-not-authen-code"></div>
            </div>
        </div>

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            var chart;

            function fetch_one_year() {
                $.ajax({
                    url: '{{ route('getAuthenCodeCount') }}',
                    type: 'GET',
                    success: function(response) {
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
                        alert('Error: ' + error);
                    }
                });
            }

            fetch_one_year(); // เรียกฟังก์ชันเพื่อโหลดข้อมูลเมื่อเอกสารพร้อม

            fetchAllAuthenCode();

            function fetchAllAuthenCode() {
                $.ajax({
                    url: '{{ route('authenCodeFetchAll') }}',
                    method: 'get',
                    success: function(response) {
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
