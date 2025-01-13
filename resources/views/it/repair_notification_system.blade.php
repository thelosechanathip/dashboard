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
                                <select class="form-select" aria-label="Default select example" name="working_type_id" id="working_type_id" required>
                                    <option selected value="0">--------------</option>
                                    @foreach($working_type_model AS $wtm)
                                        <option value="{{ $wtm->id }}">{{ $wtm->working_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name_of_informant" class="form-label">ชื่อผู้แจ้งซ่อม</label>
                                <select class="form-select" aria-label="Default select example" name="name_of_informant" id="name_of_informant" required>
                                    <option selected value="0">--------------</option>
                                    @foreach($opduser_model AS $oum)
                                        @if($oum->name != '' && $oum->name != NULL)
                                            <option value="{{ $oum->name }}">{{ $oum->name }}</option>
                                        @else
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="detail" class="form-label">รายละเอียดการซ่อม</label>
                                <textarea class="form-control" placeholder="กรอกรายละเอียดการซ่อม" id="detail" name="detail" required></textarea>
                            </div>
                            <div class="mb-3 d-flex flex-column" id="hide_signature">
                                <label for="signature" class="form-label">ลายเซ็นผู้รับงาน</label>
                                <canvas height="100" width="300" class="signature-pad" id="signature" name="signature" style="border: 2px solid #000; border-radius: 4px;"></canvas>
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
    {{-- Repair Notification System Detail Modal Start --}}
        <div class="modal fade" id="repair_notification_system_detail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repair_notification_system_detail_title"></h5>
                        <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>ประเภทการของงาน : <span id="working_type_id_detail"></span></p>
                        <p>ชื่อผู้แจ้ง : <span id="name_of_informant_detail"></span></p>
                        <p>รายละเอียด : <span id="detail_detail"></span></p>
                        <p>ชื่อผู้ซ่อม : <span id="repair_staff_detail"></span></p>
                        <p>ลายเซ็นผู้แจ้งซ่อม : </p>
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="" alt="" id="signature_image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- Repair Notification System Detail Modal End --}}
    <main class="main-content mb-5">
        {{-- Title Start --}}
            <div class="card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <div class="d-flex">
                        <button class="btn btn-outline-danger zoom-card me-3" onclick="history.back()">
                            <i class="bi bi-arrow-left-circle-fill"></i>
                            Back
                        </button>
                    </div>
                    <div class="d-flex" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                        <h1 class="h2">ระบบแจ้งซ่อม</h1>
                    </div>
                </div>
            </div>
        {{-- Title End --}}
        @if(isset($data['error']))
            <div class="alert alert-danger" role="alert">
                {{ $data['error'] }}
            </div>
        @endif
        
        <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
            <div class="row gy-4" id="all_repair_notification_system">
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
        </div>
        <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
            <div class="my-1" id="repair_notification_system_setting_page">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="" id="text_title">
                        <h2 class="text_title">ระบบแจ้งซ่อม</h2>
                    </div>
                    <button type="button" class="btn btn-success zoom-card repair_notification_system_modal_add mt-2 mt-md-0 " id="repair_notification_system_modal_add" data-bs-toggle="modal" data-bs-target="#repair_notification_system_modal">เพิ่มรายการซ่อม</button>
                </div>
                <hr>
                <div class="" id="repair_notification_system_show_data_all"></div>
            </div>
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

            // Change Mode add || update Start
                // Repair Notification System Start
                    $('.repair_notification_system_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#repair_notification_system_title').text('เพิ่มข้อมูลการซ่อม');
                        $('#repair_notification_system_submit').text('ยืนยันการบันทึก');
                        $("#repair_notification_system_form")[0].reset();
                        $("#hide_signature").addClass("d-flex flex-column");
                        $("#hide_signature").show();
                    });

                    $(document).on('click', '.repair_notification_system_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#repair_notification_system_title').text('แก้ไขข้อมูลการซ่อม');
                        $('#repair_notification_system_submit').text('ยืนยันการแก้ไข');
                        $("#hide_signature").removeClass("d-flex flex-column");
                        $("#hide_signature").hide();
                    });

                    $(document).on('click', '.repair_notification_system_modal_detail', function() {
                        $('#repair_notification_system_detail_title').text('รายละเอียดข้อมูลทั้งหมด');
                    });
                // Repair Notification System End
            // Change Mode add || update End

            // Reset && Clear Form Start
                $('.btn-close').on('click', function() {
                    clearAll()
                });
                $('#repair_notification_system_modal').on('hidden.bs.modal', function () {
                    clearAll();
                });
                function clearAll() {
                    $('#repair_notification_system_form')[0].reset();
                    clearPad();
                }
            // Reset && Clear Form End

            // Fetch All Data Working Type Start
                fetchAllDataRepairNotificationSystem();

                function fetchAllDataRepairNotificationSystem() {

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
                        url: '{{ route('fetchAllDataRepairNotificationSystem') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#repair_notification_system_show_data_all").html(response);
                            $("#repair_notification_system_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        }
                    });
                }
            // Fetch All Data Working Type End

            // Insert && Update Data Repair Notification System Start
                $("#repair_notification_system_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    e.preventDefault();
                    
                    const formData = new FormData(this); // Collect form data
                    const imageURL = canvas.toDataURL(); // Get signature

                    const isCanvasBlank = function(canvas) {
                        const blankCanvas = document.createElement('canvas');
                        blankCanvas.width = canvas.width;
                        blankCanvas.height = canvas.height;
                        return canvas.toDataURL() === blankCanvas.toDataURL(); // Compare the signature canvas with a blank one
                    };

                    const selectedWorkingTypeId = formData.get('working_type_id');
                    const selectedNameOfInformant = formData.get('name_of_informant');
                    const selectedDetail = formData.get('detail');

                    // console.log(selectedWorkingTypeId);
                    
                    if (mode === 'add') {

                        if (isCanvasBlank(canvas)) {
                            alert('กรุณาเซ็นลายเซ็นก่อนบันทึกด้วยครับ!');
                            return;
                        } 
                        if(selectedWorkingTypeId === '0') {
                            alert('กรุณาเลือกประเภทของการซ่อม!');
                            return;
                        }
                        if(selectedNameOfInformant === '0') {
                            alert('กรุณาเลือกชื่อผู้แจ้ง!');
                            return;
                        }
                        if(selectedDetail === '') {
                            alert('กรุณากรอกรายละเอียดการซ่อม!');
                            return;
                        }
                        
                        // Add signature to the FormData object
                        formData.append('signature', imageURL); 
                        $.ajax({
                            url: '{{ route('insertDataRepairNotificationSystem') }}',
                            method: 'post',
                            data: formData, // Send the formData object
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                // Handle response as needed
                                if(response.status === 400) {
                                    swal.fire(response.title, response.message, response.icon);
                                } else {
                                    swal.fire(response.title, response.message, response.icon);
                                    fetchAllDataRepairNotificationSystem();
                                    clearAll()
                                    $("#repair_notification_system_modal").modal('hide');
                                }
                            }
                        });
                    } else if (mode === 'update') {
                        $.ajax({
                            url: '{{ route('updateDataRepairNotificationSystem') }}',
                            method: 'post',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(response.title, response.message, response.icon);
                                } else {
                                    swal.fire(response.title, response.message, response.icon);
                                    fetchAllDataRepairNotificationSystem();
                                    // clearAll();
                                    $("#repair_notification_system_modal").modal('hide');
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Repair Notification System End

            // Find One Data Repair Notification System Start
                $(document).on('click', '.repair_notification_system_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataRepairNotificationSystem') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#working_type_id").val(response.working_type_id);
                            $("#name_of_informant").val(response.name_of_informant);
                            $("#detail").val(response.detail);
                            $("#repair_notification_system_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Repair Notification System End

            // Detail Data Repair Notification System Start
                $(document).on('click', '.repair_notification_system_modal_detail', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('detailDataRepairNotificationSystem') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // กรอกข้อมูลลงในฟิลด์ต่าง ๆ
                            $("#working_type_id_detail").text(response.working_type_id);
                            // console.log(response.working_type_id);
                            $("#name_of_informant_detail").text(response.name_of_informant);
                            $("#detail_detail").text(response.detail);
                            $("#repair_staff_detail").text(response.repair_staff);
                            $("#repair_notification_system_id_find_one_detail").text(response.id);
                            $("#signature_image").attr('src', response.signature).show();
                        }
                    });
                });
            // Detail Data Repair Notification System End

            // Delete Data Repair Notification System Start
                $(document).on('click', '.repair_notification_system_delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    // console.log(id);
                    let csrf = '{{ csrf_token() }}';
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('deleteDataRepairNotificationSystem') }}',
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
                                        swal.fire(
                                            response.title,
                                            response.message,
                                            response.icon
                                        )
                                        fetchAllDataRepairNotificationSystem();
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Repair Notification System End

            $('#repair_notification_system_modal').on('shown.bs.modal', function () {
                $('#name_of_informant').select2({
                    placeholder: 'ค้นหาชื่อผู้แจ้งซ่อม',  
                    allowClear: true,
                    dropdownParent: $('#repair_notification_system_modal') // กำหนดให้ dropdown ของ select2 อยู่ภายใน modal
                });

                $('#working_type_id').select2({
                    placeholder: 'ค้นหาประเภทการซ่อม',  
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
