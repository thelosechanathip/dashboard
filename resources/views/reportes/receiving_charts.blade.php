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
    <main class="main-content">
        {{-- Title Start --}}
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
                <div class="">
                    <h1 class="h2">รายงานการ ( รับ - ส่ง ) Chart ให้แพทย์</h1>
                </div>
                <div class="d-flex">
                    <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                    <p>&nbsp;&nbsp;&nbsp;</p>
                    <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
                </div>
            </div>
        {{-- Title End --}}

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
        {{-- Modal End --}}

        <div class="border-bottom pb-3">  
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <a type="button" class="btn btn-outline-success" href="#dischange_data" id="dischange_data_setting">ข้อมูลคนไข้ Dischange</a>
                <a type="button" class="btn btn-outline-success" href="#receiving_charts_data_send" id="receiving_charts_data_send_setting">ข้อมูล Chart คนไข้ที่ส่งแพทย์</a>
                <a type="button" class="btn btn-outline-success" href="#receiving_charts_data_receive" id="receiving_charts_data_receive_setting">ข้อมูล Chart คนไข้ที่รับจากแพทย์</a>
                <div class="spinner-border loadingIcon ms-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            
        </div>

        <div class="mt-3 card shadow-lg" id="dischange_data">
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
                <div class="mt-5" id="table-dischange-data"></div>
            </div>
        </div>

        <div class="mt-3 card shadow-lg" id="receiving_charts_data_send">
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
                <div class="mt-5" id="table-receiving-charts-data-send"></div>
            </div>
        </div>

        <div class="mt-3 card shadow-lg" id="receiving_charts_data_receive">
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
                <div class="mt-5" id="table-receiving-charts-data-receive"></div>
            </div>
        </div>

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

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

            function showLoadingIcon() {
                $('.loadingIcon').show();
            }

            function hideLoadingIcon() {
                $('.loadingIcon').hide();
            }

            defaultPage();

            function defaultPage() {
                $('#dischange_data').hide();
                $('#receiving_charts_data_send').hide();
                $('#receiving_charts_data_receive').hide();
                hideLoadingIcon();
            }

            $('#dischange_data_setting').on('click', function() {
                $('#dischange_data').show();
                $('#dischange_data_setting').addClass('active');
                $('#receiving_charts_data_send').hide();
                $('#receiving_charts_data_send_setting').removeClass('active');
                $('#receiving_charts_data_receive').hide();
                $('#receiving_charts_data_receive_setting').removeClass('active');
                fetchAllDischangeData();
            });

            $('#receiving_charts_data_send_setting').on('click', function() {
                $('#receiving_charts_data_send').show();
                $('#receiving_charts_data_send_setting').addClass('active');
                $('#dischange_data').hide();
                $('#dischange_data_setting').removeClass('active');
                $('#receiving_charts_data_receive').hide();
                $('#receiving_charts_data_receive_setting').removeClass('active');
                fetchAllReceivingChartsDataSend();
            });

            $('#receiving_charts_data_receive_setting').on('click', function() {
                $('#receiving_charts_data_receive').show();
                $('#receiving_charts_data_receive_setting').addClass('active');
                $('#dischange_data').hide();
                $('#dischange_data_setting').removeClass('active');
                $('#receiving_charts_data_send').hide();
                $('#receiving_charts_data_send_setting').removeClass('active');
                fetchAllReceivingChartsDataReceive();
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
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('dischangeDataFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        hideLoadingIcon();
                        $("#table-dischange-data").attr('data-source', 'fetchAllDischangeData');
                        $("#table-dischange-data").html(response);
                        $("#table-list-dischange-data").DataTable({
                            responsive: true,
                            destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                            language: {
                                emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred: " + status + " - " + error);
                        hideLoadingIcon();
                    }
                });
            }

            $('#dischange_data_select_date_submit').on('click', function(e) {
                e.preventDefault();
                fetchAllDischangeDataSelectDate();
            });

            function fetchAllDischangeDataSelectDate() {
                var formData = $('#dischange_data_select_date_form').serialize();
                showLoadingIcon();
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
                        hideLoadingIcon();
                        if(response) {
                            $("#table-dischange-data").attr('data-source', 'fetchAllDischangeDataSelectDate');
                            $("#table-dischange-data").html(response);
                            $("#table-list-dischange-data").DataTable({
                                responsive: true,
                                destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                                language: {
                                    emptyTable: "Chart คนไข้ที่ Dischange ภายในวันส่ง Chart ไปให้แพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                }
                            });
                        }
                    }
                });
            }

            function fetchAllReceivingChartsDataSend() {
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('receivingChartsDataSendFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        hideLoadingIcon();
                        $("#table-receiving-charts-data-send").attr('data-source', 'fetchAllReceivingChartsDataSend');
                        $("#table-receiving-charts-data-send").html(response);
                        $("#table-list-receiving-charts-data-send").DataTable({
                            responsive: true,
                            destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                            language: {
                                emptyTable: "Chart คนไข้ที่ส่งให้แพทย์ภายในวัน รับ Chartจากแพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred: " + status + " - " + error);
                        hideLoadingIcon();
                    }
                });
            }

            $('#receiving_charts_data_select_date_submit').on('click', function(e) {
                e.preventDefault();
                fetchAllReceivingChartsDataSelectDate();
            });

            function fetchAllReceivingChartsDataSelectDate() {
                var formData = $('#receiving_charts_data_select_date_form').serialize();
                showLoadingIcon();
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
                        hideLoadingIcon();
                        if(response) {
                            $("#table-receiving-charts-data-send").attr('data-source', 'fetchAllReceivingChartsDataSelectDate');
                            $("#table-receiving-charts-data-send").html(response);
                            $("#table-list-receiving-charts-data-send").DataTable({
                                responsive: true,
                                destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
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
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('receivingChartsDataReceiveFetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        hideLoadingIcon();
                        $("#table-receiving-charts-data-receive").attr('data-source', 'fetchAllReceivingChartsDataReceive');
                        $("#table-receiving-charts-data-receive").html(response);
                        $("#table-list-receiving-charts-data-receive").DataTable({
                            responsive: true,
                            destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                            language: {
                                emptyTable: "Chart คนไข้ที่ส่งให้แพทย์ภายในวัน รับ Chartจากแพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred: " + status + " - " + error);
                        hideLoadingIcon();
                    }
                });
            }

            $('#receiving_charts_data_receive_select_date_submit').on('click', function(e) {
                e.preventDefault();
                fetchAllReceivingChartsDataReceiveSelectDate();
            });

            function fetchAllReceivingChartsDataReceiveSelectDate() {
                var formData = $('#receiving_charts_data_receive_select_date_form').serialize();
                showLoadingIcon();
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
                        hideLoadingIcon();
                        if(response) {
                            $("#table-receiving-charts-data-receive").attr('data-source', 'fetchAllReceivingChartsDataReceiveSelectDate');
                            $("#table-receiving-charts-data-receive").html(response);
                            $("#table-list-receiving-charts-data-receive").DataTable({
                                responsive: true,
                                destroy: true,  // เพื่อป้องกันการซ้อนของ DataTables
                                // language: {
                                //     emptyTable: "Chart คนไข้ที่ส่งให้แพทย์ภายในวัน รับ Chart จากแพทย์หมดแล้ว!"  // ข้อความที่จะแสดงเมื่อไม่มีข้อมูล
                                // }
                            });
                        }
                    }
                });
            }

            function fetchAllCountDischange() {
                showLoadingIcon();

                var startDate = $('#ddsdf_min_date').val();
                var endDate = $('#ddsdf_max_date').val();

                if (startDate === '' || endDate === '') {
                    $.ajax({
                        url: '{{ route('fetchAllCountDischange') }}',
                        method: 'GET',
                        success: function(response) {
                            hideLoadingIcon();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                            $('#count_dischange_title').text('สรุปรายคนไข้ที่ Dischange ภายในวันที่ : ' + formattedDate);
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
                            hideLoadingIcon();
                        }
                    });
                } else {
                    var formData = $('#dischange_data_select_date_form').serialize();
                    $.ajax({
                        url: '{{ route('fetchAllCountDischange') }}',
                        method: 'GET',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
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
                            hideLoadingIcon();
                        }
                    });
                }
            }

            function fetchAllCountReceivingChartsSending() {
                showLoadingIcon();

                var startDate = $('#rdssdf_min_date').val();
                var endDate = $('#rdssdf_max_date').val();

                if (startDate === '' || endDate === '') {
                    $.ajax({
                        url: '{{ route('fetchAllCountReceivingChartsSending') }}',
                        method: 'GET',
                        success: function(response) {
                            hideLoadingIcon();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');

                            $('#count_receiving_charts_send_title').text('สรุป Chart ที่ส่งแพทย์ภายในวันที่ : ' + formattedDate);
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
                            hideLoadingIcon();
                        }
                    });
                } else {
                    var formData = $('#receiving_charts_data_select_date_form').serialize();
                    $.ajax({
                        url: '{{ route('fetchAllCountReceivingChartsSending') }}',
                        method: 'GET',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
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
                            hideLoadingIcon();
                        }
                    });
                }
            }

            function fetchAllCountReceivingChartsReceive() {
                showLoadingIcon();

                var startDate = $('#rcdsdf_min_date').val();
                var endDate = $('#rcdsdf_max_date').val();

                if (startDate === '' || endDate === '') {
                    $.ajax({
                        url: '{{ route('fetchAllCountReceivingChartsReceive') }}',
                        method: 'GET',
                        success: function(response) {
                            hideLoadingIcon();
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
                            hideLoadingIcon();
                        }
                    });
                } else {
                    var formData = $('#receiving_charts_data_receive_select_date_form').serialize();
                    $.ajax({
                        url: '{{ route('fetchAllCountReceivingChartsReceive') }}',
                        method: 'GET',
                        data: formData,
                        success: function(response) {
                            hideLoadingIcon();
                            // แสดงข้อมูลที่ได้รับใน element ที่ต้องการ
                            var today = new Date();

                            // แสดงวันที่ในรูปแบบ ปี-เดือน-วัน (YYYY-MM-DD)
                            var formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                            $('#count_receiving_charts_receive_title').text('สรุป Charts ที่รับจากแพทย์ตั้งวันที่ : ' + startDate + ' ถึง ' + endDate);
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
                            hideLoadingIcon();
                        }
                    });
                }
            }
        });
    </script>
@endsection
