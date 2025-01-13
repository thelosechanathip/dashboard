@extends('layout.dashboard_template')

@section('title')
    <title>ตั้งค่าอื่นๆ</title>
@endsection

@section('content')
    {{-- Modal Start --}}
        {{-- Version Start --}}
            <div class="modal fade" id="version_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="version_title">เพิ่มข้อมูล Version</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="version_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="version_id_find_one" name="version_id_find_one">
                                <div class="mb-3">
                                    <label for="version_name" class="form-label">เพิ่ม Version</label>
                                    <input type="text" class="form-control" id="version_name" name="version_name">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="version_submit">ยืนยัน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Version End --}}

        {{-- Version Detail Start --}}
            <div class="modal fade" id="version_detail_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="version_detail_title">เพิ่มข้อมูลรายละเอียดของ Version</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="version_detail_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="version_detail_id_find_one" name="version_detail_id_find_one">
                                <div class="mb-3">
                                    <label for="version_id" class="form-label">Version</label>
                                    <select class="form-select" aria-label="Default select example" name="version_id" id="version_id_for_detail" required>
                                        <option selected value="0">--------------</option>
                                        @foreach($version_model AS $vm)
                                            <option value="{{ $vm->id }}">{{ $vm->version_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="version_detail_name" class="form-label">รายการที่ Update</label>
                                    <input type="text" class="form-control" id="version_detail_name" name="version_detail_name">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="version_detail_submit">ยืนยัน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Version Detail End --}}

        {{-- Fiscal Year Start --}}
            <div class="modal fade" id="fiscal_year_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fiscal_year_title">เพิ่มข้อมูลปีงบประมาณ</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="fiscal_year_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="fiscal_year_id_find_one" name="fiscal_year_id_find_one">
                                <div class="mb-3">
                                    <label for="fiscal_year_name" class="form-label">เพิ่มปีงบประมาณ</label>
                                    <input type="text" class="form-control" id="fiscal_year_name" name="fiscal_year_name">
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary zoom-card" id="fiscal_year_submit">ยืนยัน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Fiscal Year End --}}
    {{-- Modal End --}}
    {{-- Offcanvas Start --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="announcement_and_version_menu" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="d-flex justify-content-start align-items-center">
                    <ul class="text-white">
                        <li class="my-2 zoom-text"><a href="#version_detail_setting_page" id="btn_version_detail_setting" class="text-dark text-decoration-none p-2">ตั้งค่ารายละเอียดของ Version</a></li>
                        <li class="my-2 zoom-text"><a href="#version_setting_page" id="btn_version_setting" class="text-dark text-decoration-none p-2">ตั้งค่า Version</a></li>
                        <li class="my-2 zoom-text"><a href="#fiscal_year_setting_page" id="btn_fiscal_year_setting" class="text-dark text-decoration-none p-2">ตั้งค่าปีงบประมาณ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    {{-- Offcanvas End --}}
    <main class="main-content">
        <div class="">
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="my-1 d-flex justify-content-between align-items-center">
                    <h1>ตั้งค่าอื่นๆ</h1>
                    <div class="p-2">
                        <button class="btn btn-outline-primary ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#announcement_and_version_menu" aria-controls="offcanvasRight"><i class="bi bi-list"></i></button>
                    </div>
                </div>
            </div>
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400" id="sidebar-menu-page">
                {{-- Version Page Start --}}
                    <div class="my-1" id="version_setting_page">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="fw-bold">ตั้งค่า Version &nbsp;
                                <i class="bi bi-sliders"></i>&nbsp;
                            </h3>
                            <button type="button" class="btn btn-success zoom-card version_modal_add mt-2 mt-md-0" id="version_modal_add" data-bs-toggle="modal" data-bs-target="#version_modal">Add Version</button>
                        </div>
                        <hr>
                        <div class="" id="version_show_data_all"></div>
                    </div>
                {{-- Version Page End --}}
                
                {{-- Version Detail Page Start --}}
                    <div class="my-1" id="version_detail_setting_page">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="fw-bold">ตั้งค่ารายละเอียดของ Version &nbsp;
                                <i class="bi bi-sliders"></i>&nbsp;
                            </h3>
                            <button type="button" class="btn btn-success zoom-card version_detail_modal_add mt-2 mt-md-0" id="version_detail_modal_add" data-bs-toggle="modal" data-bs-target="#version_detail_modal">Add Version Detail</button>
                        </div>
                        <hr>
                        <div class="" id="version_detail_show_data_all"></div>
                    </div>
                {{-- Version Detail Page End --}}

                {{-- Version Detail Page Start --}}
                    <div class="my-1" id="fiscal_year_setting_page">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="fw-bold">ตั้งค่าปีงบประมาณ &nbsp;
                                <i class="bi bi-sliders"></i>&nbsp;
                            </h3>
                            <button type="button" class="btn btn-success zoom-card fiscal_year_modal_add mt-2 mt-md-0" id="fiscal_year_modal_add" data-bs-toggle="modal" data-bs-target="#fiscal_year_modal">เพิ่มปีงบประมาณ</button>
                        </div>
                        <hr>
                        <div class="" id="fiscal_year_show_data_all"></div>
                    </div>
                {{-- Version Detail Page End --}}
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Select 2 Start
                // Version Detail Start
                    $('#version_detail_modal').on('shown.bs.modal', function () {
                        $('#version_id_for_detail').select2({
                            placeholder: 'เลือก Version ที่ต้องการใส่ Detail',  
                            allowClear: true,
                            dropdownParent: $('#version_detail_modal') // กำหนดให้ dropdown ของ select2 อยู่ภายใน modal
                        });
                    });
                // Version Detail End
            // Select 2 End

            // Default Menu Start
                $('#version_setting_page').hide();
                $('#version_detail_setting_page').show();
                $('#fiscal_year_setting_page').hide();
            // Default Menu End

            // onClick Change Menu Start
                fetchAllDataVersionDetail();
                fetchAllDataVersion();
                fetchAllDataFiscalYear();

                $('#btn_version_setting').on('click', function() {
                    $('#version_setting_page').show();
                    $('#version_detail_setting_page').hide();
                    $('#fiscal_year_setting_page').hide();
                    $('#announcement_and_version_menu').offcanvas('hide');
                });

                $('#btn_version_detail_setting').on('click', function() {
                    $('#version_detail_setting_page').show();
                    $('#version_setting_page').hide();
                    $('#fiscal_year_setting_page').hide();
                    $('#announcement_and_version_menu').offcanvas('hide');
                });

                $('#btn_fiscal_year_setting').on('click', function() {
                    $('#version_detail_setting_page').hide();
                    $('#version_setting_page').hide();
                    $('#fiscal_year_setting_page').show();
                    $('#announcement_and_version_menu').offcanvas('hide');
                });
            // onClick Change Menu End

            // Change Mode add || update Start
                // Version Start
                    $('.version_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#version_title').text('เพิ่มข้อมูล');
                        $('#version_submit').text('Add Data');
                        $("#version_form")[0].reset();
                    });

                    $(document).on('click', '.version_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#version_title').text('แก้ไขข้อมูล');
                        $('#version_submit').text('Update Data');
                    });
                // Version End
                // Version Detail Start
                    $('.version_detail_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#version_detail_title').text('เพิ่มข้อมูล');
                        $('#version_detail_submit').text('Add Data');
                        $("#version_detail_form")[0].reset();
                    });

                    $(document).on('click', '.version_detail_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#version_detail_title').text('แก้ไขข้อมูล');
                        $('#version_detail_submit').text('Update Data');
                    });
                // Version Detail End
                // Fiscal Year Start
                $('.fiscal_year_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#fiscal_year_title').text('เพิ่มข้อมูล');
                        $('#fiscal_year_submit').text('Add Data');
                        $("#fiscal_year_form")[0].reset();
                    });

                    $(document).on('click', '.fiscal_year_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#fiscal_year_title').text('แก้ไขข้อมูล');
                        $('#fiscal_year_submit').text('Update Data');
                    });
                // Fiscal Year End
            // Change Mode add || update End

            // Reset Form Start
                $('.btn-close').on('click', function() {
                    $("#version_form")[0].reset();
                    $("#version_detail_form")[0].reset();
                    $("#fiscal_year_form")[0].reset();
                });
            // Reset Form End

            // Fetch All Data Version Start
                function fetchAllDataVersion() {

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
                        url: '{{ route('fetchAllDataVersion') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#version_show_data_all").html(response);
                            $("#version_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        }
                    });
                }
            // Fetch All Data Version End

            // Insert && Update Data Version Start
                $("#version_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataVersion') }}',
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
                                        fetchAllDataVersion();
                                        fetchAllDataVersionDetail();
                                        fetchAllDataFiscalYear();
                                        $("#version_form")[0].reset();
                                        $("#version_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataVersion') }}',
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
                                        fetchAllDataVersion();
                                        fetchAllDataVersionDetail();
                                        fetchAllDataFiscalYear();
                                        $("#version_form")[0].reset();
                                        $("#version_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Version End

            // Find One Data Version Start
                $(document).on('click', '.version_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataVersion') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#version_name").val(response.version_name);
                            $("#version_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Version End

            // Delete Data Version Start
                $(document).on('click', '.version_delete', function(e) {
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
                                url: '{{ route('deleteDataVersion') }}',
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
                                            fetchAllDataVersion();
                                            fetchAllDataVersionDetail();
                                            fetchAllDataFiscalYear();
                                        });
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Version End

            // Fetch All Data Version Detail Start
                function fetchAllDataVersionDetail() {

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
                        url: '{{ route('fetchAllDataVersionDetail') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#version_detail_show_data_all").html(response);
                            $("#version_detail_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        }
                    });
                }
            // Fetch All Data Version Detail End

            // Insert && Update Data Version Detail Start
                $("#version_detail_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        const selectedVersionId = fd.get('version_id');

                        if(selectedVersionId === '0') {
                            alert('กรุณาเลือก Version ก่อน!');
                            return;
                        }
                        $.ajax({
                            url: '{{ route('insertDataVersionDetail') }}',
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
                                        fetchAllDataVersionDetail();
                                        fetchAllDataVersion()
                                        fetchAllDataFiscalYear();
                                        $("#version_detail_form")[0].reset();
                                        $("#version_detail_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        const selectedVersionId = fd.get('version_id');

                        if(selectedVersionId === '0') {
                            alert('กรุณาเลือก Version ก่อน!');
                            return;
                        }

                        $.ajax({
                            url: '{{ route('updateDataVersionDetail') }}',
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
                                        fetchAllDataVersionDetail();
                                        fetchAllDataVersion()
                                        fetchAllDataFiscalYear();
                                        $("#version_detail_form")[0].reset();
                                        $("#version_detail_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Version Detail End

            // Find One Data Version Start
                $(document).on('click', '.version_detail_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataVersionDetail') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#version_detail_name").val(response.version_detail_name);
                            $("#version_id_for_detail").val(response.version_id);
                            $("#version_detail_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Version End

            // Delete Data Version Detail Start
                $(document).on('click', '.version_detail_delete', function(e) {
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
                                url: '{{ route('deleteDataVersionDetail') }}',
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
                                            fetchAllDataVersionDetail();
                                            fetchAllDataVersion();
                                            fetchAllDataFiscalYear();
                                        });
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Version Detail End

            // Fetch All Data Fiscal Year Start
                function fetchAllDataFiscalYear() {

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
                        url: '{{ route('fetchAllDataFiscalYear') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#fiscal_year_show_data_all").html(response);
                            $("#fiscal_year_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        }
                    });
                }
            // Fetch All Data Fiscal Year End

            // Insert && Update Data Fiscal Year Start
                $("#fiscal_year_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataFiscalYear') }}',
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
                                        fetchAllDataFiscalYear();
                                        fetchAllDataVersion();
                                        fetchAllDataVersionDetail();
                                        $("#fiscal_year_form")[0].reset();
                                        $("#fiscal_year_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataFiscalYear') }}',
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
                                        fetchAllDataFiscalYear();
                                        fetchAllDataVersion();
                                        fetchAllDataVersionDetail();
                                        $("#fiscal_year_form")[0].reset();
                                        $("#fiscal_year_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Fiscal Year End

            // Find One Data Fiscal Year Start
                $(document).on('click', '.fiscal_year_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataFiscalYear') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#fiscal_year_name").val(response.fiscal_year_name);
                            $("#fiscal_year_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Fiscal Year End

            // Delete Data Fiscal Year Start
                $(document).on('click', '.fiscal_year_delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
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
                                url: '{{ route('deleteDataFiscalYear') }}',
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
                                            fetchAllDataFiscalYear();
                                            fetchAllDataVersion();
                                            fetchAllDataVersionDetail();
                                        });
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Fiscal Year End
        }); 
    </script>
@endsection