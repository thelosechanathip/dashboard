@extends('layout.dashboard_template')

@section('title')
    <title>รายชื่อผู้ป่วยอายุ 45-70 ปี ที่ไม่เคยมีการตรวจ Cholesterol โดยไม่รวม ICD10 (E70-E79, Z136) และไม่ใช้ Simvastatin, Atorvastatin</title>
@endsection

@section('content')
    <main class="main-content mb-5" id="not_choresterol_main">
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
                        <h1 class="h2">รายชื่อผู้ป่วยอายุ 45-70 ปี ที่ไม่เคยมีการตรวจ Cholesterol โดยไม่รวม ICD10 (E70-E79, Z136) และไม่ใช้ Simvastatin, Atorvastatin</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}
        {{-- Comment Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="">
                    <h2 class="h2 text-danger">หมายเหตุ</h2>
                </div>
                <div class="ms-5">
                    <h5 class="h5">ไม่ควรกำหนด ( ปีที่ไม่ต้องการให้ข้อมูลซ้ำ ) มากกว่า 5 ปี เพราะอาจทำให้ระบบมีปัญหากับจุดต่างๆ ขอบคุณครับ/คะ</h5>
                </div>
            </div>
        {{-- Comment End --}}
        {{-- All Form Date Start --}}
            <div id="year_select" class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <form id="dateSelectForm"> {{-- กำหนดเอง --}}
                    @csrf
                    <div class="mb-2 row">
                        <div class="col-2">
                            <span class="">วันที่เริ่มต้น</span>
                            <input type="date" class="form-control" id="min_date" name="min_date" placeholder="วันที่เริ่มต้น" onkeydown="return false;">
                        </div>
                        <div class="col-2">
                            <span class="">วันที่สิ้นสุด</span>
                            <input type="date" class="form-control" id="max_date" name="max_date" placeholder="วันที่สิ้นสุด" onkeydown="return false;">
                        </div>
                        <div class="col-2">
                            <span class="">ปีที่ไม่ต้องการให้ข้อมูลซ้ำ</span>
                            <input type="text" class="form-control" name="not_year" id="not_year" placeholder="กรอกตัวเลขเท่านั้นเช่น 1" required>                       
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-2 d-flex align-items-center mt-4">
                            <button type="button" id="submitAll" class="btn btn-primary zoom-card">ค้นหาข้อมูล</button>
                        </div>
                    </div>
                </form>
            </div>
        {{-- All Form Date End --}}
        {{-- Show Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="report_not_choresterol_table">
                <div class="mx-5 w-auto">
                    <div class="my-5 ms-0 w-auto">
                        <div class="w-auto" id="fetch-report-not-choresterol"></div>
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
                    $('#report_not_choresterol_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                    $('#yearForm').hide(); // ปิดการมองเห็น Form ของปีงบประมาณ
                    $('#dateSelectForm').show(); // ปิดการมองเห็น Form( กำหนดเอง ) 
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
                        $('#report_not_choresterol_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                    } else if (selectForm != '0' && selectForm == '2') { // 2 = กำหนดเอง

                        $('#year_select').show(); // แสดง Card ที่มี ID : year_select
                        $('#dateSelectForm').show(); // แสดง Form( กำหนดเอง )
                        $('#yearForm').hide(); // ปิดการมองเห็น Form( ปีงบประมาณ ) 
                        $('#yearForm')[0].reset(); // Reset Form( ปีงบประมาณ ) 
                        $('#report_not_choresterol_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
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
                    $('#report_not_choresterol_table').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // ดึงข้อมูลรายชื่อที่มี ICD 10 ตามวัน-เดือน-ปี ที่เลือกเอง Start
                $('#submitAll').click(function(e) {
                    e.preventDefault();
                    var formData = $('#dateSelectForm').serialize();

                    $('#report_not_choresterol_table').hide();
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
                        url: '{{ route('getReportNotChoresterolFetch') }}',
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
                                $('#report_not_choresterol_table').show();
                                $("#fetch-report-not-choresterol").html(response);
                                $("#table-fetch-report-not-choresterol").DataTable({
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
            // ดึงข้อมูลรายชื่อที่มี ICD 10 ตามวัน-เดือน-ปี ที่เลือกเอง End

        });
    </script>
@endsection
