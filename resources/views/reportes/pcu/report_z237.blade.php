@extends('layout.dashboard_template')

@section('title')
    <title>รายงาน Z237</title>
@endsection

@section('content')
    <main class="main-content mb-5">
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก Start --}}
            <div class="card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="">
                        <button class="btn btn-outline-danger zoom-card me-3" onclick="history.back()">
                            <i class="bi bi-arrow-left-circle-fill"></i>
                            Back
                        </button>
                    </div>
                    <div class="d-flex">
                        <h1 class="h2">รายงาน Z237</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}
        {{-- All Form Date Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
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
                            </div>
                        </form>
                        <form id="yearForm">
                            @csrf
                            <div class="mb-3 d-flex align-items-center">
                                <span class="w-100">เลือกปีงบ</span>
                                <select class="form-select ms-2 me-2" id="yearSelect" name="yearSelect" aria-label="Default select example"
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
                </div>
            </div>
        {{-- All Form Date End --}}
        {{-- Show Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="report_z237_table">
                <div class="mx-5 w-auto">
                    <div class="my-5 ms-0 w-auto">
                        <div class="w-auto" id="fetch-report-z237"></div>
                    </div>
                </div>
            </div>
        {{-- Show Table End --}}
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // เริ่มต้น Hide Start
                $('#report_z237_table').hide();
                $('#yearForm').hide();
                // $('#monthForm').hide();
                $('#allForm').hide();
            // เริ่มต้น Hide End

            $('#select').on('change', function() {
                var selectForm = $('#select').val();
                if (selectForm != '0' && selectForm == '1') { // 1 = Year
                    $('#yearForm').show();
                    $('#allForm').hide();
                } else if (selectForm != '0' && selectForm == '2') { // 2 = กำหนดเอง
                    $('#allForm').show();
                    $('#yearForm').hide();
                } else {
                    alert('กรุณาเลือกรายการ');
                }
            });

            // Set Text Start
                function setText(request) {
                    if(request == 0) {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('');
                        $('#setCount').text('ไม่มีรายการ ICD Z237');
                    } else {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('จำนวนรายการ ICD Z237 : ');
                        $('#setCount').text(request + ' ราย');
                    }
                }
            // Set Text End

            // Hide Form && Chart && Table Start
                function hideForm() {
                    $('#setText').hide();
                    $('#setCount').hide();
                    $('#report_z237_table').hide();
                    $('#report_z237_form').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // ดึงข้อมูลรายชื่อที่มี ICD Z237 ตามปีงบประมาณ ที่เลือกเอง Start
                $('#submitYear').click(function(e) {
                    e.preventDefault();
                    var formData = $('#yearForm').serialize();

                    $('#report_z237_table').hide();
                    $('#setText').hide();
                    $('#setCount').hide();

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
                        url: '{{ route('getReportZ237FetchYear') }}',
                        type: 'GET',
                        data: formData,
                        success: function(response) {
                            Swal.close();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#report_z237_table').show();
                                $('#setText').hide();
                                $('#setCount').hide();
                                $("#fetch-report-z237").html(response);
                                $("#table-fetch-report-z237").DataTable({
                                    responsive: true,
                                    order: [0, 'desc'],
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
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อที่มี ICD Z237 ตามปีงบประมาณ ที่เลือกเอง End

            // ดึงข้อมูลรายชื่อที่มี ICD Z237 ตามวัน-เดือน-ปี ที่เลือกเอง Start
                $('#submitAll').click(function(e) {
                    e.preventDefault();
                    var formData = $('#allForm').serialize();

                    $('#report_z237_table').hide();
                    $('#setText').hide();
                    $('#setCount').hide();
                    
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
                        url: '{{ route('getReportZ237FetchAll') }}',
                        type: 'GET',
                        data: formData,
                        success: function(response) {
                            Swal.close();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#report_z237_table').show();
                                $('#setText').hide();
                                $('#setCount').hide();
                                $("#fetch-report-z237").html(response);
                                $("#table-fetch-report-z237").DataTable({
                                    responsive: true,
                                    order: [0, 'desc'],
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
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อที่มี ICD Z237 ตามวัน-เดือน-ปี ที่เลือกเอง End

        });
    </script>
@endsection
