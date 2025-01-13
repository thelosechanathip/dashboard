@extends('layout.dashboard_template')

@section('title')
    <title>รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย</title>
@endsection

@section('content')
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
                        <h1 class="h2">รายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}

        {{-- All Form Date Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" id="form_all">
                <div class="d-flex justify-content-center align-items-center mt-4">
                    {{-- Form ดึงรายชื่อรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย Start --}}
                        <form id="e_claim_withdrawal_list_name_form">
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
                                    <button type="button" id="e_claim_withdrawal_list_name_submit" class="btn btn-primary ms-1 zoom-card">ยืนยัน</button>
                                </div>
                            </div>
                        </form>
                    {{-- Form ดึงรายชื่อรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย End --}}
                </div>
            </div>
        {{-- All Form Date End --}}

        {{-- แสดงข้อมูลรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย ตาม วันที่, สถานบริการ, สถานการมีชีวิตหรือยังมีชีวิต แบบ Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="e_claim_withdrawal_list_name_table">
                <div class="mx-5 w-auto">
                    <div class="my-5 ms-0 w-auto">
                        <div class="w-auto" id="fetch-list-name"></div>
                    </div>
                </div>
            </div>
        {{-- แสดงข้อมูลรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย ตาม วันที่, สถานบริการ, สถานการมีชีวิตหรือยังมีชีวิต แบบ Table End --}}
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // เริ่มต้น Hide Start
                $('#e_claim_withdrawal_list_name_table').hide();
                $('.loadingIcon').hide();
            // เริ่มต้น Hide End

            // Set Text Start
                function setText(request) {
                    if(request == 0) {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('');
                        $('#setCount').text('ไม่มีรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย');
                    } else {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('จำนวนรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้ายที่แยกตาม รพสต. : ');
                        $('#setCount').text(request + ' ราย');
                    }
                }
            // Set Text End

            // Hide Form && Chart && Table Start
                function hideForm() {
                    $('#setText').hide();
                    $('#setCount').hide();
                    $('#e_claim_withdrawal_list_name_table').hide();
                    $('#e_claim_withdrawal_list_name_form').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // ดึงข้อมูลรายชื่อรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือยังมีชีวิต Start
                $('#e_claim_withdrawal_list_name_submit').click(function(e) {
                    e.preventDefault();
                    var formData = $('#e_claim_withdrawal_list_name_form').serialize();

                    $('#e_claim_withdrawal_list_name_table').hide();
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
                        url: '{{ route('getEClaimWithdrawalFetchListName') }}',
                        type: 'GET',
                        data: formData,
                        success: function(response) {
                            Swal.close(); // Close Swal when the request is successful

                            if (response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#e_claim_withdrawal_list_name_table').show();
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
                        },
                        error: function() {
                            Swal.close(); // Close Swal when there's an error
                            swal.fire(
                                'Error',
                                'ไม่สามารถโหลดข้อมูลได้ โปรดลองอีกครั้ง',
                                'error'
                            );
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อรายการเบิก E-claim สำหรับผู้ป่วยระยะสุดท้าย ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือยังมีชีวิต End

        });
    </script>
@endsection
