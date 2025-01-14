@extends('layout.dashboard_template')

@section('title')
    <title>receiving Charts</title>
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
    {{-- Modal Start --}}
            {{-- รายการสรุปคนไข้ Dischange Start --}}
            <div class="modal fade" id="count_dischange_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- เพิ่ม modal-xl เพื่อทำให้ Modal ขนาดใหญ่ -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="count_dischange_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="count_dischange_show_all"></div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- รายการสรุปคนไข้ Dischange End --}}
        {{-- รายการสรุป Chart ที่ส่งให้แพทย์ Start --}}
            <div class="modal fade" id="count_receiving_charts_send_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- เพิ่ม modal-xl เพื่อทำให้ Modal ขนาดใหญ่ -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="count_receiving_charts_send_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="count_receiving_charts_send_show_all"></div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- รายการสรุป Chart ที่ส่งให้แพทย์ End --}}
        {{-- รายการสรุป Chart ที่รับจากแพทย์ Start --}}
            <div class="modal fade" id="count_receiving_charts_receive_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- เพิ่ม modal-xl เพื่อทำให้ Modal ขนาดใหญ่ -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="count_receiving_charts_receive_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="count_receiving_charts_receive_show_all"></div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- รายการสรุป Chart ที่รับจากแพทย์ End --}}
        {{-- ค้นหาข้อมูลผ่าน AN Start --}}
            <div class="modal fade" id="search_data_from_an_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered "> <!-- เพิ่ม modal-xl เพื่อทำให้ Modal ขนาดใหญ่ -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="search_data_from_an_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body ">
                            <div class="modal-body d-flex justify-content-center align-items-center" style="height: 100%;">
                                <form id="search_data_from_an_form" class="col-6">
                                    @csrf
                                    <div class="mb-3 d-flex align-items-center row gx-3">
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" id="search_an" name="search_an" placeholder="กรุณากรอก AN" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-center">
                                            <button type="submit" id="search_data_from_an_submit" class="btn btn-primary btn-sm">ค้นหา</button>
                                        </div>
                                    </div>
                                </form>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        {{-- ค้นหาข้อมูลผ่าน AN End --}}
        {{-- รายการสรุป Chart ที่ส่งไปยังห้องเรียกเก็บ Start --}}
            <div class="modal fade" id="receiving_charts_data_send_to_billing_room_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- เพิ่ม modal-xl เพื่อทำให้ Modal ขนาดใหญ่ -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiving_charts_data_send_to_billing_room_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="count_receiving_charts_billing_room_show_all"></div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- รายการสรุป Chart ที่ส่งไปยังห้องเรียกเก็บ End --}}
        {{-- รายการสรุปยังไม่รับ Chart จากตึก Start --}}
            <div class="modal fade" id="building_from_receiving_charts_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- เพิ่ม modal-xl เพื่อทำให้ Modal ขนาดใหญ่ -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="building_from_receiving_charts_title">รายชื่อคนไข้ที่ Dischange แล้วแต่ยังค้างอยู่ในตึก</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="border-bottom pb-2">
                                <form id="building_from_receiving_charts_form" class="col ms-3 ">
                                    @csrf
                                    <div class="mb-1 d-flex align-items-center row gx-3">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <!-- เลือกเดือน ตั้งแต่ -->
                                            <div class="d-flex align-items-center me-3">
                                                <span class="me-2" style="white-space: nowrap; font-size: 1rem;">เลือกเดือน ตั้งแต่</span>
                                                <input type="date" class="form-control" id="bfrcs_min_date" name="bfrcs_min_date" placeholder="bfrcs_min_date" required>
                                            </div>
            
                                            <!-- ถึง -->
                                            <div class="d-flex align-items-center me-3">
                                                <span class="me-2" style="font-size: 1rem;">ถึง</span>
                                                <input type="date" class="form-control" id="bfrcs_max_date" name="bfrcs_max_date" placeholder="bfrcs_max_date" required>
                                            </div>
            
                                            <!-- ยืนยัน -->
                                            <div class="ms-3">
                                                <button type="submit" id="building_from_receiving_charts_submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="building_from_receiving_charts_show_all"></div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- รายการสรุปยังไม่รับ Chart จากตึก End --}}
    {{-- Modal End --}}
    <main class="main-content mb-3">
        {{-- Title Start --}}
            <div class="card shadow-lg full-width-bar" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="d-flex justify-content-between align-items-center p-2 px-3">
                    <div class="" >
                        <h1 class="h2">
                            รายงานการ ( รับ - ส่ง ) Chart ให้แพทย์
                        </h1>
                        
                    </div>
                    <div class="p-2">
                        <button data-bs-toggle="modal" data-bs-target="#search_data_from_an_modal" id="search_data_from_an_btn" class="btn btn-success ms-2 zoom-card"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        {{-- Title End --}}

        <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
            <div class="">  
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a type="button" class="btn btn-outline-success" href="#dischange_data" id="dischange_data_setting">ข้อมูลคนไข้ Dischange</a>
                    <a type="button" class="btn btn-outline-success" href="#receiving_charts_data_send" id="receiving_charts_data_send_setting">ข้อมูล Chart คนไข้ที่ส่งแพทย์</a>
                    <a type="button" class="btn btn-outline-success" href="#receiving_charts_data_receive" id="receiving_charts_data_receive_setting">ข้อมูล Chart คนไข้ที่รับจากแพทย์</a>
                    <a type="button" class="btn btn-outline-success" href="#receiving_charts_data_send_to_billing_room" id="receiving_charts_data_send_to_billing_room_setting">ข้อมูล Chart คนไข้ที่ส่งไปยังห้องเรียกเก็บ</a>
                    {{-- <div class="spinner-border loadingIcon ms-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="mt-3 card shadow-lg full-width-bar" id="dischange_data">
            <div class="p-5">
                <div class="d-flex">
                    <form id="dischange_data_select_date_form" class="col ms-3">
                        @csrf
                        <div class="mb-1 d-flex align-items-center row gx-3">
                            <div class="col-md-8 d-flex align-items-center">
                                <!-- เลือกเดือน ตั้งแต่ -->
                                <div class="d-flex align-items-center me-3">
                                    <span class="me-2" style="white-space: nowrap; font-size: 1rem;">เลือกเดือน ตั้งแต่</span>
                                    <input type="date" class="form-control" id="ddsdf_min_date" name="ddsdf_min_date" placeholder="ddsdf_min_date" required>
                                </div>

                                <!-- ถึง -->
                                <div class="d-flex align-items-center me-3">
                                    <span class="me-2" style="font-size: 1rem;">ถึง</span>
                                    <input type="date" class="form-control" id="ddsdf_max_date" name="ddsdf_max_date" placeholder="ddsdf_max_date" required>
                                </div>

                                <!-- ยืนยัน -->
                                <div class="ms-3">
                                    <button type="submit" id="dischange_data_select_date_submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#count_dischange_modal" id="count_dischange_btn">
                            สรุปรายการ Dischange 
                        </button>
                    </div>
                </div>
                <hr >
                <div class="mt-5" id="table-dischange-data"></div>
            </div>
        </div>

        <div class="mt-3 card shadow-lg full-width-bar" id="receiving_charts_data_send">
            <div class="p-5">
                <div class="d-flex">
                    <form id="receiving_charts_data_select_date_form" class="col ms-3">
                        @csrf
                        <div class="mb-3 d-flex align-items-center row gx-3">
                            <div class="col-md-8 d-flex align-items-center">
                                <!-- เลือกเดือน ตั้งแต่ -->
                                <div class="d-flex align-items-center me-3">
                                    <span class="me-2" style="white-space: nowrap; font-size: 1rem;">เลือกเดือน ตั้งแต่</span>
                                    <input type="date" class="form-control" id="rdssdf_min_date" name="rdssdf_min_date" placeholder="rdssdf_min_date" required>
                                </div>

                                <!-- ถึง -->
                                <div class="d-flex align-items-center me-3">
                                    <span class="me-2" style="font-size: 1rem;">ถึง</span>
                                    <input type="date" class="form-control" id="rdssdf_max_date" name="rdssdf_max_date" placeholder="rdssdf_max_date" required>
                                </div>

                                <!-- ยืนยัน -->
                                <div class="ms-3">
                                    <button type="submit" id="receiving_charts_data_select_date_submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#count_receiving_charts_send_modal" id="count_receiving_charts_send_btn">
                            สรุปรายการ Charts ที่ส่งให้แพทย์
                        </button>
                    </div>
                </div>
                <hr>
                <div class="" id="table-receiving-charts-data-send"></div>
            </div>
        </div>

        <div class="mt-3 card shadow-lg full-width-bar" id="receiving_charts_data_receive">
            <div class="p-5">
                <div class="d-flex">
                    <form id="receiving_charts_data_receive_select_date_form" class="col ms-3">
                        @csrf
                        <div class="mb-3 d-flex align-items-center row gx-3">
                            <div class="col-md-8 d-flex align-items-center">
                                <!-- เลือกเดือน ตั้งแต่ -->
                                <div class="d-flex align-items-center me-3">
                                    <span class="me-2" style="white-space: nowrap; font-size: 1rem;">เลือกเดือน ตั้งแต่</span>
                                    <input type="date" class="form-control" id="rcdsdf_min_date" name="rcdsdf_min_date" placeholder="rcdsdf_min_date" required>
                                </div>

                                <!-- ถึง -->
                                <div class="d-flex align-items-center me-3">
                                    <span class="me-2" style="font-size: 1rem;">ถึง</span>
                                    <input type="date" class="form-control" id="rcdsdf_max_date" name="rcdsdf_max_date" placeholder="rcdsdf_max_date" required>
                                </div>

                                <!-- ยืนยัน -->
                                <div class="ms-3">
                                    <button type="submit" id="receiving_charts_data_receive_select_date_submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#count_receiving_charts_receive_modal" id="count_receiving_charts_receive_btn">
                            สรุปรายการ Charts ที่รับจากแพทย์
                        </button>
                    </div>
                </div>
                <hr>
                <div class="" id="table-receiving-charts-data-receive"></div>
            </div>
        </div>

        {{-- Send To Billing Room Start --}}
            <div class="mt-3 card shadow-lg full-width-bar" id="receiving_charts_data_send_to_billing_room">
                <div class="p-5">
                    <div class="d-flex">
                        <form id="receiving_charts_data_send_to_billing_room_form" class="col ms-3">
                            @csrf
                            <div class="mb-3 d-flex align-items-center row gx-3">
                                <div class="col-md-8 d-flex align-items-center">
                                    <!-- เลือกเดือน ตั้งแต่ -->
                                    <div class="d-flex align-items-center me-3">
                                        <span class="me-2" style="white-space: nowrap; font-size: 1rem;">เลือกเดือน ตั้งแต่</span>
                                        <input type="date" class="form-control" id="rcdst16_min_date" name="rcdst16_min_date" placeholder="rcdst16_min_date" required>
                                    </div>

                                    <!-- ถึง -->
                                    <div class="d-flex align-items-center me-3">
                                        <span class="me-2" style="font-size: 1rem;">ถึง</span>
                                        <input type="date" class="form-control" id="rcdst16_max_date" name="rcdst16_max_date" placeholder="rcdst16_max_date" required>
                                    </div>

                                    <!-- ยืนยัน -->
                                    <div class="ms-3">
                                        <button type="submit" id="receiving_charts_data_send_to_billing_room_submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#receiving_charts_data_send_to_billing_room_modal" id="count_receiving_charts_data_send_to_billing_room_btn">
                                สรุปรายการ Charts ที่ส่งให้ห้องเรียกเก็บ
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="" id="table-receiving-charts-data-send-billing-room"></div>
                </div>
            </div>
        {{-- Send To Billing Room End --}}

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#search_data_from_an_btn').on('click', function() {
                $('#search_data_from_an_title').text('ค้นหาข้อมูลจาก AN');
                $('#announcement_and_version_menu').offcanvas('hide');
            });

            $('#count_dischange_btn').on('click', function() {
                fetchAllCountDischange()
            });

            $('#count_dischange_modal').on('hidden.bs.modal', function () {
                $('#dischange_data_select_date_form')[0].reset();
            });

            $('#count_receiving_charts_send_btn').on('click', function() {
                fetchAllCountReceivingChartsSending()
            });

            $('#count_receiving_charts_send_modal').on('hidden.bs.modal', function () {
                $('#receiving_charts_data_select_date_form')[0].reset();
            });

            $('#count_receiving_charts_receive_btn').on('click', function() {
                fetchAllCountReceivingChartsReceive()
            });

            $('#count_receiving_charts_receive_modal').on('hidden.bs.modal', function () {
                $('#receiving_charts_data_receive_select_date_form')[0].reset();
            });

            $('#count_receiving_charts_data_send_to_billing_room_btn').on('click', function() {
                fetchAllCountReceivingChartsSendBillingRoom()
            });

            $('#receiving_charts_data_send_to_billing_room_modal').on('hidden.bs.modal', function () {
                $('#receiving_charts_data_send_to_billing_room_form')[0].reset();
            });

            defaultPage();

            function defaultPage() {
                $('#dischange_data').hide();
                $('#receiving_charts_data_send').hide();
                $('#receiving_charts_data_receive').hide();
                $('#receiving_charts_data_send_to_billing_room').hide();
                $('#search_data_from_an').hide();
                Swal.close();
            }

            $('#dischange_data_setting').on('click', function() {
                // Show the modal
                $('#building_from_receiving_charts_modal').modal('show');
                const formData = 0;
                buildingFromReceivingCharts(formData);

                $('#dischange_data').hide();
                $('#dischange_data_setting').removeClass('active');
                $('#receiving_charts_data_send').hide();
                $('#receiving_charts_data_send_setting').removeClass('active');
                $('#receiving_charts_data_receive').hide();
                $('#receiving_charts_data_receive_setting').removeClass('active');
                $('#receiving_charts_data_send_to_billing_room').hide();
                $('#receiving_charts_data_send_to_billing_room_setting').removeClass('active');
                $('#announcement_and_version_menu').offcanvas('hide');

                // Listen for the 'hidden' event on the modal
                $('#building_from_receiving_charts_modal').on('hidden.bs.modal', function() {
                    // This code will run after the modal has fully hidden
                    $('#dischange_data').show();
                    $('#dischange_data_setting').addClass('active');
                    $('#receiving_charts_data_send').hide();
                    $('#receiving_charts_data_send_setting').removeClass('active');
                    $('#receiving_charts_data_receive').hide();
                    $('#receiving_charts_data_receive_setting').removeClass('active');
                    $('#receiving_charts_data_send_to_billing_room').hide();
                    $('#receiving_charts_data_send_to_billing_room_setting').removeClass('active');
                    $('#announcement_and_version_menu').offcanvas('hide');
                    $('#building_from_receiving_charts_form')[0].reset();
                    // $('#building_from_receiving_charts_show_all').hide();
                    fetchAllDischangeData();

                    // It's a good practice to turn off the event listener to prevent multiple triggers
                    $(this).off('hidden.bs.modal');
                });
            });

            $('#receiving_charts_data_send_setting').on('click', function() {
                $('#receiving_charts_data_send').show();
                $('#receiving_charts_data_send_setting').addClass('active');
                $('#dischange_data').hide();
                $('#dischange_data_setting').removeClass('active');
                $('#receiving_charts_data_receive').hide();
                $('#receiving_charts_data_receive_setting').removeClass('active');
                $('#search_data_from_an').hide();
                $('#search_data_from_an_setting').removeClass('active');
                $('#receiving_charts_data_send_to_billing_room').hide();
                $('#receiving_charts_data_send_to_billing_room_setting').removeClass('active');
                fetchAllReceivingChartsDataSend();
                $('#announcement_and_version_menu').offcanvas('hide');
            });

            $('#receiving_charts_data_receive_setting').on('click', function() {
                $('#receiving_charts_data_receive').show();
                $('#receiving_charts_data_receive_setting').addClass('active');
                $('#dischange_data').hide();
                $('#dischange_data_setting').removeClass('active');
                $('#receiving_charts_data_send').hide();
                $('#receiving_charts_data_send_setting').removeClass('active');
                $('#receiving_charts_data_send_to_billing_room').hide();
                $('#receiving_charts_data_send_to_billing_room_setting').removeClass('active');
                fetchAllReceivingChartsDataReceive();
                $('#announcement_and_version_menu').offcanvas('hide');
            });

            $('#receiving_charts_data_send_to_billing_room_setting').on('click', function() {
                $('#receiving_charts_data_send').hide();
                $('#receiving_charts_data_send_setting').removeClass('active');
                $('#dischange_data').hide();
                $('#dischange_data_setting').removeClass('active');
                $('#receiving_charts_data_receive').hide();
                $('#receiving_charts_data_receive_setting').removeClass('active');
                $('#search_data_from_an').hide();
                $('#search_data_from_an_setting').removeClass('active');
                $('#receiving_charts_data_send_to_billing_room').show();
                $('#receiving_charts_data_send_to_billing_room_setting').addClass('active');
                fetchAllReceivingChartsDataSendBillingRoom();
                $('#announcement_and_version_menu').offcanvas('hide');
            });

            $(document).on('change', '.checkbox_send_doctor', function(e) {

                e.preventDefault();
            
                const isChecked = $(this).is(':checked') ? 1 : 0;

                var source = $("#table-dischange-data").attr('data-source');

                // ดึงค่าจาก hidden input ที่อยู่ในแถวเดียวกับ checkbox
                const anValue = $(this).closest('tr').find('.receiving_charts_an').val();
                const hnValue = $(this).closest('tr').find('.receiving_charts_hn').val();
                const fullnameValue = $(this).closest('tr').find('.receiving_charts_fullname').val();
                const wardValue = $(this).closest('tr').find('.receiving_charts_ward').val();
                const dchdateValue = $(this).closest('tr').find('.receiving_charts_dchdate').val();
                const doctorValue = $(this).closest('tr').find('.receiving_charts_doctor').val();
                const receive_chart_date_timeValue = $(this).closest('tr').find('.receiving_charts_receive_chart_date_time').val();
                const receive_chart_staffValue = $(this).closest('tr').find('.receiving_charts_receive_chart_staff').val();

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

                // ส่งข้อมูลผ่าน AJAX ไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: '/report_index_receiving_charts/receivingChartsInsert', // URL ของ endpoint ที่จะรับข้อมูล
                    method: 'POST',          // วิธีการส่งข้อมูล, POST สำหรับการบันทึก
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),  // ตรวจสอบว่ามี CSRF token
                        an: anValue,
                        hn: hnValue,
                        fullname: fullnameValue,
                        ward: wardValue,
                        dchdate: dchdateValue,
                        doctor: doctorValue,
                        receive_chart_date_time: receive_chart_date_timeValue,
                        receive_chart_staff: receive_chart_staffValue,
                        isChecked: isChecked  // ส่งสถานะ checkbox ด้วย
                    },
                    success: function(response) {
                        Swal.close();
                        if(response.status == 200) {
                            swal.fire(
                                response.title,
                                response.message,
                                response.icon
                            );
                            if (source === 'fetchAllDischangeDataSelectDate') {
                                fetchAllDischangeDataSelectDate();
                            } else if(source === 'fetchAllDischangeData') {
                                fetchAllDischangeData();
                            }
                        } else {
                            swal.fire(
                                response.title,
                                response.message,
                                response.icon
                            );
                            if (source === 'fetchAllDischangeDataSelectDate') {
                                fetchAllDischangeDataSelectDate();
                            } else if(source === 'fetchAllDischangeData') {
                                fetchAllDischangeData();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // แสดงข้อความเมื่อมีข้อผิดพลาด
                        console.error('Error saving data:', error);
                    }
                });
            });

            var chart;

            function fetchAllDischangeData() {

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
                    url: '{{ route('dischangeDataFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        Swal.close();
                        $("#table-dischange-data").attr('data-source', 'fetchAllDischangeData');
                        $("#table-dischange-data").html(response);
                        $("#table-list-dischange-data").DataTable({
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
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred: " + status + " - " + error);
                        Swal.close();
                    }
                });
            }

            $('#dischange_data_select_date_submit').on('click', function(e) {
                e.preventDefault();
                fetchAllDischangeDataSelectDate();
            });

            function fetchAllDischangeDataSelectDate() {
                var formData = $('#dischange_data_select_date_form').serialize();

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
                    url: '{{ route('getDischangeDataSelectDate') }}',
                    // Method Get
                    type: 'GET',
                    // ส่งข้อมูลด้วยตัวแปร formData
                    data: formData,
                    // เมื่อมีการส่ง Response กลับมา
                    success: function(response) {
                        // เรียกใช้งาน Function เพื่อปิด Icon Download
                        Swal.close();
                        if(response) {
                            $("#table-dischange-data").attr('data-source', 'fetchAllDischangeDataSelectDate');
                            $("#table-dischange-data").html(response);
                            $("#table-list-dischange-data").DataTable({
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
                                }
                            });
                        }
                    }
                });
            }

            function fetchAllReceivingChartsDataSend() {

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
                    url: '{{ route('receivingChartsDataSendFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        Swal.close();
                        $("#table-receiving-charts-data-send").attr('data-source', 'fetchAllReceivingChartsDataSend');
                        $("#table-receiving-charts-data-send").html(response);
                        $("#table-list-receiving-charts-data-send").DataTable({
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
                                emptyTable: "Chart คนไข้ที่ส่งให้แพทย์ภายในวัน รับ Chartจากแพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred: " + status + " - " + error);
                        Swal.close();
                    }
                });
            }

            $('#receiving_charts_data_select_date_submit').on('click', function(e) {
                e.preventDefault();
                fetchAllReceivingChartsDataSelectDate();
            });

            function fetchAllReceivingChartsDataSelectDate() {
                var formData = $('#receiving_charts_data_select_date_form').serialize();

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
                    url: '{{ route('getReceivingChartsDataSelectDate') }}',
                    // Method Get
                    type: 'GET',
                    // ส่งข้อมูลด้วยตัวแปร formData
                    data: formData,
                    // เมื่อมีการส่ง Response กลับมา
                    success: function(response) {
                        // เรียกใช้งาน Function เพื่อปิด Icon Download
                        Swal.close();
                        if(response) {
                            $("#table-receiving-charts-data-send").attr('data-source', 'fetchAllReceivingChartsDataSelectDate');
                            $("#table-receiving-charts-data-send").html(response);
                            $("#table-list-receiving-charts-data-send").DataTable({
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
                                    emptyTable: "Chart คนไข้ที่ส่งให้แพทย์ภายในวัน รับ Chartจากแพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                }
                            });
                        }
                    }
                });
            }

            $(document).on('change', '.checkbox_receive_doctor', function(e) {

                e.preventDefault();

                const isChecked = $(this).is(':checked') ? 1 : 0;

                var source = $("#table-receiving-charts-data-send").attr('data-source');

                // ดึงค่าจาก hidden input ที่อยู่ในแถวเดียวกับ checkbox
                const anValue = $(this).closest('tr').find('.receiving_charts_an').val();
                const hnValue = $(this).closest('tr').find('.receiving_charts_hn').val();

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

                // ส่งข้อมูลผ่าน AJAX ไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: '/report_index_receiving_charts/receivingChartsUpdate', // URL ของ endpoint ที่จะรับข้อมูล
                    method: 'POST',          // วิธีการส่งข้อมูล, POST สำหรับการบันทึก
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),  // ตรวจสอบว่ามี CSRF token
                        an: anValue,
                        hn: hnValue,
                        isChecked: isChecked  // ส่งสถานะ checkbox ด้วย
                    },
                    success: function(response) {
                        Swal.close();
                        if(response.status == 200) {
                            swal.fire(
                                response.title,
                                response.message,
                                response.icon
                            );
                            if (source === 'fetchAllReceivingChartsDataSelectDate') {
                                fetchAllReceivingChartsDataSelectDate();
                            } else if(source === 'fetchAllReceivingChartsDataSend') {
                                fetchAllReceivingChartsDataSend();
                            }
                        } else {
                            swal.fire(
                                response.title,
                                response.message,
                                response.icon
                            );
                            if (source === 'fetchAllReceivingChartsDataSelectDate') {
                                fetchAllReceivingChartsDataSelectDate();
                            } else if(source === 'fetchAllReceivingChartsDataSend') {
                                fetchAllReceivingChartsDataSend();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // แสดงข้อความเมื่อมีข้อผิดพลาด
                        console.error('Error saving data:', error);
                    }
                });
            });

            function fetchAllReceivingChartsDataReceive() {
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
                    url: '{{ route('receivingChartsDataReceiveFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        Swal.close();
                        $("#table-receiving-charts-data-receive").attr('data-source', 'fetchAllReceivingChartsDataReceive');
                        $("#table-receiving-charts-data-receive").html(response);
                        $("#table-list-receiving-charts-data-receive").DataTable({
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
                                emptyTable: "Chart คนไข้ที่ส่งให้แพทย์ภายในวัน รับ Chartจากแพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred: " + status + " - " + error);
                        Swal.close();
                    }
                });
            }

            $('#receiving_charts_data_receive_select_date_submit').on('click', function(e) {
                e.preventDefault();
                fetchAllReceivingChartsDataReceiveSelectDate();
            });

            function fetchAllReceivingChartsDataReceiveSelectDate() {
                var formData = $('#receiving_charts_data_receive_select_date_form').serialize();

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
                    url: '{{ route('getReceivingChartsDataReceiveSelectDate') }}',
                    // Method Get
                    type: 'GET',
                    // ส่งข้อมูลด้วยตัวแปร formData
                    data: formData,
                    // เมื่อมีการส่ง Response กลับมา
                    success: function(response) {
                        // เรียกใช้งาน Function เพื่อปิด Icon Download
                        Swal.close();
                        if(response) {
                            $("#table-receiving-charts-data-receive").attr('data-source', 'fetchAllReceivingChartsDataReceiveSelectDate');
                            $("#table-receiving-charts-data-receive").html(response);
                            $("#table-list-receiving-charts-data-receive").DataTable({
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
                                // language: {
                                //     emptyTable: "Chart คนไข้ที่ส่งให้แพทย์ภายในวัน รับ Chart จากแพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                // }
                            });
                        }
                    }
                });
            }

            function fetchAllCountDischange() {
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

                var startDate = $('#ddsdf_min_date').val();
                var endDate = $('#ddsdf_max_date').val();

                if (startDate === '' || endDate === '') {
                    $.ajax({
                        url: '{{ route('fetchAllCountDischange') }}',
                        method: 'GET',
                        success: function(response) {
                            Swal.close();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                            $('#count_dischange_title').text('สรุปรายคนไข้ที่ Dischange ภายในวันที่ : ' + formattedDate);
                            $("#count_dischange_show_all").html(response);

                            // เรียกใช้ DataTable หลังจากแทรกข้อมูลใน DOM แล้ว
                            $("#table-list-count-dischange").DataTable({
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
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred: " + status + " - " + error);
                            Swal.close();
                        }
                    });
                } else {
                    var formData = $('#dischange_data_select_date_form').serialize();
                    $.ajax({
                        url: '{{ route('fetchAllCountDischange') }}',
                        method: 'GET',
                        data: formData,
                        success: function(response) {
                            Swal.close();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                            $('#count_dischange_title').text('สรุปรายคนไข้ที่ Dischange ตั้งวันที่ : ' + startDate + ' ถึง ' + endDate);
                            $("#count_dischange_show_all").html(response);

                            // เรียกใช้ DataTable หลังจากแทรกข้อมูลใน DOM แล้ว
                            $("#table-list-count-dischange").DataTable({
                                responsive: true,
                                destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                                language: {
                                    emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred: " + status + " - " + error);
                            Swal.close();
                        }
                    });
                }
            }

            function fetchAllCountReceivingChartsSending() {
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

                var startDate = $('#rdssdf_min_date').val();
                var endDate = $('#rdssdf_max_date').val();

                if (startDate === '' || endDate === '') {
                    $.ajax({
                        url: '{{ route('fetchAllCountReceivingChartsSending') }}',
                        method: 'GET',
                        success: function(response) {
                            Swal.close();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');

                            $('#count_receiving_charts_send_title').text('สรุป Chart ที่ส่งแพทย์ภายในวันที่ : ' + formattedDate);
                            $("#count_receiving_charts_send_show_all").html(response);

                            // เรียกใช้ DataTable หลังจากแทรกข้อมูลใน DOM แล้ว
                            $("#table-list-count-receiving-charts-send").DataTable({
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
                                    emptyTable: "ไม่มี Charts คนไข้ที่ส่งไปให้แพทย์ภายในวัน!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred: " + status + " - " + error);
                            Swal.close();
                        }
                    });
                } else {
                    var formData = $('#receiving_charts_data_select_date_form').serialize();
                    $.ajax({
                        url: '{{ route('fetchAllCountReceivingChartsSending') }}',
                        method: 'GET',
                        data: formData,
                        success: function(response) {
                            Swal.close();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                            $('#count_receiving_charts_send_title').text('สรุปรายคนไข้ที่ Dischange ตั้งวันที่ : ' + startDate + ' ถึง ' + endDate);
                            $("#count_receiving_charts_send_show_all").html(response);

                            // เรียกใช้ DataTable หลังจากแทรกข้อมูลใน DOM แล้ว
                            $("#table-list-count-receiving-charts-send").DataTable({
                                responsive: true,
                                destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                                language: {
                                    emptyTable: "ไม่มี Charts คนไข้ที่ส่งไปให้แพทย์ภายในวัน!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred: " + status + " - " + error);
                            Swal.close();
                        }
                    });
                }
            }

            function fetchAllCountReceivingChartsReceive() {

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

                var startDate = $('#rcdsdf_min_date').val();
                var endDate = $('#rcdsdf_max_date').val();

                if (startDate === '' || endDate === '') {
                    $.ajax({
                        url: '{{ route('fetchAllCountReceivingChartsReceive') }}',
                        method: 'GET',
                        success: function(response) {
                            Swal.close();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');

                            $('#count_receiving_charts_receive_title').text('สรุป Chart ที่รับจากแพทย์ภายในวันที่ : ' + formattedDate);
                            $("#count_receiving_charts_receive_show_all").html(response);

                            // เรียกใช้ DataTable หลังจากแทรกข้อมูลใน DOM แล้ว
                            $("#table-list-count-receiving-charts-receive").DataTable({
                                responsive: true,
                                destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                                language: {
                                    emptyTable: "ไม่มี Charts คนไข้ที่รับจากแพทย์ภายในวัน!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred: " + status + " - " + error);
                            Swal.close();
                        }
                    });
                } else {
                    var formData = $('#receiving_charts_data_receive_select_date_form').serialize();
                    $.ajax({
                        url: '{{ route('fetchAllCountReceivingChartsReceive') }}',
                        method: 'GET',
                        data: formData,
                        success: function(response) {
                            Swal.close();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                            $('#count_receiving_charts_receive_title').text('สรุป Charts ที่รับจากแพทย์ตั้งวันที่ : ' + startDate + ' ถึง ' + endDate);
                            $("#count_receiving_charts_receive_show_all").html(response);

                            // เรียกใช้ DataTable หลังจากแทรกข้อมูลใน DOM แล้ว
                            $("#table-list-count-receiving-charts-receive").DataTable({
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
                                    emptyTable: "ไม่มี Charts คนไข้ที่รับจากแพทย์ภายในวัน!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred: " + status + " - " + error);
                            Swal.close();
                        }
                    });
                }
            }

            $('#search_data_from_an_submit').on('click', function(e) {

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

                e.preventDefault();
                let formData = $('#search_data_from_an_form').serialize();
                
                $.ajax({
                    url: '{{ route('searchDataFromAn') }}',
                    data: formData,
                    method: 'GET',
                    success: function(response) {
                        Swal.close();
                        if(response.status === 200) {
                            swal.fire(
                                response.title,
                                response.message,
                                response.icon
                            );
                            $('#search_data_from_an_modal').modal('hide');
                            $('#search_data_from_an_form')[0].reset();
                        } else {
                            swal.fire(
                                response.title,
                                response.message,
                                response.icon
                            );
                            $('#search_data_from_an_modal').modal('hide');
                            $('#search_data_from_an_form')[0].reset();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred: " + status + " - " + error);
                        Swal.close();
                    }
                });
            });

            // All Function Send To Billing Room Start
                // OnClick Check Box Send to billing room Start
                    $(document).on('change', '.checkbox_send_billing_room', function(e) {

                        e.preventDefault();

                        const isChecked = $(this).is(':checked') ? 1 : 0;

                        var source = $("#table-receiving-charts-data-receive").attr('data-source');

                        // ดึงค่าจาก hidden input ที่อยู่ในแถวเดียวกับ checkbox
                        const anValue = $(this).closest('tr').find('.send_billing_room_charts_an').val();
                        const hnValue = $(this).closest('tr').find('.send_billing_room_charts_hn').val();

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

                        // ส่งข้อมูลผ่าน AJAX ไปยังเซิร์ฟเวอร์
                        $.ajax({
                            url: '/report_index_receiving_charts/receivingChartsUpdateBillingRoom', // URL ของ endpoint ที่จะรับข้อมูล
                            method: 'POST',          // วิธีการส่งข้อมูล, POST สำหรับการบันทึก
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),  // ตรวจสอบว่ามี CSRF token
                                an: anValue,
                                hn: hnValue,
                                isChecked: isChecked  // ส่งสถานะ checkbox ด้วย
                            },
                            success: function(response) {
                                Swal.close();
                                if(response.status == 200) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    );
                                    if (source === 'fetchAllReceivingChartsDataReceiveSelectDate') {
                                        fetchAllReceivingChartsDataReceiveSelectDate();
                                    } else if(source === 'fetchAllReceivingChartsDataReceive') {
                                        fetchAllReceivingChartsDataReceive();
                                    }
                                } else {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    );
                                    if (source === 'fetchAllReceivingChartsDataReceiveSelectDate') {
                                        fetchAllReceivingChartsDataReceiveSelectDate();
                                    } else if(source === 'fetchAllReceivingChartsDataReceive') {
                                        fetchAllReceivingChartsDataReceive();
                                    }
                                }
                            },
                            error: function(xhr, status, error) {
                                // แสดงข้อความเมื่อมีข้อผิดพลาด
                                console.error('Error saving data:', error);
                            }
                        });
                    });

                    function fetchAllReceivingChartsDataSendBillingRoom() {

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
                            url: '{{ route('receivingChartsDataSendBillingRoomFetchAll') }}',
                            method: 'get',
                            success: function(response) {
                                Swal.close();
                                $("#table-receiving-charts-data-send-billing-room").attr('data-source', 'fetchAllReceivingChartsDataSendBillingRoom');
                                $("#table-receiving-charts-data-send-billing-room").html(response);
                                $("#table-list-receiving-charts-data-send-billing-room").DataTable({
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
                                        emptyTable: "Chart คนไข้ที่ส่งให้ห้องเรียกเก็บภายในวัน รับ Chart จากแพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error occurred: " + status + " - " + error);
                                Swal.close();
                            }
                        });
                    }
                // OnClick Check Box Send to billing room End

                // OnClick Select Date Start
                    $('#receiving_charts_data_send_to_billing_room_submit').on('click', function(e) {
                        e.preventDefault();
                        fetchAllReceivingChartsDataSendBillingRoomSelectDate();
                    });

                    function fetchAllReceivingChartsDataSendBillingRoomSelectDate() {
                        var formData = $('#receiving_charts_data_send_to_billing_room_form').serialize();

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
                            url: '{{ route('getReceivingChartsDataSendBillingRoomSelectDate') }}',
                            // Method Get
                            type: 'GET',
                            // ส่งข้อมูลด้วยตัวแปร formData
                            data: formData,
                            // เมื่อมีการส่ง Response กลับมา
                            success: function(response) {
                                // เรียกใช้งาน Function เพื่อปิด Icon Download
                                Swal.close();
                                if(response.status != 400) {
                                    $("#table-receiving-charts-data-send-billing-room").attr('data-source', 'fetchAllReceivingChartsDataSendBillingRoomSelectDate');
                                    $("#table-receiving-charts-data-send-billing-room").html(response);
                                    $("#table-list-receiving-charts-data-send-billing-room").DataTable({
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
                                    });
                                } else {
                                    Swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                }
                            }
                        });
                    }
                // OnClick Select Date End

                // OnClick Modal Start
                function fetchAllCountReceivingChartsSendBillingRoom() {
                    
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

                    var startDate = $('#rcdst16_min_date').val();
                    var endDate = $('#rcdst16_max_date').val();

                    if (startDate === '' || endDate === '') {
                        $.ajax({
                            url: '{{ route('fetchAllCountReceivingChartsSendBillingRoom') }}',
                            method: 'GET',
                            success: function(response) {
                                Swal.close();
                                // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                                var today = new Date();

                                // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                                var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');

                                $('#receiving_charts_data_send_to_billing_room_title').text('สรุป Chart ที่ส่งไปยังห้องเรียกเก็บภายในวันที่ : ' + formattedDate);
                                $("#count_receiving_charts_billing_room_show_all").html(response);

                                // เรียกใช้ DataTable หลังจากแทรกข้อมูลใน DOM แล้ว
                                $("#table-list-count-receiving-charts-send-billing-room").DataTable({
                                    responsive: true,
                                    destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                                    language: {
                                        emptyTable: "ไม่มี Charts คนไข้ที่ส่งไปยังห้องเรียกเก็บภายในวัน!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error occurred: " + status + " - " + error);
                                Swal.close();
                            }
                        });
                    } else {
                        var formData = $('#receiving_charts_data_send_to_billing_room_form').serialize();
                        $.ajax({
                            url: '{{ route('fetchAllCountReceivingChartsSendBillingRoom') }}',
                            method: 'GET',
                            data: formData,
                            success: function(response) {
                                Swal.close();
                                // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                                var today = new Date();

                                // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                                var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                                $('#receiving_charts_data_send_to_billing_room_title').text('สรุป Charts ที่ส่งไปยังห้องเรียกเก็บตั้งวันที่ : ' + startDate + ' ถึง ' + endDate);
                                $("#count_receiving_charts_billing_room_show_all").html(response);

                                // เรียกใช้ DataTable หลังจากแทรกข้อมูลใน DOM แล้ว
                                $("#table-list-count-receiving-charts-send-billing-room").DataTable({
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
                                        emptyTable: "ไม่มี Charts คนไข้ที่ส่งไปยังห้องเรียกเก็บภายในวัน!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error occurred: " + status + " - " + error);
                                Swal.close();
                            }
                        });
                    }
                }
                // OnClick Modal End
            // All Function Send To Billing Room End

            // Building From Receiving Charts( คนไข้ที่ Dischange แล้วแต่ยังไม่มีการรับ Charts มาจากในตึก ) Start
                $('#building_from_receiving_charts_submit').on('click', function(e) {
                    e.preventDefault();
                    var formData = $('#building_from_receiving_charts_form').serialize();
                    buildingFromReceivingCharts(formData);
                });

                function buildingFromReceivingCharts(formData) {
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
                        url: '{{ route('getBuildingFromReceivingCharts') }}',
                        // Method Get
                        type: 'GET',
                        // ส่งข้อมูลด้วยตัวแปร formData
                        data: formData,
                        // เมื่อมีการส่ง Response กลับมา
                        success: function(response) {
                            // เรียกใช้งาน Function เพื่อปิด Icon Download
                            Swal.close();
                            if(response) {
                                $("#building_from_receiving_charts_show_all").attr('data-source', 'fetchAllBuildingFromReceivingCharts');
                                $("#building_from_receiving_charts_show_all").html(response);
                                $("#table-building-from-receiving-charts").DataTable({
                                    responsive: true,
                                    order: [4, 'asc'],
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
                                        emptyTable: "Chart คนไข้ที่ Dischange แล้วแต่ยังไม่ได้รับ Chartsมาจากในตึก!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                    }
                                });
                            }
                        }
                    });
                }
            // Building From Receiving Charts( คนไข้ที่ Dischange แล้วแต่ยังไม่มีการรับ Charts มาจากในตึก ) End
            
        });
    </script>
@endsection
