@extends('layout.dashboard_template')

@section('title')
    <title>Setting Module Access Rights</title>
@endsection

@section('content')
    {{-- Modal Start --}}
        {{-- Type Start --}}
            <div class="modal fade" id="type_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="type_title">เพิ่มข้อมูล Type</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="type_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="type_id_find_one" name="type_id_find_one">
                                <div class="mb-3">
                                    <label for="type_name" class="form-label">ชื่อ Type</label>
                                    <input type="text" class="form-control" id="type_name" name="type_name">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="type_submit"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Type End --}}
        {{-- Status Start --}}
            <div class="modal fade" id="status_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="status_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="status_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="status_id_find_one" name="status_id_find_one">
                                <div class="mb-3">
                                    <label for="status_name" class="form-label">ชื่อ Status</label>
                                    <input type="text" class="form-control" id="status_name" name="status_name">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="status_submit"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Status End --}}
        {{-- Module Start --}}
            <div class="modal fade" id="module_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="module_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="module_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="module_id_find_one" name="module_id_find_one">
                                <div class="mb-3">
                                    <label for="module_name" class="form-label">ชื่อ Module</label>
                                    <input type="text" class="form-control" id="module_name" name="module_name">
                                </div>
                                <div class="mb-3" id="hide_status_id_for_module">
                                    <label for="status_id_for_module" class="form-label">ชื่อ Status</label>
                                    <select class="form-select" aria-label="Default select example" name="status_id_for_module" id="status_id_for_module">
                                        <option selected value="0">--------------</option>
                                        @foreach($status_model AS $sm)
                                            <option value="{{ $sm->id }}">{{ $sm->status_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="module_submit"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Module End --}}
        {{-- Type Accessibility Start --}}
            <div class="modal fade" id="type_accessibility_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="type_accessibility_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="type_accessibility_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="type_accessibility_id_find_one" name="type_accessibility_id_find_one">
                                <div class="mb-3">
                                    <label for="type_accessibility_name" class="form-label">ชื่อ Type Accessibility</label>
                                    <input type="text" class="form-control" id="type_accessibility_name" name="type_accessibility_name">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="type_accessibility_submit"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Type Accessibility End --}}
        {{-- Accessibility Start --}}
            <div class="modal fade" id="accessibility_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-auto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="accessibility_title"></h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="accessibility_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="accessibility_id_find_one" name="accessibility_id_find_one">
                                <div class="mb-3">
                                    <label for="type_accessibility_id_for_accessibility" class="form-label">Type Accessibility</label>
                                    <select class="form-select" aria-label="Default select example" name="type_accessibility_id_for_accessibility" id="type_accessibility_id_for_accessibility">
                                        <option selected value="0">กรุณาเลือกรายการ Type Accessibility</option>
                                        @foreach($type_accessibility_model AS $tam)
                                            <option value="{{ $tam->id }}">{{ $tam->type_accessibility_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3" id="module_access">
                                    <label for="module_id_for_accessibility" class="form-label">Module</label>
                                    <select class="form-select" aria-label="Default select example" name="module_id_for_accessibility" id="module_id_for_accessibility"></select>
                                </div>
                                <div class="mb-3" id="sidebar_sub1_menu_access">
                                    <label for="sidebar_sub1_menu_id_for_accessibility" class="form-label">Sidebar Sub1 Menu</label>
                                    <select class="form-select" aria-label="Default select example" name="sidebar_sub1_menu_id_for_accessibility" id="sidebar_sub1_menu_id_for_accessibility"></select>
                                </div>
                                <div class="mb-3">
                                    <label for="type_id_for_accessibility" class="form-label">Type</label>
                                    <select class="form-select" aria-label="Default select example" name="type_id_for_accessibility" id="type_id_for_accessibility">
                                        <option selected value="0">กรุณาเลือกรายการ Type</option>
                                        @foreach($type_model AS $tm)
                                            <option value="{{ $tm->id }}">{{ $tm->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="accessibility_name" class="form-label">Accessibility Name</label>
                                    <select class="form-select" aria-label="Default select example" name="accessibility_name" id="accessibility_name"></select>
                                </div>
                                <div class="mb-3" id="hide_status_id_for_accessibility">
                                    <label for="status_id_for_accessibility" class="form-label">Status</label>
                                    <select class="form-select" aria-label="Default select example" name="status_id_for_accessibility" id="status_id_for_accessibility">
                                        <option selected value="0">กรุณาเลือกรายการ Status</option>
                                        @foreach($status_model AS $sm)
                                            <option value="{{ $sm->id }}">{{ $sm->status_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="accessiblity_submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Accessibility End --}}
    {{-- Modal End --}}
    {{-- Offcanvas Start --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="module_access_right_menu" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="d-flex justify-content-start align-items-center">
                    <ul class="text-white">
                        <li class="my-2 zoom-text"><a href="#type_setting_page" id="btn_type_setting" class="text-dark text-decoration-none p-2">ตั้งค่า Type</a></li>
                        <li class="my-2 zoom-text"><a href="#type_accessibility_setting_page" id="btn_type_accessibility_setting" class="text-dark text-decoration-none p-2">ตั้งค่า Type ของสิทธิ์การเข้าถึง</a></li>
                        <li class="my-2 zoom-text"><a href="#status_setting_page" id="btn_status_setting" class="text-dark text-decoration-none p-2">ตั้งค่าสถานะ</a></li>
                        <li class="my-2 zoom-text"><a href="#module_setting_page" id="btn_module_setting" class="text-dark text-decoration-none p-2">ตั้งค่า Module</a></li>
                        <li class="my-2 zoom-text"><a href="#accessibility_setting_page" id="btn_accessibility_setting" class="text-dark text-decoration-none p-2">ตั้งค่าสิทธิ์การเข้าถึง</a></li>
                    </ul>
                </div>
            </div>
        </div>
    {{-- Offcanvas End --}}
    <main class="main-content">
        <div class="">
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="my-1 d-flex justify-content-between align-content-center">
                    <h1>กำหนดสิทธิ์การเข้าถึง</h1>
                    <div class="p-2">
                        <button class="btn btn-outline-primary ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#module_access_right_menu" aria-controls="offcanvasRight"><i class="bi bi-list"></i></button>
                    </div>
                </div>
            </div>
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400" id="module-access-rights-page">
                {{-- Type Page Start --}}
                    <div class="my-1" id="type_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่า Type &nbsp;<i class="bi bi-sliders"></i></h3>
                            <button type="button" class="btn btn-success zoom-card type_modal_add" id="type_modal_add" data-bs-toggle="modal" data-bs-target="#type_modal">เพิ่ม Type</button>
                        </div>
                        <hr>
                        <div class="" id="type_show_data_all"></div>
                    </div>
                {{-- Type Page End --}}
                {{-- Type Accessibility Page Start --}}
                    <div class="my-1" id="type_accessibility_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่า Type ของสิทธิ์การเข้าถึง &nbsp;<i class="bi bi-sliders"></i></h3>
                            <button type="button" class="btn btn-success zoom-card type_accessibility_modal_add" id="type_accessibility_modal_add" data-bs-toggle="modal" data-bs-target="#type_accessibility_modal">เพิ่ม Type ของสิทธิ์การเข้าถึง</button>
                        </div>
                        <hr>
                        <div class="" id="type_accessibility_show_data_all"></div>
                    </div>
                {{-- Type Accessibility Page End --}}
                {{-- <hr> --}}
                {{-- Status Page Start --}}
                    <div class="my-1" id="status_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่าสถานะ &nbsp;<i class="bi bi-sliders"></i></h3>
                            <button type="button" class="btn btn-success zoom-card status_modal_add" id="status_modal_add" data-bs-toggle="modal" data-bs-target="#status_modal">เพิ่มสถานะ</button>
                        </div>
                        <hr>
                        <div class="" id="status_show_data_all"></div>
                    </div>
                {{-- Status Page End --}}
                {{-- <hr> --}}
                {{-- Module Page Start --}}
                    <div class="my-1" id="module_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่า Module &nbsp;<i class="bi bi-sliders"></i></h3>
                            <button type="button" class="btn btn-success zoom-card module_modal_add" id="module_modal_add" data-bs-toggle="modal" data-bs-target="#module_modal">เพิ่ม Module</button>
                        </div>
                        <hr>
                        <div class="" id="module_show_data_all"></div>
                    </div>
                {{-- Module Page End --}}
                {{-- <hr> --}}
                {{-- Accessibility Page Start --}}
                    <div class="my-1" id="accessibility_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่าสิทธิ์การเข้าถึง &nbsp;<i class="bi bi-sliders"></i></h3>
                            <button type="button" class="btn btn-success zoom-card accessibility_modal_add" id="accessibility_modal_add" data-bs-toggle="modal" data-bs-target="#accessibility_modal">เพิ่มสิทธิ์การเข้าถึง</button>
                        </div>
                        <hr>
                        <div class="" id="accessibility_show_data_all"></div>
                    </div>
                {{-- Accessibility Page End --}}
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#accessibility_modal').on('shown.bs.modal', function () {
                $('#type_id_for_accessibility').select2({
                    placeholder: 'เลือกรายการ Type',  
                    allowClear: true,
                    dropdownParent: $('#accessibility_modal') // กำหนดให้ dropdown ของ select2 อยู่ภายใน modal
                });

                $('#accessibility_name').select2({
                    // placeholder: 'เลือก Version ที่ต้องการใส่ Detail',  
                    allowClear: true,
                    dropdownParent: $('#accessibility_modal') // กำหนดให้ dropdown ของ select2 อยู่ภายใน modal
                });
            });

            // Default Menu Start
                $('#accessibility_setting_page').show();
                $('#type_setting_page').hide();
                $('#type_accessibility_setting_page').hide();
                $('#status_setting_page').hide();
                $('#module_setting_page').hide();
            // Default Menu End

            // onClick Change Menu Start
                $('#btn_type_setting').on('click', function() {
                    $('#type_setting_page').show();
                    $('#accessibility_setting_page').hide();
                    $('#status_setting_page').hide();
                    $('#module_setting_page').hide();
                    $('#type_accessibility_setting_page').hide();
                    $('#module_access_right_menu').offcanvas('hide');
                });

                $('#btn_type_accessibility_setting').on('click', function() {
                    $('#type_accessibility_setting_page').show();
                    $('#type_setting_page').hide();
                    $('#accessibility_setting_page').hide();
                    $('#status_setting_page').hide();
                    $('#module_setting_page').hide();
                    $('#module_access_right_menu').offcanvas('hide');
                });

                $('#btn_status_setting').on('click', function() {
                    $('#type_setting_page').hide();
                    $('#accessibility_setting_page').hide();
                    $('#status_setting_page').show();
                    $('#module_setting_page').hide();
                    $('#type_accessibility_setting_page').hide();
                    $('#module_access_right_menu').offcanvas('hide');
                });

                $('#btn_module_setting').on('click', function() {
                    $('#type_setting_page').hide();
                    $('#accessibility_setting_page').hide();
                    $('#status_setting_page').hide();
                    $('#module_setting_page').show();
                    $('#type_accessibility_setting_page').hide();
                    $('#module_access_right_menu').offcanvas('hide');
                });

                $('#btn_accessibility_setting').on('click', function() {
                    $('#type_setting_page').hide();
                    $('#accessibility_setting_page').show();
                    $('#status_setting_page').hide();
                    $('#module_setting_page').hide();
                    $('#type_accessibility_setting_page').hide();
                    $('#module_access_right_menu').offcanvas('hide');
                });
            // onClick Change Menu End

            // Change Mode add || update Start
                // Type Start
                    $('.type_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#type_title').text('เพิ่มข้อมูล');
                        $('#type_submit').text('Add Data');
                        $("#type_form")[0].reset();
                    });

                    $(document).on('click', '.type_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#type_title').text('แก้ไขข้อมูล');
                        $('#type_submit').text('Update Data');
                    });
                // Type End
                // Type Accessibility Start
                    $('.type_accessibility_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#type_accessibility_title').text('เพิ่มข้อมูล');
                        $('#type_accessibility_submit').text('Add Data');
                        $("#type_accessibility_form")[0].reset();
                    });

                    $(document).on('click', '.type_accessibility_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#type_accessibility_title').text('แก้ไขข้อมูล');
                        $('#type_accessibility_submit').text('Update Data');
                    });
                // Type Accessibility End
                // Status Start
                    $('.status_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#status_title').text('เพิ่มข้อมูล');
                        $('#status_submit').text('Add Data');
                        $("#status_form")[0].reset();
                    });

                    $(document).on('click', '.status_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#status_title').text('แก้ไขข้อมูล');
                        $('#status_submit').text('Update Data');
                    });
                // Status End
                // Module Start
                    $('.module_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#module_title').text('เพิ่มข้อมูล');
                        $('#module_submit').text('Add Data');
                        $("#module_form")[0].reset();
                        $("#hide_status_id_for_module").show();
                    });

                    $(document).on('click', '.module_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#module_title').text('แก้ไขข้อมูล');
                        $('#module_submit').text('Update Data');
                        $("#hide_status_id_for_module").hide();
                    });
                // Module End
                // Accessibility Start
                    $('.accessibility_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#accessibility_title').text('เพิ่มข้อมูล');
                        $('#accessibility_submit').text('Add Data');
                        $("#accessibility_form")[0].reset();
                        $("#hide_status_id_for_accessibility").show();
                    });

                    $(document).on('click', '.accessibility_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#accessibility_title').text('แก้ไขข้อมูล');
                        $('#accessibility_submit').text('Update Data');
                        $("#hide_status_id_for_accessibility").hide();
                    });
                // Accessibility End
            // Change Mode add || update End

            // Reset Form Start
                $('.btn-close').on('click', function() {
                    $("#type_form")[0].reset();
                    $("#accessibility_form")[0].reset();
                    $('#sidebar_sub1_menu_access').hide()
                    $('#module_access').hide()
                    $('#sidebar_sub1_menu_id_for_accessibility').empty();
                    $('#module_id_for_accessibility').empty();
                    $('#accessibility_name').empty();
                    $('#accessibility_name').append('<option selected value="0">**** กรุณาเลือก Type ก่อน ****</option>');
                });
            // Reset Form End

            // Fetch All Data Type Start
                fetchAllDataType();

                function fetchAllDataType() {

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
                        url: '{{ route('fetchAllDataType') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#type_show_data_all").html(response);
                            $("#type_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        }
                    });
                }
            // Fetch All Data Type End

            // Insert && Update Data Type Start
                $("#type_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataType') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataType();
                                        $("#type_form")[0].reset();
                                        $("#type_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataType') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataType();
                                        $("#type_form")[0].reset();
                                        $("#type_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Type End

            // Find One Data Type Start
                $(document).on('click', '.type_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataType') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#type_name").val(response.type_name);
                            $("#type_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Type End

            // Delete Data Type Start
                $(document).on('click', '.type_delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    console.log(id);
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
                                url: '{{ route('deleteDataType') }}',
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
                                            title: response.title,
                                            text: response.message,
                                            icon: response.icon
                                        }).then((result) => {
                                            fetchAllDataType();
                                        });
                                    }
                                    console.log(response);
                                }
                            });
                        }
                    })
                });
            // Delete Data Type End

            // Fetch All Data Type Accessibility Start
                fetchAllDataTypeAccessibility();

                function fetchAllDataTypeAccessibility() {

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
                        url: '{{ route('fetchAllDataTypeAccessibility') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#type_accessibility_show_data_all").html(response);
                            $("#type_accessibility_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        }
                    });
                }
            // Fetch All Data Type Accessibility End

            // Insert && Update Data Type Accessibility Start
                $("#type_accessibility_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataTypeAccessibility') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataTypeAccessibility();
                                        $("#type_accessibility_form")[0].reset();
                                        $("#type_accessibility_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataTypeAccessibility') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataTypeAccessibility();
                                        $("#type_accessibility_form")[0].reset();
                                        $("#type_accessibility_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Type Accessibility End

            // Find One Data Type Accessibility Start
                $(document).on('click', '.type_accessibility_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataTypeAccessibility') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#type_accessibility_name").val(response.type_accessibility_name);
                            $("#type_accessibility_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Type Accessibility End

            // Delete Data Type Accessibility Start
                $(document).on('click', '.type_accessibility_delete', function(e) {
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
                                url: '{{ route('deleteDataTypeAccessibility') }}',
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
                                            title: response.title,
                                            text: response.message,
                                            icon: response.icon
                                        }).then((result) => {
                                            fetchAllDataTypeAccessibility();
                                        });
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Type Accessibility End

            // Fetch All Data Status Start
                fetchAllDataStatus();

                function fetchAllDataStatus() {

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
                        url: '{{ route('fetchAllDataStatus') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#status_show_data_all").html(response);
                            $("#status_table").DataTable({
                                // order: [0, 'DESC']
                            });
                        }
                    });
                }
            // Fetch All Data Status End

            // Insert && Update Data Status Start
                $("#status_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataStatus') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataStatus();
                                        $("#status_form")[0].reset();
                                        $("#status_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataStatus') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataStatus();
                                        $("#status_form")[0].reset();
                                        $("#status_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Status End

            // Find One Data Status Start
                $(document).on('click', '.status_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataStatus') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#status_name").val(response.status_name);
                            $("#status_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Status End

            // Delete Data Status Start
                $(document).on('click', '.status_delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    console.log(id);
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
                                url: '{{ route('deleteDataStatus') }}',
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
                                            title: response.title,
                                            text: response.message,
                                            icon: response.icon
                                        }).then((result) => {
                                            fetchAllDataStatus();
                                        });
                                    }
                                    console.log(response);
                                }
                            });
                        }
                    })
                });
            // Delete Data Status End

            // Fetch All Data Module Start
                fetchAllDataModule();

                function fetchAllDataModule() {

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
                        url: '{{ route('fetchAllDataModule') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#module_show_data_all").html(response);
                            $("#module_table").DataTable({
                                // order: [0, 'DESC']
                            });
                        }
                    });
                }
            // Fetch All Data Module End

            // Insert && Update Data Module Start
                $("#module_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataModule') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataModule();
                                        $("#module_form")[0].reset();
                                        $("#module_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataModule') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataModule();
                                        $("#module_form")[0].reset();
                                        $("#module_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Module End

            // Find One Data Module Start
                $(document).on('click', '.module_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataModule') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#module_name").val(response.module_name);
                            $("#module_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Module End

            // Delete Data Module Start
                $(document).on('click', '.module_delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    console.log(id);
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
                                url: '{{ route('deleteDataModule') }}',
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
                                            title: response.title,
                                            text: response.message,
                                            icon: response.icon
                                        }).then((result) => {
                                            fetchAllDataModule();
                                        });
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Module End

            // Change Status_id In Module Start
                $(document).ready(function() {
                    $('.status_checked_in_module').each(function() {
                        var status = $(this).val();
                        if (status == 1) {
                            $(this).prop('checked', true);
                        } else if (status == 2) {
                            $(this).prop('checked', false);
                        }
                    });

                    $(document).on('change', '.status_checked_in_module', function(e) {
                        e.preventDefault();

                        const status_id_for_module = $(this).is(':checked') ? 1 : 2;
                        const form = $(this).closest('form'); // Get the closest form
                        const id = form.find('#module_id').val(); // Get the ID from the hidden input

                        // Create a data object to hold the status_id and id
                        let data = {
                            status_id_for_module: status_id_for_module,
                            id: id,
                            _token: form.find('input[name="_token"]').val()
                        };

                        $.ajax({
                            url: '{{ route('ChangeStatusIdInModuleRealtime') }}',
                            method: 'POST',
                            data: data, // Send the data object containing the status_id and id
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataModule();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    });
                });
            // Change Status_id In Module End

            // Find Module || Sidebar Sub1 Menu Start
                $('#module_access').hide()
                $('#sidebar_sub1_menu_access').hide()
                $('#type_accessibility_id_for_accessibility').change(function() {
                    var type_accessibility_id_for_accessibility = $(this).val();

                    if(type_accessibility_id_for_accessibility == 1) {
                        $('#module_access').show()
                        $('#sidebar_sub1_menu_access').hide()
                        $('#module_id_for_accessibility').append('<option selected value="0">**** กรุณาเลือกรายการ Module ****</option>');
                        $.ajax({
                            url: '{{ route('findSelectForModule') }}',
                            method: 'GET',
                            data: {
                                type_accessibility_id_for_accessibility: type_accessibility_id_for_accessibility,
                            },
                            success: function(response) {
                                $('#module_id_for_accessibility').empty();
                                $('#module_id_for_accessibility').append('<option selected value="0">**** กรุณาเลือก Menu ****</option>');
                                $.each(response, function(key, value) {
                                    if(value.status_id != 2) {
                                        $('#module_id_for_accessibility').append('<option value="'+ value.id +'">'+ value.module_name +'</option>');
                                    }
                                });
                            }
                        })
                    } else if(type_accessibility_id_for_accessibility == 2) {
                        $('#module_access').hide()
                        $('#sidebar_sub1_menu_access').show()
                        $('#sidebar_sub1_menu_id_for_accessibility').append('<option selected value="0">**** กรุณาเลือกรายการ Type Accessibility ****</option>');
                        $.ajax({
                            url: '{{ route('findSelectForSidebarSub1Menu') }}',
                            method: 'GET',
                            data: {
                                type_accessibility_id_for_accessibility: type_accessibility_id_for_accessibility,
                            },
                            success: function(response) {
                                $('#sidebar_sub1_menu_id_for_accessibility').empty();
                                $('#sidebar_sub1_menu_id_for_accessibility').append('<option selected value="0">**** กรุณาเลือก Menu ****</option>');
                                $.each(response, function(key, value) {
                                    if(value.status_id != 2) {
                                        $('#sidebar_sub1_menu_id_for_accessibility').append('<option value="'+ value.id +'">'+ value.sidebar_sub1_menu_name +'</option>');
                                    }
                                });
                            }
                        })
                    } else {
                        $('#sidebar_sub1_menu_access').hide()
                        $('#module_access').hide()
                        alert('กรุณาเลือก Type Accessibility ก่อนครับ');
                    }
                });
            // Find Module || Sidebar Sub1 Menu End

            // Find User || Group Accessibility Start
                $('#accessibility_name').append('<option selected value="0">**** กรุณาเลือก Type ก่อน ****</option>');
                $('#type_id_for_accessibility').change(function(){
                    var type_id_for_accessibility = $(this).val();

                    if (type_id_for_accessibility != 0) {
                        $.ajax({
                            url: '{{ route('findSelectForUserOrGroup') }}', // Route to your controller
                            method: 'GET',
                            data: { type_id: type_id_for_accessibility },
                            success: function(response) {
                                if(response != '') {
                                    if(response.type === '1') {
                                        $('#accessibility_name').empty();
                                        $('#accessibility_name').append('<option selected value="0">**** กรุณาเลือก Menu ****</option>');
                                        $.each(response.data, function(key, value) {
                                            $('#accessibility_name').append('<option value="'+ value.groupname +'">'+ value.groupname +'</option>');
                                        });
                                    } else if(response.type === '2') {
                                        $('#accessibility_name').empty();
                                        $('#accessibility_name').append('<option selected value="0">**** กรุณาเลือก Menu ****</option>');
                                        $.each(response.data, function(key, value) {
                                            $('#accessibility_name').append('<option value="'+ value.name +'">'+ value.name +'</option>');
                                        });
                                    }
                                } else {
                                    $('#accessibility_name').empty();
                                    $('#accessibility_name').append('<option selected value="0">**** ไม่มีข้อมูลบน Database ****</option>');
                                }
                            }
                        });
                    } else {
                        $('#accessibility_name').empty();
                        $('#accessibility_name').append('<option selected value="0">**** กรุณาเลือก Type ก่อน ****</option>');
                    }
                });
            // Find User || Group Accessibility End

            // Fetch All Data Accessibility Start
                fetchAllDataAccessibility();

                function fetchAllDataAccessibility() {

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
                        url: '{{ route('fetchAllDataAccessibility') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#accessibility_show_data_all").html(response);
                            $("#accessibility_table").DataTable({
                                // order: [0, 'DESC']
                            });
                        }
                    });
                }
            // Fetch All Data Accessibility End

            // Insert && Update Data Accessibility Start
                $("#accessibility_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataAccessibility') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    $("#accessibility_form")[0].reset();
                                    $("#accessibility_modal").modal('hide');
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataAccessibility();
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataAccessibility') }}',
                            method: 'post',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    $("#accessibility_form")[0].reset();
                                    $("#accessibility_modal").modal('hide');
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataAccessibility();
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Accessibility End

            // Find Three Data Accessibility Start
                $(document).on('click', '.accessibility_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataAccessibility') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#accessibility_name').empty();
                            $('#accessibility_name').append('<option value="'+ response.accessibility_name +'">'+ response.accessibility_name +'</option>');
                            $("#type_id_for_accessibility").val(response.type_id);
                            $("#accessibility_id_find_one").val(response.id);
                            const checkTypeAccessibility = $("#type_accessibility_id_for_accessibility").val(response.type_accessibility_id);
                            if(checkTypeAccessibility == 1) {
                                $('#sidebar_sub1_menu_acccess').hide();
                                $('#module_acccess').show();
                                $("#module_id_for_accessibility").val(response.module_id);
                            } else if(checkTypeAccessibility == 2) {
                                $('#module_acccess').hide();
                                $('#sidebar_sub1_menu_acccess').show();
                                $("#sidebar_sub1_menu_id_for_accessibility").val(response.sidebar_sub1_menu_id);
                            }
                        }
                    });
                });
            // Find Three Data Accessibility End

            // Delete Data Accessibility Start
                $(document).on('click', '.accessibility_delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    console.log(id);
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
                                url: '{{ route('deleteDataAccessibility') }}',
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
                                            title: response.title,
                                            text: response.message,
                                            icon: response.icon
                                        }).then((result) => {
                                            fetchAllDataAccessibility();
                                        });
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Accessibility End

            // Change Status_id In Accessibility Start
                $(document).ready(function() {
                    $('.status_checked_in_accessibility').each(function() {
                        var status = $(this).val();
                        if (status == 1) {
                            $(this).prop('checked', true);
                        } else if (status == 2) {
                            $(this).prop('checked', false);
                        }
                    });

                    $(document).on('change', '.status_checked_in_accessibility', function(e) {
                        e.preventDefault();

                        const status_id_for_accessibility = $(this).is(':checked') ? 1 : 2;
                        const form = $(this).closest('form'); // Get the closest form
                        const id = form.find('#accessibility_id').val(); // Get the ID from the hidden input

                        // Create a data object to hold the status_id and id
                        let data = {
                            status_id_for_accessibility: status_id_for_accessibility,
                            id: id,
                            _token: form.find('input[name="_token"]').val()
                        };

                        $.ajax({
                            url: '{{ route('ChangeStatusIdInAccessibilityRealtime') }}',
                            method: 'POST',
                            data: data, // Send the data object containing the status_id and id
                            success: function(response) {
                                if(response.status === 400) {
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                } else {
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataAccessibility();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    });
                });
            // Change Status_id In Accessibility End
        });
    </script>
@endsection
