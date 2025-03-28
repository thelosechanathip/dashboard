@extends('layout.dashboard_template')

@section('title')
    <title>Health Med Service Detail</title>
@endsection

@section('content')
    <main class="main-content mb-5">
        {{-- Title Start --}}
            <div class="card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="d-flex">
                        <button class="btn btn-outline-danger zoom-card me-3" onclick="history.back()">
                            <i class="bi bi-arrow-left-circle-fill"></i>
                            Back
                        </button>
                    </div>
                    <div class="d-flex" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                        <h1 class="h2">{{ $type }} แพทย์แผนไทย</h1>
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
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="fw-bold" id="result_sex_detail_title"></h5>
                                    </div>
                                </div>
                                <div id="result_sex_detail_count_show_all"></div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="fw-bold" id="result_age_detail_title"></h5>
                                    </div>
                                </div>
                                <div id="result_age_detail_count_show_all"></div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="fw-bold" id="result_pttype_detail_title"></h5>
                                    </div>
                                </div>
                                <div id="result_pttype_detail_count_show_all"></div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="fw-bold" id="result_treatment_subtype_detail_title"></h5>
                                    </div>
                                </div>
                                <div id="result_treatment_subtype_detail_count_show_all"></div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="fw-bold" id="result_icd10_detail_title"></h5>
                                    </div>
                                </div>
                                <div id="result_icd10_detail_count_show_all"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Result Count Modal End --}}
        <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
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
        <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400" id="show_all_data">
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

            // Reset $ Clear Modal Start
                $('#result_count_modal').on('hidden.bs.modal', function () {
                    $("#result_sex_detail_count_show_all").empty();
                    $("#result_age_detail_count_show_all").empty();
                    $("#result_pttype_detail_count_show_all").empty();
                    $("#result_treatment_subtype_detail_count_show_all").empty();
                    $("#result_icd10_detail_count_show_all").empty();
                });
            // Reset $ Clear Modal End

            var chart;

            function setText(request) {
                if(request == 0) {
                    $('#setText').text('');
                    $('#setCount').text('ไม่มีผู้มารับบริการหรือไม่มีข้อมูลในระบบ');
                } else {
                    $('#setText').text("จำนวนผู้ป่วย {{$type}} แพทย์แผนไทย : ");
                    $('#setCount').text(request, ' Visit');
                }
            }

            function fetch_one_year(year) {
                const type = "{{ $type }}";

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
                    url: '{{ route('getHealthMedServiceDetailData') }}',
                    type: 'GET',
                    data: {
                        year: year,
                        type: type,
                    },
                    success: function(response) {
                        Swal.close();
                        var chartDataYear = response.chartDataYear;

                        $('#result_count_btn').text("สรุปยอดของแพทย์แผนไทยแต่ละรายการประจำปี");
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
                                                $('#budgetYear').show();
                                                setText(month_count);
                                            } else {
                                                $('#budgetYear').show();
                                                setText(month_count);
                                            }
                                            fetch_daily_data(defaultYear, month);
                                        } else {
                                            if(parseInt(month_count) == 0) {
                                                $('#budgetYear').show();
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

                const type = "{{ $type }}";
                $.ajax({
                    url: '{{ route('getHealthMedServiceDetailDailyData') }}',
                    type: 'GET',
                    data: {
                        year: year,
                        month: month,
                        type: type
                    },
                    success: function(response) {
                        Swal.close();
                        var chartDataDaily = response.chartDataDaily;

                        $('#result_count_btn').text("สรุปยอดของแพทย์แผนไทยประจำเดือน");
                        $('#result_count_btn').attr('mode', 'month');

                        $('#result_count_btn').attr('data-year', year);
                        $('#result_count_btn').attr('data-month', month);

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

                                        $('#result_count_modal').modal('show');

                                        let type = "{{ $type }}";

                                        // สรุปรายงานประจำวัน

                                        var index = elements[0]._index;
                                        var datasetIndex = elements[0]._datasetIndex;
                                        var date_count = chartDataDaily.datasets[datasetIndex].data[index].toLocaleString();
                                        var date = chartDataDaily.labels[index];

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

                                        $('#result_count_title').text('สรุปยอดของแพทย์แผนไทยแต่ละรายการประจำวัน: ' + date);
                                        $("#result_sex_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามเพศ');
                                        $("#result_age_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามช่วงอายุ');
                                        $("#result_pttype_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามสิทธิ์การรักษา');
                                        $("#result_treatment_subtype_detail_title").text('จำนวนหัตถการที่บริการคนไข้ของแพทย์แผนไทย');
                                        $("#result_icd10_detail_title").text('จำนวนรายการ ICD10 ของแพทย์แผนไทย');
                                        // Sex Start
                                            $.ajax({
                                                url: '{{ route('getResultSexDetailCountDate') }}',
                                                data: { 
                                                    date: date,
                                                    type: type 
                                                },  // ส่งค่า date ผ่าน AJAX
                                                method: 'GET',
                                                success: function(response) {
                                                    Swal.close();
                                                    // แสดง HTML ที่ได้รับจาก response
                                                    $("#result_sex_detail_count_show_all").html(response);
                                                    // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                                    $("#result_sex_count_table").DataTable({
                                                        responsive: true,
                                                        order: [0, 'asc'],
                                                        autoWidth: false,
                                                        buttons: ['excel'],
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
                                                        ],
                                                        language: {
                                                            emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                                        },
                                                        "scrollX": true
                                                    });
                                                }
                                            });
                                        // Sex End
                                        // Age Start
                                            $.ajax({
                                                url: '{{ route('getResultAgeDetailCountDate') }}',
                                                data: { 
                                                    date: date,
                                                    type: type  
                                                },
                                                method: 'GET',
                                                success: function(response) {
                                                    Swal.close();
                                                    // แสดง HTML ที่ได้รับจาก response
                                                    $("#result_age_detail_count_show_all").html(response);
                                                    // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                                    $("#result_age_count_table").DataTable({
                                                        responsive: true,
                                                        order: [0, 'asc'],
                                                        autoWidth: false,
                                                        buttons: ['excel'],
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
                                                        ],
                                                        language: {
                                                            emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                                        },
                                                        "scrollX": true
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('AJAX error:', status, error);
                                                }
                                            });
                                        // Age End
                                        // Pttype Start
                                            $.ajax({
                                                url: '{{ route('getResultPttypeDetailCountDate') }}',
                                                data: { 
                                                    date: date,
                                                    type: type  
                                                },
                                                method: 'GET',
                                                success: function(response) {
                                                    Swal.close();
                                                    // แสดง HTML ที่ได้รับจาก response
                                                    $("#result_pttype_detail_count_show_all").html(response);
                                                    // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                                    $("#result_pttype_count_table").DataTable({
                                                        responsive: true,
                                                        order: [0, 'asc'],
                                                        autoWidth: false,
                                                        buttons: ['excel'],
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
                                                        ],
                                                        language: {
                                                            emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                                        },
                                                        "scrollX": true
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('AJAX error:', status, error);
                                                }
                                            });
                                        // Pttype End
                                        // Treatment Subtype Start
                                            $.ajax({
                                                url: '{{ route('getResultTreatmentSubtypeDetailCountDate') }}',
                                                data: { 
                                                    date: date,
                                                    type: type  
                                                },
                                                method: 'GET',
                                                success: function(response) {
                                                    Swal.close();
                                                    // แสดง HTML ที่ได้รับจาก response
                                                    $("#result_treatment_subtype_detail_count_show_all").html(response);
                                                    // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                                    $("#result_treatment_subtype_count_table").DataTable({
                                                        responsive: true,
                                                        order: [0, 'asc'],
                                                        autoWidth: false,
                                                        buttons: ['excel'],
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
                                                        ],
                                                        language: {
                                                            emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                                        },
                                                        "scrollX": true
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('AJAX error:', status, error);
                                                }
                                            });
                                        // Treatment Subtype End
                                        // ICD 10 Start
                                            $.ajax({
                                                url: '{{ route('getResultICD10DetailCountDate') }}',
                                                data: { 
                                                    date: date,
                                                    type: type  
                                                },
                                                method: 'GET',
                                                success: function(response) {
                                                    Swal.close();
                                                    // แสดง HTML ที่ได้รับจาก response
                                                    $("#result_icd10_detail_count_show_all").html(response);
                                                    // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                                    $("#result_icd10_count_table").DataTable({
                                                        responsive: true,
                                                        order: [0, 'asc'],
                                                        autoWidth: false,
                                                        buttons: ['excel'],
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
                                                        ],
                                                        language: {
                                                            emptyTable: "ไม่มีรายการ ICD10!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                                        },
                                                        "scrollX": true
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('AJAX error:', status, error);
                                                }
                                            });
                                        // ICD 10 End
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

            $('#submitAll').click(function() {
                var formData = $('#allForm').serializeArray();
                var requestData = {};
                formData.forEach(function(item) {
                    requestData[item.name] = item.value;
                });

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

                const type = "{{ $type }}";

                $.ajax({
                    url: '{{ route('getHealthMedServiceDetailSelectData') }}',
                    type: 'GET',
                    data: {
                        ...requestData, // ส่งค่าฟอร์มแต่ละฟิลด์
                        type: type      // เพิ่ม type เข้าไปในข้อมูลที่ส่ง
                    },
                    success: function(response) {
                        Swal.close();
                        if (response.status === 500) {
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

                            if (parseInt(total) == 0) {
                                $('#budgetYear').hide();
                                setText(total);
                            } else {
                                $('#budgetYear').hide();
                                setText(total);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        console.error('Error:', error);
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

            $('#result_count_btn').on('click', function() {
                let mode = $(this).attr('mode');
                let type = "{{ $type }}";
                if(mode === 'years') {

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

                    let years = $(this).attr('data-year');
                    $('#result_count_title').text('สรุปยอดของแพทย์แผนไทยแต่ละรายการประจำปี: ' + (parseInt(years) + 543) );
                    $("#result_sex_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามเพศ');
                    $("#result_age_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามช่วงอายุ');
                    $("#result_pttype_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามสิทธิ์การรักษา');
                    $("#result_treatment_subtype_detail_title").text('จำนวนหัตถการที่บริการคนไข้ของแพทย์แผนไทย');
                    $("#result_icd10_detail_title").text('จำนวนรายการ ICD10 ของแพทย์แผนไทย');
                    // Sex Start
                        $.ajax({
                            url: '{{ route('getResultSexDetailCountYears') }}',
                            data: { 
                                years: years,
                                type: type 
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดง HTML ที่ได้รับจาก response
                                $("#result_sex_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_sex_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // Sex End
                    // Age Start
                        $.ajax({
                            url: '{{ route('getResultAgeDetailCountYears') }}',
                            data: { 
                                years: years,
                                type: type 
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดง HTML ที่ได้รับจาก response
                                $("#result_age_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_age_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // Age End
                    // Pttype Start
                        $.ajax({
                            url: '{{ route('getResultPttypeDetailCountYears') }}',
                            data: { 
                                years: years,
                                type: type 
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดง HTML ที่ได้รับจาก response
                                $("#result_pttype_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_pttype_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // Pttype End
                    // Treatment Subtype Start
                        $.ajax({
                            url: '{{ route('getResultTreatmentSubtypeDetailCountYears') }}',
                            data: { 
                                years: years,
                                type: type 
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                $("#result_treatment_subtype_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_treatment_subtype_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // Treatment Subtype End
                    // ICD 10 Start
                        $.ajax({
                            url: '{{ route('getResultICD10DetailCountYears') }}',
                            data: { 
                                years: years,
                                type: type 
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                $("#result_icd10_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_icd10_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "ไม่มีรายการ ICD10!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // ICD 10 End
                } else if(mode === 'month') {
                    let month = $(this).attr('data-month');
                    let years; // ประกาศตัวแปร years ข้างนอก if-else

                    if (month === 'ตุลาคม' || month === 'พฤศจิกายน' || month === 'ธันวาคม') {
                        years = $(this).attr('data-year') - 1; // กำหนดค่าตัวแปร years โดยไม่ต้องใช้ let
                    } else {
                        years = $(this).attr('data-year'); // กำหนดค่าตัวแปร years โดยไม่ต้องใช้ let
                    }

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

                    $('#result_count_title').text('สรุปยอดของแพทย์แผนไทยแต่ละรายการประจำเดือน: ' + month);
                    $("#result_sex_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามเพศ');
                    $("#result_age_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามช่วงอายุ');
                    $("#result_pttype_detail_title").text('จำนวนผู้มารับบริการแพทย์แผนไทยแยกตามสิทธิ์การรักษา');
                    $("#result_treatment_subtype_detail_title").text('จำนวนหัตถการที่บริการคนไข้ของแพทย์แผนไทย');
                    $("#result_icd10_detail_title").text('จำนวนรายการ ICD10 ของแพทย์แผนไทย');
                    // Sex Start
                        $.ajax({
                            url: '{{ route('getResultSexDetailCountMonth') }}',
                            data: {
                                years: years,
                                month: month,
                                type: type
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดง HTML ที่ได้รับจาก response
                                $("#result_sex_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_sex_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // Sex End
                    // Age Start
                        $.ajax({
                            url: '{{ route('getResultAgeDetailCountMonth') }}',
                            data: {
                                years: years,
                                month: month,
                                type: type
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดง HTML ที่ได้รับจาก response
                                $("#result_age_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_age_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // Age End
                    // Pttype Start
                        $.ajax({
                            url: '{{ route('getResultPttypeDetailCountMonth') }}',
                            data: {
                                years: years,
                                month: month,
                                type: type
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดง HTML ที่ได้รับจาก response
                                $("#result_pttype_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_pttype_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // Pttype End
                    // Treatment Subtype Start
                        $.ajax({
                            url: '{{ route('getResultTreatmentSubtypeDetailCountMonth') }}',
                            data: {
                                years: years,
                                month: month,
                                type: type
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดง HTML ที่ได้รับจาก response
                                $("#result_treatment_subtype_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_treatment_subtype_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // Treatment Subtype End
                    // ICD 10 Start
                        $.ajax({
                            url: '{{ route('getResultICD10DetailCountMonth') }}',
                            data: {
                                years: years,
                                month: month,
                                type: type
                            },
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดง HTML ที่ได้รับจาก response
                                $("#result_icd10_detail_count_show_all").html(response);
                                // เปิดใช้งาน DataTables บนตารางที่ได้รับ
                                $("#result_icd10_count_table").DataTable({
                                    responsive: true,
                                    order: [0, 'asc'],
                                    autoWidth: false,
                                    buttons: ['excel'],
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
                                    ],
                                    language: {
                                        emptyTable: "ไม่มีรายการ ICD10!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    },
                                    "scrollX": true
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            }
                        });
                    // ICD 10 End
                }
            });
        });
    </script>
@endsection
