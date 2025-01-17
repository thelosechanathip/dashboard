@extends('layout.dashboard_template')

@section('title')
    <title>Advance Care Plan</title>
@endsection

@section('content')
    {{-- Advance Care Plan Start --}}
        <div class="modal fade " id="advance_care_plan_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="advance_care_plan_title">Advance Care Plan</h5>
                        {{-- <div class="spinner-border loadingIcon ms-3" style="" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div> --}}
                        <button type="button" class="btn-close zoom-card action-button" mode="" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="advance_care_plan_form" method="POST">
                            @csrf
                            <input type="hidden" id="mode" mode="">
                            <input type="hidden" id="acp_id" name="acp_id">
                            <input type="hidden" id="acp_file_acp" name="acp_file_acp">
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
                            {{-- <div class="mb-2" id="file_acp"> --}}
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
    <!-- Modal สำหรับแสดงรูปภาพขนาดเต็ม Start -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="" id="imageModalSrc" class="img-fluid" alt="Full Size Image">
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal สำหรับแสดงรูปภาพขนาดเต็ม End -->
    <main class="main-content mb-5" id="main">
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
                        <h1 class="h2">Advance Care Plan</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}
        <div class="mt-3 card shadow-lg w-100" id="advance_care_plan_list_name_table">
            <div class="mx-5 w-auto">
                <div class="my-5 ms-0 w-auto">
                    <div class="w-auto" id="advance_care_plan_fetch_data"></div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#advance_care_plan_modal').on('hidden.bs.modal', function () {
                $('#advance_care_plan_form')[0].reset();
            });

            $(document).on('click', '.advance_care_plan_find', function (e) {
                e.preventDefault();
                
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

                let id = $(this).attr('id');
                $('#mode').attr('mode', 'edit');
                $('#advance_care_plan_title').text('อัพเดทข้อมูล');
                
                $.ajax({
                    url: '{{ route('findOneAdvanceCarePlan') }}',
                    method: 'get',
                    data: { id: id },
                    success: function(response) {
                        Swal.close();
                        $('#acp_vn').val(response.acp_vn);
                        $('#acp_hn').val(response.acp_hn);
                        $('#acp_cid').val(response.acp_cid);
                        $('#acp_fullname').val(response.acp_fullname);
                        $('#detail_of_talking_with_patients').val(response.detail_of_talking_with_patients);
                        $("#acp_id").val(response.id);
                        $("#acp_file_acp").val(response.file_acp);
                    }
                });
            });

            $(document).on('click', '.advance_care_plan_delete', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                    title: 'ต้องการลบรายการใช่หรือไม่?',
                    text: "กรุณาตรวจสอบรายการดีก่อนลบ!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ฉันต้องการลบ!',
                    cancelButtonText: 'ไม่, ฉันจะยกเลิกการลบ!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('deleteAdvanceCarePlan') }}',
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        tile: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        $("#advance_care_plan_form")[0].reset();
                                        $("#advance_care_plan_modal").modal('hide');
                                        fetchAllAdvanceCarePlan();
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $('#advance_care_plan_form').submit(function(e) {
                const mode = $('#mode').attr('mode');
                if(mode === 'edit') {
                    e.preventDefault();
                    const fd = new FormData(this);

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
                        url: '{{ route('updateDataAdvanceCarePlan') }}',
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
                                swal.fire({
                                    tile: response.title,
                                    text: response.message,
                                    icon: response.icon
                                }).then((result) => {
                                    $("#advance_care_plan_form")[0].reset();
                                    $("#advance_care_plan_modal").modal('hide');
                                    fetchAllAdvanceCarePlan();
                                });
                            }
                        }
                    });
                }
            });

            fetchAllAdvanceCarePlan();
            function fetchAllAdvanceCarePlan() {

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
                    url: '{{ route('fetchAllAdvanceCarePlan') }}',
                    method: 'get',
                    success: function(response) {
                        Swal.close();
                        $("#advance_care_plan_fetch_data").html(response);
                        $("#table_advance_care_plan_fetch_data").DataTable({
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
                            // "scrollX": true
                        });
                    }
                });
            }

             // เมื่อผู้ใช้คลิกที่รูปภาพ
             $('#imageModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // ปุ่มหรือรูปที่ถูกคลิก
                var imgSrc = button.data('img'); // ดึง URL ของรูปจาก attribute data-img
                var modal = $(this);
                modal.find('#imageModalSrc').attr('src', imgSrc); // ตั้งค่า src ของรูปใน modal ให้ตรงกับรูปที่ถูกคลิก
            });
        });
    </script>
@endsection