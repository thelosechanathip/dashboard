@extends('layout.dashboard_template')

@section('title')
    <title>Ipt</title>
@endsection

@section('content')
    <main class="main-content mb-5">
        {{-- Title Start --}}
            <div class="card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="">
                        <button class="btn btn-outline-danger zoom-card me-3" onclick="history.back()">
                            <i class="bi bi-arrow-left-circle-fill"></i>
                            Back
                        </button>
                    </div>
                    <div class="d-flex" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                        <h1 class="h2">Admit</h1>
                    </div>
                </div>
            </div>
        {{-- Title End --}}
        {{-- Result Count Modal Start --}}
            <div class="modal fade" id="result_count_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- เพิ่ม modal-xl เพื่อทำให้ Modal ขนาดใหญ่ -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="result_count_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="result_count_show_all"></div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Result Count Modal End --}}
        
        <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
            <div class="row gy-4">
                @foreach($wards as $w)
                    <div class="col-12 col-sm-6 col-md-4 mb-3 ipt_ward_card" data-value="{{ $w->name }}">
                        <div class="card shadow-lg rounded-2 zoom-card">
                            <a href="{{ route('ward.details', ['wardId' => $w->ward]) }}" class="text-decoration-none text-dark ipt_ward" data-value="{{ $w->ward }}">
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <h5 class="card-title fw-bold">{{ $w->name }}</h5>
                                </div>
                                <div class="card-footer bg-success text-light d-flex justify-content-between align-items-center">
                                    <div class="col">
                                        <p class="card-text"><span>ภายในวันนี้ : </span><span class="ipt_ward_count_all"></span> <span>ราย</span></p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="card-text"><span>Admit ปัจจุบัน : </span><span class="ipt_ward_count_current"></span> <span>ราย</span></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-3 card shadow-lg full-width-bar p-3">
            <div class="mt-5 d-flex justify-content-end align-items-center">
                <div class="d-flex">
                    <p><span id="setText"></span><span id="setCount"></span></p>
                    @if ($year)
                        <p id="budgetYear" class="ms-3"><span>ปีงบประมาณ : </span>{{ $year + 543 }}</p>
                    @endif
                </div>
            </div>
            <div class="mt-2 d-flex justify-content-between align-items-center full-width-bar">
                <div class="d-flex justify-content-between">
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
                                @foreach($fiscal_year AS $fy)
                                    <option value="{{ $fy->fiscal_year_name }}">ปีงบ {{ $fy->fiscal_year_name + 543 }}</option>
                                @endforeach
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
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-success zoom-card type_modal_add" id="result_count_btn" data-bs-toggle="modal" data-bs-target="#result_count_modal"></button>
                </div>
            </div>
        </div>
        <div class="mt-3 card shadow-lg full-width-bar p-3" id="show_all_data">
            <div class="row mt-1">
                <div class="col">
                    <canvas id="myChart" width="300" height="100"></canvas>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('.ipt_ward_card').each(function() {
                var wardCard = $(this); // เก็บ reference ของ card ปัจจุบัน
                var wardId = wardCard.find('.ipt_ward').data('value'); // ดึง wardId จากลิงก์
                var wardName = wardCard.attr('data-value'); // ดึง wardName จาก card โดยตรง

                $.ajax({
                    url: '{{ route('checkStatusWard') }}',
                    method: 'GET',
                    data: {
                        'wardName': wardName, // ส่ง wardName
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response && response.status_id === 1) { // ตรวจสอบค่า status_id
                            wardCard.show(); // แสดง card
                            $.ajax({
                                url: '{{ route('getResultWard') }}',
                                method: 'GET',
                                data: {
                                    'wardId': wardId, // ส่ง wardId
                                },
                                success: function(response) {
                                    // อัพเดตจำนวนในแต่ละ card โดยใช้ response ที่ได้
                                    wardCard.find('.ipt_ward_count_all').text(response.count_all);
                                    wardCard.find('.ipt_ward_count_current').text(response.count_current);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                }
                            });
                        } else {
                            wardCard.hide(); // ซ่อน card หาก status_id ไม่เท่ากับ 1
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            $('#yearForm').hide();
            $('#allForm').hide();

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
                    $('#setText').text('จำนวนผู้ป่วยที่ Admit : ');
                    $('#setCount').text(request, ' Visit');
                }
            }

            function fetch_one_year(year) {

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
                    url: '{{ route('getIptData') }}',
                    type: 'GET',
                    data: {
                        year: year
                    },
                    success: function(response) {
                        Swal.close();

                        var chartDataYear = response.chartDataYear;

                        $('#result_count_btn').text("สรุป Admit ประจำปี");
                        $('#result_count_btn').attr('mode', 'years');
                        $('#result_count_btn').attr('data-year', year);

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
                                                $('#budgetYear').hide();
                                                setText(month_count);
                                            } else {
                                                $('#budgetYear').hide();
                                                setText(month_count);
                                            }
                                            fetch_daily_data(defaultYear, month);
                                        } else {
                                            if(parseInt(month_count) == 0) {
                                                $('#budgetYear').hide();
                                                setText(month_count);
                                            } else {
                                                $('#budgetYear').hide();
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
                            $('#budgetYear').show();
                            setText(total);
                        } else {
                            $('#budgetYear').show();
                            setText(total);
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        alert('Error: ' + error);
                    }
                });
            }

            function fetch_daily_data(year, month) {

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
                    url: '{{ route('getIptDailyData') }}',
                    type: 'GET',
                    data: {
                        year: year,
                        month: month
                    },
                    success: function(response) {
                        Swal.close();

                        $('#result_count_btn').text("สรุป Admit ประจำเดือน");
                        $('#result_count_btn').attr('mode', 'month');

                        $('#result_count_btn').attr('data-year', year);
                        $('#result_count_btn').attr('data-month', month);

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
                                },
                                onClick: function(evt, elements) {
                                    if (elements.length > 0) {

                                        $('#result_count_btn').text("สรุป Admit ประจำวัน");
                                        $('#result_count_btn').attr('mode', 'date');

                                        var index = elements[0]._index;
                                        var datasetIndex = elements[0]._datasetIndex;
                                        var date_count = chartDataDaily.datasets[datasetIndex].data[index].toLocaleString();
                                        var date = chartDataDaily.labels[index];

                                        $('#result_count_btn').attr('data-date', date);

                                        // console.log(date);
                                        if(parseInt(date_count) == 0) {
                                            $('#budgetYear').hide();
                                            setText(date_count);
                                        } else {
                                            $('#budgetYear').hide();
                                            setText(date_count);
                                        }
                                        fetch_name_doctor_data(date);
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

            function fetch_name_doctor_data(date) {

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
                    url: '{{ route('getIptNameDoctorData') }}',
                    type: 'GET',
                    data: {
                        date: date
                    },
                    success: function(response) {
                        Swal.close();

                        var chartNameDoctorData = response.chartNameDoctorData;

                        if (chart) {
                            chart.destroy();
                        }

                        var ctx = document.getElementById('myChart').getContext('2d');
                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: chartNameDoctorData,
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                // indexAxis: 'y',
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        alert('Error: ' + error);
                    }
                });
            }

            $('#submitAll').click(function() {
                var formData = $('#allForm').serialize();
                
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
                    url: '{{ route('getIptSelectData') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        Swal.close();
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
                                    },
                                    onClick: function(evt, elements) {
                                        if (elements.length > 0) {
                                            var index = elements[0]._index;
                                            var datasetIndex = elements[0]._datasetIndex;
                                            var date_count = chartDataDaily.datasets[datasetIndex].data[index].toLocaleString();
                                            var date = chartDataDaily.labels[index];

                                            // console.log(date);
                                            if(parseInt(date_count) == 0) {
                                                $('#budgetYear').hide();
                                                setText(date_count);
                                            } else {
                                                $('#budgetYear').hide();
                                                setText(date_count);
                                            }
                                            fetch_name_doctor_data(date);
                                        }
                                    }
                                }
                            });

                            var total = chartDataDaily.datasets[0].data.reduce(function(sum, value) {
                                return sum + value;
                            }, 0).toLocaleString();

                            if(parseInt(total) == 0) {
                                $('#budgetYear').hide();
                                setText(total);
                            } else {
                                $('#budgetYear').hide();
                                setText(total);
                            }
                        }
                    }
                });
            });

            // Load default data for the year 2025 Start
            fetch_one_year('{{ $year }}');
            // Load default data for the year 2025 End

            $('#submitYear').click(function() {
                var year = $('#yearSelect').val();
                if (year != "0") {
                    fetch_one_year(year);
                    $('#budgetYear').html('<span>ปีงบประมาณ : </span>' + (parseInt(year) + 543));
                } else {
                    alert('กรุณาเลือกปีงบประมาณ');
                }
            });

            $('#result_count_btn').on('click', function() {
                let mode = $(this).attr('mode');
                if(mode === 'years') {
                    let years = $(this).attr('data-year');
                    $('#result_count_title').text('สรุปรายงานการ Admit ของแพทย์ประจำปี: ' + (parseInt(years) + 543) );
                    $.ajax({
                        url: '{{ route('getResultCountYearsDoctor') }}',
                        data: { years: years },
                        method: 'GET',
                        success: function(response) {
                            // แสดง HTML ที่ได้รับจาก response
                            $("#result_count_show_all").html(response);
                            // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                            $("#result_count_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    });
                } else if(mode === 'month') {
                    
                    let month = $(this).attr('data-month');
                    let years; // ประกาศตัวแปร years ข้างนอก if-else

                    if (month === 'ตุลาคม' || month === 'พฤศจิกายน' || month === 'ธันวาคม') {
                        years = $(this).attr('data-year') - 1; // กำหนดค่าตัวแปร years โดยไม่ต้องใช้ let
                    } else {
                        years = $(this).attr('data-year'); // กำหนดค่าตัวแปร years โดยไม่ต้องใช้ let
                    }

                    $('#result_count_title').text('สรุปรายงานการ Admit ของแพทย์ประจำเดือน: ' + month);
                    $.ajax({
                        url: '{{ route('getResultCountMonthDoctor') }}',
                        data: {
                            years: years,
                            month: month
                        },
                        method: 'GET',
                        success: function(response) {
                            // แสดง HTML ที่ได้รับจาก response
                            $("#result_count_show_all").html(response);
                            // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                            $("#result_count_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    });
                } else if(mode === 'date') {
                    // สรุปรายงานประจำวัน
                    let date = $(this).attr('data-date');  // ดึงค่า date จาก data-attribute
                    $('#result_count_title').text('สรุปรายงานการ Admit ของแพทย์ประจำวัน: ' + date);
                    $.ajax({
                        url: '{{ route('getResultCountDateDoctor') }}',
                        data: { date: date },  // ส่งค่า date ผ่าน AJAX
                        method: 'GET',
                        success: function(response) {
                            $("#result_count_show_all").html(response);
                            $("#result_count_table").DataTable();
                        }
                    });
                }
            });

        });
    </script>
@endsection
