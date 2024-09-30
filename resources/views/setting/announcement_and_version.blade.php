@extends('layout.dashboard_template')

@section('title')
    <title>Setting Announcement And Version</title>
@endsection

@section('content')
    {{-- modal Start --}}
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
                            <h5 class="modal-title" id="version_detail_title">เพิ่มข้อมูล Version Detail</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="version_detail_form" method="POST">
                                @csrf
                                <input type="hidden" id="mode" mode="">
                                <input type="hidden" id="version_detail_id_find_one" name="version_detail_id_find_one">
                                {{-- <div class="mb-3">
                                    <label for="sidebar_main_menu_id" class="form-label">ชื่อ Main Menu</label>
                                    <select class="form-select" aria-label="Default select example" name="sidebar_main_menu_id" id="sidebar_main_menu_id">
                                        <option selected value="0">--------------</option>
                                        @foreach($sidebar_main_menu_model AS $smmm)
                                            <option value="{{ $smmm->id }}">{{ $smmm->sidebar_main_menu_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
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
    {{-- modal End --}}
    <main class="main-content">
        <div class="">
            <div class="my-1">
                <h1>Announcement And Version Page</h1>
            </div>
            <hr>
            <div class="row">
                <div class="col-2 bg-success p-3 rounded rounded " style="height: 700px;">
                    <div class="d-flex justify-content-start align-items-center">
                        <ul class="text-white">
                            <li class="my-2 zoom-text"><a href="#version_setting_page" id="btn_version_setting" class="text-white text-decoration-none p-2">ตั้งค่า Version</a></li>
                            <li class="my-2 zoom-text"><a href="#version_detail_setting_page" id="btn_version_detail_setting" class="text-white text-decoration-none p-2">ตั้งค่า Version Detail</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-10 bg-white p-3" id="sidebar-menu-page" style="height: 700px; overflow-y: auto;">
                    {{-- Version Page Start --}}
                        <div class="my-1" id="version_setting_page">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fw-bold">ตั้งค่า Version &nbsp;
                                    <i class="bi bi-sliders"></i>&nbsp;
                                    <div class="spinner-border" id="loadingIconVersionMenu" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </h3>
                                <button type="button" class="btn btn-success zoom-card version_modal_add" id="version_modal_add" data-bs-toggle="modal" data-bs-target="#version_modal">Add Version</button>
                            </div>
                            <hr>
                            <div class="" id="version_show_data_all"></div>
                        </div>
                    {{-- Version Page End --}}
                    {{-- Version Detail Page Start --}}
                        <div class="my-1" id="version_detail_setting_page">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fw-bold">ตั้งค่า Version Detail &nbsp;
                                    <i class="bi bi-sliders"></i>&nbsp;
                                    <div class="spinner-border" id="loadingIconVersionDetailMenu" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </h3>
                                <button type="button" class="btn btn-success zoom-card version_detail_modal_add" id="version_detail_modal_add" data-bs-toggle="modal" data-bs-target="#version_detail_modal">Add Version Detail</button>
                            </div>
                            <hr>
                            <div class="" id="version_detail_show_data_all"></div>
                        </div>
                    {{-- Version Detail Page End --}}
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Function Icon Download Start
                // Version Start
                function showLoadingIconVersion() {
                        $('#loadingIconVersionMenu').show();
                    }

                    function hideLoadingIconVersion() {
                        $('#loadingIconVersionMenu').hide();
                    }
                // Version End
                // Version Detail Start
                    function showLoadingIconVersionDetail() {
                        $('#loadingIconVersion DetailMenu').show();
                    }

                    function hideLoadingIconVersionDetail() {
                        $('#loadingIconVersion DetailMenu').hide();
                    }
                // Version Detail End
            // Function Icon Download End

            // Default Menu Start
                $('#version_setting_page').show();
                $('#version_detail_setting_page').hide();
            // Default Menu End

            // onClick Change Menu Start
                $('#btn_version_setting').on('click', function() {
                    $('#version_setting_page').show();
                    $('#version_detail_setting_page').hide();
                });

                $('#btn_version_detail_setting').on('click', function() {
                    $('#version_detail_setting_page').show();
                    $('#version_setting_page').hide();
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
            // Change Mode add || update End

            // Reset Form Start
                $('.btn-close').on('click', function() {
                    $("#version_form")[0].reset();
                    $("#version_detail_form")[0].reset();
                });
            // Reset Form End

            // Fetch All Data Version Start
                fetchAllDataVersion();

                function fetchAllDataVersion() {
                    showLoadingIconVersion();
                    $.ajax({
                        url: '{{ route('fetchAllDataVersion') }}',
                        method: 'get',
                        success: function(response) {
                            hideLoadingIconVersion();
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
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                    fetchAllDataVersion();
                                    $("#version_form")[0].reset();
                                    $("#version_modal").modal('hide');
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
                                    swal.fire(
                                        response.title,
                                        response.message,
                                        response.icon
                                    )
                                    fetchAllDataVersion();
                                    $("#version_form")[0].reset();
                                    $("#version_modal").modal('hide');
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
                                        swal.fire(
                                            response.title,
                                            response.message,
                                            response.icon
                                        )
                                        fetchAllDataVersion();
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Version End
        }); 
    </script>
@endsection