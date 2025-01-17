@extends('layout.dashboard_template')

@section('title')
    <title>รายงาน X-ray CXR41003 & 41004</title>
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
                        <h1 class="h2">รายงาน X-ray CXR41003 & 41004</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}
        {{-- All Form Date Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="mt-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <form id="selectForm" class="me-3 row">
                            @csrf
                            <div class="col mb-3 d-flex align-items-center">
                                <span class="w-100">รายการ</span>
                                <select class="form-select ms-2 me-2" id="select" aria-label="Default select example"
                                    style="min-width: 200px;">
                                    <option selected value="0">----------</option>
                                    <option value="1">ปีงบประมาณ</option>
                                    <option value="2">กำหนดเอง</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- All Form Date Start --}}
                <div class="mt-3 card shadow-lg full-width-bar p-3" id="form_all">
                    <div class="row mt-3">
                        <div class="d-flex align-items-center justify-content-between">
                            {{-- Form CXR เลือกแบบปีงบประมาณ Start --}}
                                <form id="yearForm" class="text-start" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 d-flex align-items-center row">
                                        <div class="col">
                                            <span class="">เลือกปีงบ</span>
                                            <select class="form-select me-2" id="yearSelect" name="yearSelect" aria-label="Default select example"
                                                style="min-width: 100px;">
                                                <option selected value="0">----------</option>
                                                @foreach($fiscal_year AS $fy)
                                                    <option value="{{ $fy->fiscal_year_name }}">ปีงบ {{ $fy->fiscal_year_name + 543 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <span class="">เลือก File Excel</span>
                                            <input class="form-control w-100" type="file" name="file" accept=".xlsx, .xls, .csv">
                                        </div>
                                        <div class="col pt-4">
                                            <button type="submit" id="submitYear" class="btn btn-primary ms-3 zoom-card">ยืนยัน</button>
                                        </div>
                                    </div>
                                </form>
                            {{-- Form CXR เลือกแบบปีงบประมาณ End --}}
                            {{-- Form CXR เลือกแบบเลือกวัน-เดือน-ปีเอง Start --}}
                                <form id="selectDateForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 d-flex align-items-center row">
                                        <div class="col">
                                            <span class="" style="width: 100%;">วันที่เริ่มต้น</span>
                                            <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date" required>
                                        </div>
                                        <div class="col">
                                            <span class="" style="width: 100%;">ถึง</span>
                                            <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date" required>
                                        </div>
                                        <div class="col">
                                            <span class="" style="width: 100%;">วันที่ต้องการดึงค่า HBA1C</span>
                                            <input type="date" class="form-control" id="min_date_hba1c" name="min_date_hba1c" placeholder="min_date_hba1c" required>
                                        </div>
                                        <div class="col">
                                            <span class="" style="width: 100%;">ถึง</span>
                                            <input type="date" class="form-control" id="max_date_hba1c" name="max_date_hba1c" placeholder="max_date_hba1c" required>
                                        </div>
                                        <div class="col">
                                            <span class="">เลือก File Excel</span> 
                                            <input class="form-control" type="file" name="file" accept=".xlsx, .xls, .csv">
                                        </div>
                                        <div class="col pt-4">
                                            <button type="submit" id="submitSelectDate" class="btn btn-primary ms-1 zoom-card">ยืนยัน</button>
                                        </div>
                                    </div>
                                </form>
                            {{-- Form CXR เลือกแบบเลือกวัน-เดือน-ปีเอง End --}}
                        </div>
                    </div>
                </div>
            {{-- All Form Date End --}}
        {{-- All Form Date End --}}
        {{-- Show Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="report_cxr_41003_41004_table">
                <div class="mx-5 w-auto">
                    <div class="my-5 ms-0 w-auto">
                        <div class="w-auto" id="fetch-report-cxr-41003-41004"></div>
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
                $('#report_cxr_41003_41004_table').hide();
                $('#form_all').hide();
                $('#yearForm').hide();
                $('#selectDateForm').hide();
                Swal.close();
            // เริ่มต้น Hide End

            $('#select').on('change', function() {
                var selectForm = $('#select').val();
                if (selectForm != '0' && selectForm == '1') { // 1 = Year
                    $('#yearForm').show();
                    $('#selectDateForm').hide();
                    $('#report_cxr_41003_41004_table').hide();
                    $('#fetch-report-cxr-41003-41004').hide();
                    $('#form_all').show();
                } else if (selectForm != '0' && selectForm == '2') { // 2 = กำหนดเอง
                    $('#selectDateForm').show();
                    $('#yearForm').hide();
                    $('#report_cxr_41003_41004_table').hide();
                    $('#fetch-report-cxr-41003-41004').hide();
                    $('#form_all').show();
                } else {
                    $('#form_all').hide();
                    alert('กรุณาเลือกรายการ');
                }
            });

            // Hide Form && Chart && Table Start
                function hideForm() {
                    $('#setText').hide();
                    $('#setCount').hide();
                    $('#report_cxr_41003_41004_table').hide();
                    $('#report_cxr_41003_41004_form').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // ดึงข้อมูลรายชื่อที่มี CXR 41003 & 41004 ตามปีงบประมาณ ที่เลือกเอง Start
                $('#yearForm').submit(function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    $('#report_cxr_41003_41004_table').hide();

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
                        url: '{{ route('getReportCXR4100341004FetchYear') }}',
                        method: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.close();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#report_cxr_41003_41004_table').show();
                                $('#fetch-report-cxr-41003-41004').show();
                                $("#fetch-report-cxr-41003-41004").html(response);
                                $("#table-fetch-report-cxr-41003-41004").DataTable({
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
                                    ],
                                    "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อที่มี CXR 41003 & 41004 ตามปีงบประมาณ ที่เลือกเอง End

            // ดึงข้อมูลรายชื่อที่มี CXR 41003 & 41004 ตามวัน-เดือน-ปี ที่เลือกเอง Start
                $('#selectDateForm').submit(function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    $('#report_cxr_41003_41004_table').hide();
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
                        url: '{{ route('getReportCXR4100341004FetchSelectDate') }}',
                        method: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.close();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#report_cxr_41003_41004_table').show();
                                $('#fetch-report-cxr-41003-41004').show();
                                $("#fetch-report-cxr-41003-41004").html(response);
                                $("#table-fetch-report-cxr-41003-41004").DataTable({
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
                                    ],
                                    "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อที่มี CXR 41003 & 41004 ตามวัน-เดือน-ปี ที่เลือกเอง End

        });
    </script>
@endsection
