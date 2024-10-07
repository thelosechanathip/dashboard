@extends('layout.dashboard_template')

@section('title')
    <title>ระบบแจ้งซ่อม</title>
@endsection

@section('content')
    {{-- Repair Notification System Modal Start --}}
        <div class="modal fade" id="repair_notification_system_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repair_notification_system_title"></h5>
                        <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="repair_notification_system_form" style="max-width: 300px; margin: 0 auto;" method="POST">
                            @csrf
                            <input type="hidden" id="mode" mode="">
                            <input type="hidden" id="repair_notification_system_id_find_one" name="repair_notification_system_id_find_one">
                            <div class="mb-3">
                                <label for="working_type_id" class="form-label">ประเภทของการซ่อม</label>
                                <select class="form-select" aria-label="Default select example" name="working_type_id" id="working_type_id">
                                    <option selected value="0">--------------</option>
                                    @foreach($working_type_model AS $wtm)
                                        <option value="{{ $wtm->id }}">{{ $wtm->working_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name_of_information" class="form-label">ชื่อผู้แจ้งซ่อม</label>
                                <select class="form-select" aria-label="Default select example" name="name_of_information" id="name_of_information">
                                    <option selected value="0">--------------</option>
                                    @foreach($opduser_model AS $oum)
                                        <option value="{{ $oum->name }}">{{ $oum->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="detail" class="form-label">รายละเอียดการซ่อม</label>
                                <textarea class="form-control" placeholder="กรอกรายละเอียดการซ่อม" id="detail" name="detail"></textarea>
                            </div>
                            <div class="mb-3 d-flex flex-column">
                                <label for="signature" class="form-label">ลายเซ็นผู้รับงาน</label>
                                <canvas height="100" width="300" class="signature-pad" style="border: 2px solid #000; border-radius: 4px;"></canvas>
                                <a href="#" class="mt-2 btn btn-outline-danger clear-signature">ลบลายเซ็น</a>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary zoom-card" id="repair_notification_system_submit"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- Repair Notification System Modal End --}}
    <main class="main-content">
        {{-- Title Start --}}
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
                <div class="d-flex">
                    <button class="btn btn-outline-danger zoom-card me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left-circle-fill"></i>
                        Back
                    </button>
                    <h1 class="h2">ระบบแจ้งซ่อม</h1>
                </div>
                <div class="d-flex">
                    <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                    <p>&nbsp;&nbsp;&nbsp;</p>
                    <p> <span class="fw-bold">Group :</span> {{ $data['groupname'] }}</p>
                </div>
            </div>
        {{-- Title End --}}
        @if(isset($data['error']))
            <div class="alert alert-danger" role="alert">
                {{ $data['error'] }}
            </div>
        @endif
        <div class="row gy-4 mt-2" id="all_repair_notification_system">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-lg zoom-card">
                    <a href="{{ route('working_type_index') }}" class="text-decoration-none text-dark d-flex justify-between row">
                        <div class="card-body bg-primary text-light d-flex justify-content-center align-items-center col-4">
                            <i class="bi bi-clipboard-data fs-3"></i>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center col-8">
                            <h5 class="card-title fw-bold">เพิ่มข้อมูลประเภทของงาน</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="my-1" id="repair_notification_system_setting_page">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="" id="text_title">
                    <h2 class="text_title">ระบบแจ้งซ่อม</h2>
                </div>
                <div class="spinner-border" id="loadingIconRepairNotificationSystem" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn btn-success zoom-card repair_notification_system_modal_add mt-2 mt-md-0 " id="repair_notification_system_modal_add" data-bs-toggle="modal" data-bs-target="#repair_notification_system_modal">เพิ่มรายการซ่อม</button>
            </div>
            <hr>
            <div class="" id="repair_notification_system_show_data_all"></div>
            {{-- <div class="mb-3">
                <label for="name_of_information" class="form-label">ชื่อผู้แจ้งซ่อม</label>
                <select class="form-select" aria-label="Default select example" name="name_of_information" id="name_of_information">
                    <option selected value="0">--------------</option>
                    @foreach($opduser_model AS $oum)
                        <option value="{{ $oum->name }}">{{ $oum->name }}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Default Function Start
                $('#text_title').show();
                $('#loadingIconRepairNotificationSystem').hide();
            // Default Function End

            // Function Icon Download Start
                // Version Detail Start
                    function showLoadingIconRepairNotificationSystem() {
                        $('#loadingIconRepairNotificationSystem').show();
                        $('#text_title').hide();
                    }

                    function hideLoadingIconRepairNotificationSystem() {
                        $('#loadingIconRepairNotificationSystem').hide();
                        $('#text_title').show();
                    }
                // Version Detail End
            // Function Icon Download End

            // Change Mode add || update Start
                // Repair Notification System Start
                    $('.repair_notification_system_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#repair_notification_system_title').text('เพิ่มข้อมูลการซ่อม');
                        $('#repair_notification_system_submit').text('ยืนยันการบันทึก');
                        $("#repair_notification_system_form")[0].reset();
                    });

                    $(document).on('click', '.repair_notification_system_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#repair_notification_system_title').text('แก้ไขข้อมูลการซ่อม');
                        $('#repair_notification_system_submit').text('ยืนยันการแก้ไข');
                    });
                // Repair Notification System End
            // Change Mode add || update End

            // // Reset Form Start
            //     $('.btn-close').on('click', function() {
            //         $("#working_type_form")[0].reset();
            //     });
            // // Reset Form End

            // // Fetch All Data Working Type Start
            //     fetchAllDataWorkingType();

            //     function fetchAllDataWorkingType() {
            //         showLoadingIconWorkingType();
            //         $.ajax({
            //             url: '{{ route('fetchAllDataWorkingType') }}',
            //             method: 'get',
            //             success: function(response) {
            //                 hideLoadingIconWorkingType();
            //                 $("#working_type_show_data_all").html(response);
            //                 $("#working_type_table").DataTable({
            //                     // order: [0, 'ASC']
            //                 });
            //             }
            //         });
            //     }
            // // Fetch All Data Working Type End

            // // Insert && Update Data Working Type Start
            //     $("#working_type_form").submit(function(e) {
            //         const mode = $('#mode').attr('mode');
            //         if(mode === 'add') {
            //             e.preventDefault();
            //             const fd = new FormData(this);
            //             $.ajax({
            //                 url: '{{ route('insertDataWorkingType') }}',
            //                 method: 'post',
            //                 data: fd,
            //                 cache: false,
            //                 contentType: false,
            //                 processData: false,
            //                 dataType: 'json',
            //                 success: function(response) {
            //                     if(response.status === 400) {
            //                         swal.fire(
            //                             response.title,
            //                             response.message,
            //                             response.icon
            //                         )
            //                     } else {
            //                         swal.fire(
            //                             response.title,
            //                             response.message,
            //                             response.icon
            //                         )
            //                         fetchAllDataWorkingType();
            //                         $("#working_type_form")[0].reset();
            //                         $("#working_type_modal").modal('hide');
            //                     }
            //                 }
            //             });
            //         } else if(mode === 'update') {
            //             e.preventDefault();
            //             const fd = new FormData(this);
            //             $.ajax({
            //                 url: '{{ route('updateDataWorkingType') }}',
            //                 method: 'post',
            //                 data: fd,
            //                 cache: false,
            //                 contentType: false,
            //                 processData: false,
            //                 dataType: 'json',
            //                 success: function(response) {
            //                     if(response.status === 400) {
            //                         swal.fire(
            //                             response.title,
            //                             response.message,
            //                             response.icon
            //                         )
            //                     } else {
            //                         swal.fire(
            //                             response.title,
            //                             response.message,
            //                             response.icon
            //                         )
            //                         fetchAllDataWorkingType();
            //                         $("#working_type_form")[0].reset();
            //                         $("#working_type_modal").modal('hide');
            //                     }
            //                 }
            //             });
            //         } else {
            //             console.log('Mode ไม่ถูกต้อง');
            //         }
            //     });
            // // Insert && Update Data Working Type End

            // // Find One Data Working Type Start
            //     $(document).on('click', '.working_type_modal_find', function(e) {
            //         e.preventDefault();
            //         let id = $(this).attr('id');
            //         $.ajax({
            //             url: '{{ route('findOneDataWorkingType') }}',
            //             method: 'get',
            //             data: {
            //                 id: id,
            //                 _token: '{{ csrf_token() }}'
            //             },
            //             success: function(response) {
            //                 $("#working_type_name").val(response.working_type_name);
            //                 $("#working_type_id_find_one").val(response.id);
            //             }
            //         });
            //     });
            // // Find One Data Working Type End

            // // Delete Data Working Type Start
            //     $(document).on('click', '.working_type_delete', function(e) {
            //         e.preventDefault();
            //         let id = $(this).attr('id');
            //         console.log(id);
            //         let csrf = '{{ csrf_token() }}';
            //         Swal.fire({
            //             title: 'Are you sure?',
            //             text: "You won't be able to revert this!",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: 'Yes, delete it!'
            //         }).then((result) => {
            //             if (result.isConfirmed) {
            //                 $.ajax({
            //                     url: '{{ route('deleteDataWorkingType') }}',
            //                     method: 'delete',
            //                     data: {
            //                         id: id,
            //                         _token: csrf
            //                     },
            //                     success: function(response) {
            //                         if(response.status === 400) {
            //                             swal.fire(
            //                                 response.title,
            //                                 response.message,
            //                                 response.icon
            //                             )
            //                         } else {
            //                             swal.fire(
            //                                 response.title,
            //                                 response.message,
            //                                 response.icon
            //                             )
            //                             fetchAllDataWorkingType();
            //                         }
            //                     }
            //                 });
            //             }
            //         })
            //     });
            // // Delete Data Working Type End

            // form.on('submit', function(event) {
            //     event.preventDefault(); // ป้องกันการ reload หน้า

            //     const imageURL = canvas.toDataURL(); // แปลงลายเซ็นใน canvas เป็น data URL

            //     // ส่งข้อมูลลายเซ็นไปยังเซิร์ฟเวอร์ด้วย AJAX
            //     $.ajax({
            //         type: 'POST',
            //         data: {
            //             signature: imageURL, // ส่งข้อมูล URL ของลายเซ็น
            //             // เพิ่มข้อมูลอื่น ๆ ที่ต้องการใน form ได้ตามต้องการ
            //             _token: $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function(response) {
            //             // การทำงานเมื่อส่งข้อมูลสำเร็จ
            //             console.log('ลายเซ็นถูกส่งสำเร็จ');
            //             clearPad(); // ล้าง pad หลังจากส่งข้อมูล
            //         },
            //         error: function(xhr, status, error) {
            //             // การทำงานเมื่อเกิดข้อผิดพลาด
            //             console.error('เกิดข้อผิดพลาดในการส่งลายเซ็น:', status, error);
            //         }
            //     });
            // });

            $('#repair_notification_system_modal').on('shown.bs.modal', function () {
                $('#name_of_information').select2({
                    placeholder: 'ค้นหาชื่อผู้แจ้งซ่อม',  
                    allowClear: true,
                    dropdownParent: $('#repair_notification_system_modal') // กำหนดให้ dropdown ของ select2 อยู่ภายใน modal
                });

                $('#working_type_id').select2({
                    placeholder: 'ค้นหาชื่อผู้แจ้งซ่อม',  
                    allowClear: true,
                    dropdownParent: $('#repair_notification_system_modal') // กำหนดให้ dropdown ของ select2 อยู่ภายใน modal
                });
            });

            // ตัวจัดการ Signature( ลายเซ็น ) Start
                const canvas = $('canvas')[0];
                const ctx = canvas.getContext('2d');
                let writingMode = false;

                // ป้องกันการเลื่อนหน้าในมือถือขณะเซ็นลายเซ็น
                function preventScroll(event) {
                    event.preventDefault();
                }

                const clearPad = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }

                const getTargetPosition = (event) => {
                    const rect = event.target.getBoundingClientRect();
                    const positionX = event.touches ? event.touches[0].clientX - rect.left : event.clientX - rect.left;
                    const positionY = event.touches ? event.touches[0].clientY - rect.top : event.clientY - rect.top;

                    return [positionX, positionY];
                }

                const handlePointerMove = (event) => {
                    if (!writingMode) return;

                    const [positionX, positionY] = getTargetPosition(event);
                    ctx.lineTo(positionX, positionY);
                    ctx.stroke();
                }

                const handlePointerUp = () => {
                    writingMode = false;
                    window.removeEventListener('touchmove', preventScroll); // ยกเลิกการป้องกันการเลื่อนเมื่อหยุดเขียน
                }

                const handlePointerDown = (event) => {
                    writingMode = true;
                    ctx.beginPath();

                    const [positionX, positionY] = getTargetPosition(event);
                    ctx.moveTo(positionX, positionY);

                    window.addEventListener('touchmove', preventScroll, { passive: false }); // ป้องกันการเลื่อนหน้าเมื่อเริ่มเขียน
                }

                ctx.lineWidth = 3;
                ctx.lineJoin = ctx.lineCap = 'round';

                // รองรับทั้ง desktop และมือถือ
                $(canvas).on('pointerdown touchstart', handlePointerDown);
                $(canvas).on('pointerup touchend', handlePointerUp);
                $(canvas).on('pointermove touchmove', handlePointerMove);

                // Clear button
                $('.clear-signature').on('click', function(event) {
                    event.preventDefault();
                    clearPad();
                });
            // ตัวจัดการ Signature( ลายเซ็น ) End
        }); 
    </script>
@endsection
