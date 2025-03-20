@extends('layout.dashboard_template')

@section('title')
    <title>รายชื่อผู้ป่วยที่ไม่เคยมารับบริการ</title>
@endsection

@section('content')
    <main class="main-content mb-5" id="patients_with_no_service_history_main">
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
                </div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-3">
                    <div class="d-flex">
                        <h1 class="h2">รายชื่อผู้ป่วยที่ไม่เคยมารับบริการ</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}
        {{-- All Form Date Start --}}
            <div id="year_select" class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <form id="yearForm"> {{-- ปีประมาณ --}}
                    @csrf
                    <div class="mb-2 row">
                        <div class="col-2">
                            <span>เลือกปี</span>
                            <select class="form-select" id="yearSelect" name="yearSelect" aria-label="Default select example">
                                <option selected value="0">----------</option>
                                @foreach($fiscal_year AS $fy)
                                    <option value="{{ $fy->fiscal_year_name }}">ปี {{ $fy->fiscal_year_name + 543 }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-2 d-flex align-items-center mt-4">
                            <button type="button" id="submitYear" class="btn btn-primary zoom-card">ค้นหาข้อมูล</button>
                        </div>
                    </div>
                </form>
            </div>
        {{-- All Form Date End --}}
        {{-- Show Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="report_patients_with_no_service_history_table">
                <div class="mx-5 w-auto">
                    <div class="my-5 ms-0 w-auto">
                        <div class="w-auto" id="fetch-report-patients-with-no-service-history"></div>
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
                hideAll(); // เรียกใช้งาน Function hideAll เพื่อปิดการมองเห็นของทุก Form ที่มีการกำหนดไว้

                function hideAll() {
                    $('#year_select').show(); // ปิดการมองเห็น Card ที่มี ID : year_select
                    $('#report_patients_with_no_service_history_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML

                    $('#yearForm').show(); // ปิดการมองเห็น Form ของปีงบประมาณ
                    
                    $('#dateSelectForm').hide(); // ปิดการมองเห็น Form( กำหนดเอง ) 
                    
                }
            // เริ่มต้น Hide End

            // Function Reset Form All Start
                function resetFormAll() {
                    $('#yearForm')[0].reset(); // Reset Form ของปีงบประมาณ
                    $('#dateSelectForm')[0].reset(); // Reset Form( กำหนดเอง ) 
                }
            // Function Reset Form All End

            // ตัวจัดการพวกเงื่อนไข Reset ต่างๆ Start
                $('#select').on('change', function() {
                    var selectForm = $('#select').val(); // ดึง Value จาก ID select
                    if (selectForm != '0' && selectForm == '1') { // 1 = Year

                        $('#year_select').show(); // แสดง Card ที่มี ID : year_select
                        $('#yearForm').show(); // แสดง Form( ปีงบประมาณ )
                        $('#dateSelectForm').hide(); // ปิดการมองเห็น Form( กำหนดเอง ) 
                        $('#dateSelectForm')[0].reset(); // Reset Form( กำหนดเอง ) ทั้งหมด
                        $('#report_patients_with_no_service_history_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                    } else if (selectForm != '0' && selectForm == '2') { // 2 = กำหนดเอง

                        $('#year_select').hide(); // แสดง Card ที่มี ID : year_select
                        $('#dateSelectForm').hide(); // แสดง Form( กำหนดเอง )
                        $('#yearForm').hide(); // ปิดการมองเห็น Form( ปีงบประมาณ ) 
                        $('#yearForm')[0].reset(); // Reset Form( ปีงบประมาณ ) 
                        $('#report_patients_with_no_service_history_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                    } else {
                        hideAll(); // เรียกใช้งาน Function Hide All ของ Form และ Input ต่างๆ
                        resetFormAll(); // เรียกใช้งาน Function Reset Form ทั้งหมด
                    }
                });
            // ตัวจัดการพวกเงื่อนไขต่างๆ End

            // Hide Form && Chart && Table Start
                function hideForm() {
                    $('#setText').hide();
                    $('#setCount').hide();
                    $('#report_patients_with_no_service_history_table').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // ดึงข้อมูลรายชื่อผู้ป่วยที่ไม่เคยมารับบริการตามปีงบประมาณ ที่เลือกเอง Start
                $('#submitYear').click(function(e) {
                    e.preventDefault();
                    var formData = $('#yearForm').serialize();

                    $('#report_patients_with_no_service_history_table').hide();
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
                        url: '{{ route('getReportPatientsWithNoServiceHistoryFetch') }}',
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
                                $('#report_patients_with_no_service_history_table').show();
                                $("#fetch-report-patients-with-no-service-history").html(response);
                                $("#table-fetch-report-patients-with-no-service-history").DataTable({
                                    responsive: true,
                                    order: [0, 'desc'],
                                    autoWidth: false,
                                    fixedHeader: true,
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
                                    // "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อผู้ป่วยที่ไม่เคยมารับบริการตามปีงบประมาณ ที่เลือกเอง End

            // ดึงข้อมูลรายชื่อผู้ป่วยที่ไม่เคยมารับบริการตามวัน-เดือน-ปี ที่เลือกเอง Start
                $('#submitAll').click(function(e) {
                    e.preventDefault();
                    var formData = $('#dateSelectForm').serialize();

                    $('#report_patients_with_no_service_history_table').hide();
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
                        url: '{{ route('getReportPatientsWithNoServiceHistoryFetch') }}',
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
                                $('#report_patients_with_no_service_history_table').show();
                                $("#fetch-report-patients-with-no-service-history").html(response);
                                $("#table-fetch-report-patients-with-no-service-history").DataTable({
                                    responsive: true,
                                    order: [0, 'desc'],
                                    autoWidth: false,
                                    fixedHeader: true,
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
                                    // "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อผู้ป่วยที่ไม่เคยมารับบริการตามวัน-เดือน-ปี ที่เลือกเอง End

        });
    </script>
@endsection
