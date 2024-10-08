@extends('layout.dashboard_template')

@section('title')
    <title>ovst</title>
@endsection

@section('content')
    <main class="main-content">
        {{-- Title Start --}}
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
            <div class="">
                <h1 class="h2">ผู้เข้ามารับบริการทั้งหมด</h1>
            </div>
            <div class="d-flex">
                <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                <p>&nbsp;&nbsp;&nbsp;</p>
                <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
            </div>
        </div>
        <div class="mt-2 d-flex justify-content-end align-items-center">
            <div class="d-flex">
                <p><span id="setText"></span><span id="setCount"></span></p>
                @if ($year)
                    <p id="budgetYear" class="ms-3"><span>ปีงบประมาณ : </span>{{ $year + 543 }}</p>
                @endif
            </div>
        </div>
        <div class="mt-2 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <form id="selectForm" class="me-3">
                    @csrf
                    <div class="mb-3 d-flex align-items-center">
                        <span class="w-100">รายการ</span>
                        <select class="form-select ms-2 me-2" id="select" aria-label="Default select example"
                            style="min-width: 200px;">
                            <option selected value="0">----------</option>
                            <option value="1">ปีงบประมาณ</option>
                            <option value="2">กำหนดเอง</option>
                        </select>
                        <button type="button" id="submitSelect" class="btn btn-primary">ยืนยัน</button>
                    </div>
                </form>
                <form id="yearForm">
                    @csrf
                    <div class="mb-3 d-flex align-items-center">
                        <span class="w-100">เลือกปีงบ</span>
                        <select class="form-select ms-2 me-2" id="yearSelect" aria-label="Default select example"
                            style="min-width: 200px;">
                            <option selected value="0">----------</option>
                            <option value="2022">ปีงบ 2565</option>
                            <option value="2023">ปีงบ 2566</option>
                            <option value="2024">ปีงบ 2567</option>
                            <option value="2025">ปีงบ 2568</option>
                        </select>
                        <button type="button" id="submitYear" class="btn btn-primary">ยืนยัน</button>
                    </div>
                </form>
                <form id="allForm">
                    @csrf
                    <div class="mb-3 d-flex align-items-center">
                        <div class="" style="min-width: 80px;">
                            <span class="" style="width: 100%;">วันที่เริ่มต้น</span>
                        </div>
                        <div>
                            <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date">
                        </div>
                        <span class="w-100 ms-3">ถึงวันที่</span>
                        <div class="ms-3">
                            <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date">
                        </div>
                        <button type="button" id="submitAll" class="btn btn-primary ms-3">ยืนยัน</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-1">
            <div class="spinner-border" style="position: absolute; top: 50%; left: 55%;" id="loadingIcon" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="col">
                <canvas id="myChart" width="300" height="100"></canvas>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#yearForm').hide();
            $('#allForm').hide();

            function showLoadingIcon() {
                $('#loadingIcon').show();
                $('#myChart').hide();
            }

            function hideLoadingIcon() {
                $('#loadingIcon').hide();
                $('#myChart').show();
            }

            $('#submitSelect').click(function() {
                var selectForm = $('#select').val();
                if (selectForm != '0' && selectForm == '1') {
                    $('#yearForm').show();
                    $('#allForm').hide();
                } else if (selectForm != '0' && selectForm == '2') {
                    $('#allForm').show();
                    $('#yearForm').hide();
                } else {
                    alert('กรุณาเลือกรายการ');
                }
            });

            var chart;

            function setText(request) {
                if(request == 0) {
                    $('#setText').text('');
                    $('#setCount').text('ไม่มีผู้มารับบริการหรือไม่มีข้อมูลในระบบ');
                } else {
                    $('#setText').text('จำนวนผู้มารับบริการทั้งหมด : ');
                    $('#setCount').text(request, ' Visit');
                }
            }

            function fetch_one_year(year) {
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('getOvstData') }}',
                    type: 'GET',
                    data: {
                        year: year
                    },
                    success: function(response) {
                        hideLoadingIcon();
                        var chartDataYear = response.chartDataYear;

                        if (chart) {
                            chart.destroy();
                        }

                        var ctx = document.getElementById('myChart').getContext('2d');
                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: chartDataYear,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                onClick: function(evt, elements) {
                                    if (elements.length > 0) {
                                        var index = elements[0]._index;
                                        var datasetIndex = elements[0]._datasetIndex;
                                        var month_count = chartDataYear.datasets[datasetIndex].data[index].toLocaleString();
                                        var month = chartDataYear.labels[index];
                                        var year = $('#yearSelect').val();

                                        if(parseInt(year) == 0) {
                                            var defaultYear = '{{ $year }}';
                                            if(parseInt(month_count) == 0) {
                                                setText(month_count);
                                            } else {
                                                $('#budgetYear').show();
                                                setText(month_count);
                                            }
                                            fetch_daily_data(defaultYear, month);
                                        } else {
                                            if(parseInt(month_count) == 0) {
                                                setText(month_count);
                                            } else {
                                                $('#budgetYear').show();
                                                setText(month_count);
                                            }
                                            fetch_daily_data(year, month);
                                        }
                                    }
                                }
                            }
                        });

                        // ดึงข้อมูลทั้งหมดจากกราฟและคำนวณผลรวม
                        var total = chartDataYear.datasets[0].data.reduce(function(sum, value) {
                            return sum + value;
                        }, 0).toLocaleString();

                        if(parseInt(total) == 0) {
                            setText(total);
                        } else {
                            $('#budgetYear').show();
                            setText(total);
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoadingIcon();
                        alert('Error: ' + error);
                    }
                });
            }

            function fetch_daily_data(year, month) {
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('getOvstDailyData') }}',
                    type: 'GET',
                    data: {
                        year: year,
                        month: month
                    },
                    success: function(response) {
                        hideLoadingIcon();
                        var chartDataDaily = response.chartDataDaily;

                        if (chart) {
                            chart.destroy();
                        }

                        var ctx = document.getElementById('myChart').getContext('2d');
                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: chartDataDaily,
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

            $('#submitAll').click(function() {
                var formData = $('#allForm').serialize();
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('getOvstSelectData') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        hideLoadingIcon();
                        if(response.status === 500) {
                            alert(response.error);
                        } else {
                            var chartDataDaily = response.chartDataDaily;

                            if (chart) {
                                chart.destroy();
                            }

                            var ctx = document.getElementById('myChart').getContext('2d');
                            chart = new Chart(ctx, {
                                type: 'bar',
                                data: chartDataDaily,
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });

                            var total = chartDataDaily.datasets[0].data.reduce(function(sum, value) {
                                return sum + value;
                            }, 0).toLocaleString();

                            if(parseInt(total) == 0) {
                                setText(total);
                            } else {
                                $('#budgetYear').hide();
                                setText(total);
                            }
                        }
                    }
                });
            });

            // Load default data for the year 2023 Start
            fetch_one_year('{{ $year }}');
            // Load default data for the year 2023 End

            $('#submitYear').click(function() {
                var year = $('#yearSelect').val();
                if (year != "0") {
                    fetch_one_year(year);
                    $('#budgetYear').html('<span>ปีงบประมาณ : </span>' + (parseInt(year) + 543));
                } else {
                    alert('กรุณาเลือกปีงบประมาณ');
                }
            });
        });
    </script>
@endsection
