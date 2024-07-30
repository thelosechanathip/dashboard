@extends('layout.dashboard_template')

@section('title')
    <title>Palliative Care</title>
@endsection

@section('content')
    <main class="main-content">
        {{-- Title Start --}}
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
            <div class="">
                <h1 class="h2">Palliative Care</h1>
            </div>
            <div class="d-flex">
                <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                <p>&nbsp;&nbsp;&nbsp;</p>
                <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
            </div>
        </div>
        {{-- Title End --}}

        <div class="mt-2 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <form id="allForm">
                    @csrf
                    <div class="mb-3 d-flex align-items-center">
                        <div class="" style="min-width: 80px;">
                            <span class="" style="width: 100%;">วันที่เริ่มต้น</span>
                        </div>
                        <div>
                            <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date" required>
                        </div>
                        <span class="w-100 ms-3">ถึงวันที่</span>
                        <div class="ms-3">
                            <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date" required>
                        </div>
                        <button type="button" id="submitAll" class="btn btn-primary ms-3">ยืนยัน</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-3 card shadow-lg" id="all_chart">
            <div class="row p-5">
                <div class="col-12">
                    <div class="container">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="fw-bold p-2"></h3>
                        </div>
                        <div class="mt-5">
                            <div class="">
                                <div class="spinner-border loadingIcon" style="position: absolute; left: 50%; top: 50%;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="">
                                    <canvas id="myChart_1" width="300" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#all_chart').hide();

            function showLoadingIcon() {
                $('.loadingIcon').show();
                $('#myChart_1').hide();
                $('#all_chart').show();
                $('#table-not-authen-code').hide();
            }

            function hideLoadingIcon() {
                $('.loadingIcon').hide();
                $('#myChart_1').show();
                $('#table-not-authen-code').show();
            }

            hideLoadingIcon();

            var chart;

            $('#submitAll').click(function() {
                var formData = $('#allForm').serialize();
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('getPalliativeCareSelectData') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        hideLoadingIcon();
                        // console.log(response.chart_count_death);
                        var chart_count_death = response.chart_count_death;

                        if (chart) {
                            chart.destroy();
                        }

                        var ctx = document.getElementById('myChart_1').getContext('2d');
                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: chart_count_death,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                });
            });

            // fetchAllPalliativeCare();

            function fetchAllPalliativeCare() {
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('palliativeCareFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        hideLoadingIcon();
                        // $("#table-not-authen-code").html(response);
                        // $("#table-list-authen-code").DataTable({
                        //     responsive: true,
                        //     order: [0, 'desc']
                        // });
                    }
                });
            }

        });
    </script>
@endsection
