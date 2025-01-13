@extends('layout.dashboard_template')

@section('title')
    <title>ทะเบียน COPD</title>
@endsection

@section('content')
    <!-- Modal เยี่ยมบ้าน รพ.ครั้ง Start -->
        {{-- ทะเบียนเยี่ยมบ้าน  Z718 Start --}}
            <div class="modal fade " id="copd_home_visiting_information_z718" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="copd_home_visiting_information_z718_title">ข้อมูลการเยี่ยมบ้าน Family Meeting</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container" id="show-copd-home-visiting-information-z718"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ทะเบียนเยี่ยมบ้าน  Z718 End --}}
        {{-- ทะเบียนเยี่ยมบ้าน รพ.(ครั้ง) Start --}}
            <div class="modal fade " id="copd_home_visiting_information" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="copd_home_visiting_information_title">ข้อมูลการเยี่ยมบ้าน</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container" id="show-copd-home-visiting-information"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ทะเบียนเยี่ยมบ้าน รพ.(ครั้ง) End --}}
        {{-- Advance Care Plan Start --}}
            <div class="modal fade " id="advance_care_plan_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="advance_care_plan_title">Advance Care Plan</h5>
                            <button type="button" class="btn-close zoom-card action-button" mode="" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="advance_care_plan_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="advance_care_plan_id_find_one" name="advance_care_plan_id_find_one">
                                <input type="hidden" id="vn" name="vn">
                                <div class="mb-3">
                                    <label for="acp_cid" class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                    <input type="text" class="form-control" name="acp_cid" id="acp_cid" style="background-color: #e9ecef;" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="acp_vn" class="form-label">หมายเลข Visit</label>
                                    <input type="text" class="form-control" name="acp_vn" id="acp_vn" style="background-color: #e9ecef;" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="acp_hn" class="form-label">HN</label>
                                    <input type="text" class="form-control" name="acp_hn" id="acp_hn" style="background-color: #e9ecef;" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="acp_fullname" class="form-label">ชื่อ - สกุล</label>
                                    <input type="text" class="form-control" name="acp_fullname" id="acp_fullname" style="background-color: #e9ecef;" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="detail_of_talking_with_patients" class="form-label">รายละเอียด</label>
                                    <textarea class="form-control" placeholder="กรอกรายละเอียดการคุยกับคนไข้" id="detail_of_talking_with_patients" name="detail_of_talking_with_patients" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="file_acp">เพิ่มไฟล์</label>
                                    <input type="file" name="file_acp" class="form-control">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card me-3" id="advance_care_plan_submit">บันทึกข้อมูล</button>
                                    <button type="button" class="btn btn-danger zoom-card action-button" mode="" data-bs-dismiss="modal">ยกเลิกการบันทึกข้อมูล</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        {{-- Advance Care Plan End --}}
        {{-- Advance Care Plan Detail Start --}}
            <div class="modal fade " id="advance_care_plan_detail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="advance_care_plan_detail_title">ข้อมูล Advance Care Plan</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container" id="show_advance_care_plan_detail"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Advance Care Plan Detail End --}}
        
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="" id="imageModalSrc" class="img-fluid" alt="Full Size Image">
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal เยี่ยมบ้าน รพ.ครั้ง End -->
    <main class="main-content mb-5" id="main">
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก Start --}}
            <div class="card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="">
                        <button class="btn btn-outline-danger zoom-card me-3" id="back_page_and_reset" onClick="history.back()">
                            <i class="bi bi-arrow-left-circle-fill"></i>
                            Back
                        </button>
                    </div>
                    <div class="d-flex">
                        <h1 class="h2">ทะเบียนโรคหลอดลมอุดกั้นเรื่อรัง</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}

        {{-- Form Select Title Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="d-flex align-items-center mt-2">
                    {{-- Form Select สำหรับเลือกรายการ Start --}}
                        <form id="selectForm" class="me-3">
                            @csrf
                            <div class="mb-3 d-flex align-items-center">
                                <span class="w-25">รายการ</span>
                                <select class="form-select ms-2 me-2" id="select" aria-label="Default select example"
                                    style="min-width: 210px;">
                                    <option selected value="0">-------------------------</option>
                                    <option value="1">ดูจำนวนผู้ป่วยโรคหลอดลมอุดกั้นเรื่อรังแยกตาม รพสต.</option>
                                    <option value="2">ดูรายชื่อผู้ป่วยโรคหลอดลมอุดกั้นเรื่อรัง</option>
                                </select>
                            </div>
                        </form>
                    {{-- Form Select สำหรับเลือกรายการ End --}}
                </div>
            </div>
        {{-- Form Select Title End --}}

        {{-- All Form Date Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" id="form_all">
                <div class="row mt-3">
                    <div class="d-flex align-items-center justify-content-between">
                        {{-- Form ดึงจำนวนคนไข้โรคหลอดลมอุดกั้นเรื่อรังแยกตาม รพสต. Start --}}
                            <form id="copd_count_shph_form" class="text-start">
                                @csrf
                                <div class="mb-3 d-flex align-items-center row">
                                    <div class="col d-flex align-items-center">
                                        <div class="" style="min-width: 80px;">
                                            <span class="" style="width: 100%;">วันที่เริ่มต้น</span>
                                        </div>
                                        <div>
                                            <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date" required>
                                        </div>
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <div class="" style="min-width: 70px;">
                                            <span class="" style="width: 100%;">ถึงวันที่</span>
                                        </div>
                                        <div>
                                            <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date" required>
                                        </div>
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <button type="button" id="copd_count_shph_submit" class="btn btn-primary ms-3 zoom-card">ยืนยัน</button>
                                    </div>
                                </div>
                            </form>
                        {{-- Form ดึงจำนวนคนไข้โรคหลอดลมอุดกั้นเรื่อรังแยกตาม รพสต. End --}}
                        {{-- Form ดึงรายชื่อคนไข้โรคหลอดลมอุดกั้นเรื่อรัง Start --}}
                            <form id="copd_list_name_form">
                                @csrf
                                <div class="mb-3 d-flex align-items-center row">
                                    <div class="col d-flex align-items-center">
                                        <div class="" style="min-width: 80px;">
                                            <span class="" style="width: 100%;">วันที่เริ่มต้น</span>
                                        </div>
                                        <div>
                                            <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date" required>
                                        </div>
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <div class="" style="min-width: 70px;">
                                            <span class="" style="width: 100%;">ถึงวันที่</span>
                                        </div>
                                        <div>
                                            <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date" required>
                                        </div>
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <div class="" style="min-width: 120px;">
                                            <span class="" style="width: 100%;">เลือกหน่วยบริการ</span>
                                        </div>
                                        <select class="form-select ms-2" placeholder="เลือกหน่วยบริการ" id="service_unit" name="service_unit" aria-label="Default select example"
                                            style="min-width: 200px;">
                                            <option selected value="0">------------</option>
                                            <option value="99999">ทั้งหมด</option>
                                            <option value="11111">นอกเขตบริการ</option>
                                            @foreach($zbm_rpst_name as $zrn)
                                                <option value="{{ $zrn->rpst_id }}">{{ $zrn->rpst_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <div class="" style="min-width: 80px;">
                                            <span class="" style="width: 100%;">เลือกสถานะ</span>
                                        </div>
                                        <select class="form-select ms-2" placeholder="เลือกหน่วยบริการ" id="death_type" name="death_type" aria-label="Default select example"
                                            style="min-width: 200px;">
                                            <option selected value="0">------------</option>
                                            <option value="99999">ทั้งหมด</option>
                                            <option value="Y">เสียชีวิต</option>
                                            <option value="N">ยังมีชีวิต</option>
                                        </select>
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <button type="button" id="copd_list_name_submit" class="btn btn-primary ms-1 zoom-card">ยืนยัน</button>
                                    </div>
                                </div>
                            </form>
                        {{-- Form ดึงรายชื่อคนไข้โรคหลอดลมอุดกั้นเรื่อรัง End --}}
                    </div>
                </div>
            </div>
        {{-- All Form Date End --}}

        {{-- แสดงข้อมูลคนไข้โรคหลอดลมอุดกั้นเรื่อรังแยกตาม รพสต. แบบ Chart Start --}}
            <div class="mt-3 card shadow-lg w-auto" id="copd_count_shph_all_chart">
                <div class="row">
                    {{-- แสดงข้อมูลของจำนวนผู้ป่วย Start --}}
                    <p class="text-end p-5"><span id="setText"></span><span id="setCount"></span></p>
                    {{-- แสดงข้อมูลของจำนวนผู้ป่วย End --}}
                    <div class="col-12">
                        <div class="container">
                            <div class="my-5">
                                <canvas id="copd_my_chart" width="300" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- แสดงข้อมูลคนไข้โรคหลอดลมอุดกั้นเรื่อรังแยกตาม รพสต. แบบ Chart End --}}
        {{-- แสดงข้อมูลคนไข้โรคหลอดลมอุดกั้นเรื่อรัง ตาม วันที่, สถานบริการ, สถานการมีชีวิตหรือเสียชีวิต แบบ Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="copd_list_name_table">
                <div class="row w-100">
                    <div class="col-12 w-auto">
                        <div class="mx-5 w-auto">
                            <div class="my-5 ms-0 w-auto">
                                <div class="w-auto" id="fetch-list-name"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- แสดงข้อมูลคนไข้โรคหลอดลมอุดกั้นเรื่อรัง ตาม วันที่, สถานบริการ, สถานการมีชีวิตหรือเสียชีวิต แบบ Table End --}}
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // เริ่มต้น Hide Start
                $('#copd_count_shph_all_chart').hide();
                $('#copd_count_shph_form').hide();
                $('#copd_list_name_form').hide();
                $('#copd_list_name_table').hide();
                $('.loadingIcon').hide();
                $('#form_all').hide();
            // เริ่มต้น Hide End

            // จาก form ID "select" เลือกแบบ Realtime Start
                $('#select').change(function() {
                    var selectForm = $('#select').val();
                    if (selectForm != '0' && selectForm == '1') { // 1 = จำนวนผู้ป่วยโรคหลอดลมอุดกั้นเรื่อรังแยกตาม รพสต.
                        $('#copd_count_shph_form').show();
                        $('#form_all').show();
                        $('#copd_list_name_form').hide();
                        $('#copd_list_name_table').hide();
                    } else if (selectForm != '0' && selectForm == '2') { // 2 = รายชื่อผู้ป่วยโรคหลอดลมอุดกั้นเรื่อรัง
                        $('#copd_list_name_form').show();
                        $('#form_all').show();
                        $('#copd_count_shph_form').hide();
                        $('#copd_count_shph_all_chart').hide();
                    } else {
                        $('#copd_list_name_form').hide();
                        $('#copd_count_shph_form').hide();
                        $('#copd_count_shph_all_chart').hide();
                        $('#copd_list_name_table').hide();
                        $('.loadingIcon').hide();
                        $('#form_all').hide();
                        $("#copd_list_name_form")[0].reset();
                        $("#copd_count_shph_form")[0].reset();
                    }
                });

            // จาก form ID "select" เลือกแบบ Realtime End

            // Set Text Start
                function setText(request) {
                    if(request == 0) {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('');
                        $('#setCount').text('ไม่มีคนไข้โรคหลอดลมอุดกั้นเรื่อรัง');
                    } else {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('จำนวนคนไข้โรคหลอดลมอุดกั้นเรื่อรังที่แยกตาม รพสต. : ');
                        $('#setCount').text(request + ' ราย');
                    }
                }
            // Set Text End

            // Hide Form && Chart && Table Start
                function hideForm() {
                    $('#setText').hide();
                    $('#setCount').hide();
                    $('#copd_list_name_table').hide();
                    $('#copd_count_shph_all_chart').hide();
                    $('#copd_list_name_table').hide();
                    $('#copd_count_shph_all_chart').hide();
                    $('#copd_count_shph_form').hide();
                    $('#copd_list_name_form').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // ตัวแปรเก็บ Chart Start
                var chart;
            // ตัวแปรเก็บ Chart End

            // ดึงข้อมูลคนไข้โรคหลอดลมอุดกั้นเรื่อรังแยกตาม รพสต. แสดงแบบ Chart Start
                $('#copd_count_shph_submit').click(function(e) {
                    // ป้องกันการ Reload ของหน้าเว็บใหม่
                    e.preventDefault();

                    // ดึงข้อมูลจาก Form ด้วย ID
                    var formData = $('#copd_count_shph_form').serialize();

                    $('#copd_list_name_table').hide();
                    $('#copd_count_shph_all_chart').hide();
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
                        // ส่งคำขอข้อมูลไปยัง Route
                        url: '{{ route('getCOPDSelectData') }}',
                        // Method Get
                        type: 'GET',
                        // ส่งข้อมูลด้วยตัวแปร formData
                        data: formData,
                        // เมื่อมีการส่ง Response กลับมา
                        success: function(response) {
                            // เรียกใช้งาน Function เพื่อปิด Icon Download
                            Swal.close();

                            if(response.status === 400) {
                                // แสดงข้อมูลแบบ Sweet Alert 2 Start
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                                // แสดงข้อมูลแบบ Sweet Alert 2 End
                                $('#copd_count_shph_all_chart').hide();
                                $('#copd_list_name_table').hide();
                            } else {
                                $('#copd_count_shph_all_chart').show();
                                $('#copd_list_name_table').hide();
                                // Reset Form ที่มี ID ตามด้านล่าง
                                $("#copd_list_name_form")[0].reset();

                                // นำ Response ที่มี Chart นำไปเก็บไว้ในตัวแปร chart_count_copd_shph
                                var chart_count_copd_shph = response.chart_count_copd_shph;

                                // Check ว่ามี Chart หรือไม่
                                if (chart) {
                                    chart.destroy();
                                }

                                // เข้าถึง ID ตามด้านล่างเพื่อทำให้ ID นั้นๆ แสดงรูปแบบ Chart ออกมา
                                var ctx = document.getElementById('copd_my_chart').getContext('2d');
                                chart = new Chart(ctx, {
                                    // แสดง Chart ในรูปแบบกราฟแท่ง
                                    type: 'bar',
                                    // ดึงข้อมูลจาก Response มาแสดง
                                    data: chart_count_copd_shph,
                                    // ดึงข้อมูลจาก Response ในส่วนของ Options มาแสดง
                                    options: chart_count_copd_shph.options
                                });

                                // ดึงข้อมูลจาก Response มารวมกันเพื่อหาผลรวมของข้อมูล
                                var total = chart_count_copd_shph.datasets[0].data.reduce(function(sum, value) {
                                    return sum + value;
                                }, 0).toLocaleString();

                                // ตรวจสอบข้อมูลว่า = 0 หรือไม่ แล้วค่าไปยัง Function setText เพื่อทำการ Set ข้อความและจำนวนข้อมูลที่ต้องการแสดง
                                if(parseInt(total) == 0) {
                                    setText(total);
                                } else {
                                    setText(total);
                                }
                            }
                        }
                    });
                });
            // ดึงข้อมูลคนไข้โรคหลอดลมอุดกั้นเรื่อรังแยกตาม รพสต. แสดงแบบ Chart End

            function getCOPDFetchListName() {
                var formData = $('#copd_list_name_form').serialize();

                $('#copd_list_name_table').hide();
                $('#copd_count_shph_all_chart').hide();
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
                    url: '{{ route('getCOPDFetchListName') }}',
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
                            $('#copd_list_name_table').show();
                            $('#copd_count_shph_all_chart').hide();
                            $("#copd_count_shph_form")[0].reset();
                            $('#setText').hide();
                            $('#setCount').hide();
                            $("#fetch-list-name").html(response);
                            $("#table-fetch-list-name").DataTable({
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
            }

            // ดึงข้อมูลรายชื่อคนไข้โรคหลอดลมอุดกั้นเรื่อรังสมอง ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือเสียชีวิต Start
                $('#copd_list_name_submit').click(function(e) {
                    e.preventDefault();
                    getCOPDFetchListName();
                });
            // ดึงข้อมูลรายชื่อคนไข้โรคหลอดลมอุดกั้นเรื่อรังสมอง ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือเสียชีวิต End

            // ดึงข้อมูลการเยี่ยมบ้าน Z718 แสดงบน Modal Start
                $(document).on('click', '.copd-home-visiting-information-z718', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#show-copd-home-visiting-information').hide();
                    $('#show-copd-home-visiting-information-z718').hide();
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
                        url: '{{ route('getCOPDHomeVisitingInformationZ718') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            $('#show-copd-home-visiting-information-z718').show();
                            $("#show-copd-home-visiting-information-z718").html(response);
                        }
                    });
                });
            // ดึงข้อมูลการเยี่ยมบ้าน Z718 แสดงบน Modal End

            // ดึงข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) แสดงบน Modal Start
                $(document).on('click', '.copd-home-visiting-information', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#show-copd-home-visiting-information').hide();
                    $('#show-copd-home-visiting-information-z718').hide();
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
                        url: '{{ route('getCOPDHomeVisitingInformation') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            $('#show-copd-home-visiting-information').show();
                            $("#show-copd-home-visiting-information").html(response);
                        }
                    });
                });
            // ดึงข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) แสดงบน Modal End

            // Advance Care Plan Setting Insert Start
                $(document).on('click', '.advance_care_plan_add', function (e) {
                    e.preventDefault();
                    let vn = $(this).attr('id');
                    var fullname = $(this).data('fullname');
                    var hn = $(this).data('hn');
                    var cid = $(this).data('cid');

                    $('#acp_cid').val(cid);
                    $('#acp_vn').val(vn);
                    $('#acp_hn').val(hn);
                    $('#acp_fullname').val(fullname);

                    $('#mode').attr('mode', 'add');
                    $('#advance_care_plan_title').text('เพิ่มข้อมูล');
                });
            // Advance Care Plan Setting Insert End

            // Advance Care Plan Insert Data Start
                $('#advance_care_plan_form').submit(function(e) {
                    const mode = $('#mode').attr('mode');

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

                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataAdvanceCarePlan') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                Swal.close();
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                    getCOPDFetchListName();
                                    $("#advance_care_plan_form")[0].reset();
                                    $("#advance_care_plan_modal").modal('hide');
                                }
                            }
                        });
                    }
                });
            // Advance Care Plan Insert Data End

            // Advance Care Plan Detail Start
                $(document).on('click', '.advance_care_plan_detail', function(e) {
                    e.preventDefault();
                    let vn = $(this).data('vn'); // ดึงค่า vn จาก data attribute

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
                        url: '{{ route('showDataAdvanceCarePlanDetail') }}',
                        method: 'get',
                        data: { vn: vn }, // ส่ง vn เป็น key-value
                        dataType: 'json',
                        success: function(response) {
                            Swal.close();
                            $('#show_advance_care_plan_detail').show();
                            $("#show_advance_care_plan_detail").html(response);
                        }
                    });
                });
            // Advance Care Plan Detail End

            // เมื่อผู้ใช้คลิกที่รูปภาพ ในส่วนของ Advance Care Plan Detail Start
                $('#imageModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // ปุ่มหรือรูปที่ถูกคลิก
                    var imgSrc = button.data('img'); // ดึง URL ของรูปจาก attribute data-img
                    var modal = $(this);
                    modal.find('#imageModalSrc').attr('src', imgSrc); // ตั้งค่า src ของรูปใน modal ให้ตรงกับรูปที่ถูกคลิก
                });
            // เมื่อผู้ใช้คลิกที่รูปภาพ ในส่วนของ Advance Care Plan Detail End

        });
    </script>
@endsection
