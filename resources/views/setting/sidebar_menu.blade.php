@extends('layout.dashboard_template')

@section('title')
    <title>Setting Sidebar Menu</title>
@endsection

@section('content')
{{-- modal Start --}}
    {{-- Sidebar Main Menu Start --}}
        <div class="modal fade" id="sidebar_main_menu_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sidebar_main_menu_title">เพิ่มข้อมูล Sidebar Main Menu</h5>
                        <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="sidebar_main_menu_form" method="POST">
                            @csrf
                            <input type="hidden" id="mode" mode="">
                            <input type="hidden" id="sidebar_main_menu_id_find_one" name="sidebar_main_menu_id_find_one">
                            <div class="mb-3">
                                <label for="sidebar_main_menu_name" class="form-label">ชื่อ Main Menu</label>
                                <input type="text" class="form-control" id="sidebar_main_menu_name" name="sidebar_main_menu_name">
                            </div>
                            <div class="mb-3">
                                <label for="link_url_or_route" class="form-label">Link URL หรือ Route บน Laravel</label>
                                <input type="text" class="form-control" id="link_url_or_route" name="link_url_or_route">
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary zoom-card" id="sidebar_main_menu_submit">ยืนยัน</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- Sidebar Main Menu End --}}
    {{-- Sidebar Sub Menu Start --}}
        <div class="modal fade" id="sidebar_sub1_menu_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sidebar_sub1_menu_title">เพิ่มข้อมูล Sidebar Sub1 Menu</h5>
                        <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="sidebar_sub1_menu_form" method="POST">
                            @csrf
                            <input type="hidden" id="mode" mode="">
                            <input type="hidden" id="sidebar_sub1_menu_id_find_one" name="sidebar_sub1_menu_id_find_one">
                            <div class="mb-3">
                                <label for="sidebar_sub1_menu_name" class="form-label">ชื่อ Sub1 Menu</label>
                                <input type="text" class="form-control" id="sidebar_sub1_menu_name" name="sidebar_sub1_menu_name">
                            </div>
                            <div class="mb-3">
                                <label for="sidebar_main_menu_id" class="form-label">ชื่อ Main Menu</label>
                                <select class="form-select" aria-label="Default select example" name="sidebar_main_menu_id" id="sidebar_main_menu_id">
                                    <option selected value="0">--------------</option>
                                    @foreach($sidebar_main_menu_model AS $smmm)
                                        <option value="{{ $smmm->id }}">{{ $smmm->sidebar_main_menu_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="link_url_or_route_sub1" class="form-label">Link URL หรือ Route บน Laravel</label>
                                <input type="text" class="form-control" id="link_url_or_route_sub1" name="link_url_or_route_sub1">
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary zoom-card" id="sidebar_sub_menu_submit">ยืนยัน</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- Sidebar Sub Menu End --}}
{{-- modal End --}}
    <main class="main-content">
        <div class="">
            <div class="my-1">
                <h1>Sidebar Menu Page</h1>
            </div>
            <hr>
            <div class="row">
                <div class="col-2 bg-success p-3 rounded rounded " style="height: 700px;">
                    <div class="d-flex justify-content-start align-items-center">
                        <ul class="text-white">
                            <li class="my-2 zoom-text"><a href="#sidebar_main_menu" id="btn_sidebar_main_menu_setting" class="text-white text-decoration-none p-2">ตั้งค่า Sidebar Main Menu</a></li>
                            <li class="my-2 zoom-text"><a href="#sidebar_sub1_menu" id="btn_sidebar_sub1_menu_setting" class="text-white text-decoration-none p-2">ตั้งค่า Sidebar Sub1 Menu</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-10 bg-white p-3" id="sidebar-menu-page" style="height: 700px; overflow-y: auto;">
                    {{-- Sidebar Main Menu Page Start --}}
                        <div class="my-1" id="sidebar_main_menu_setting_page">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fw-bold">ตั้งค่า Sidebar Main Menu &nbsp;
                                    <i class="bi bi-sliders"></i>&nbsp;
                                    <div class="spinner-border" id="loadingIconSidebarMainMenu" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </h3>
                                <button type="button" class="btn btn-success zoom-card sidebar_main_menu_modal_add" id="sidebar_main_menu_modal_add" data-bs-toggle="modal" data-bs-target="#sidebar_main_menu_modal">Add Sidebar Main Menu</button>
                            </div>
                            <hr>
                            <div class="" id="sidebar_main_menu_show_data_all"></div>
                        </div>
                    {{-- Sidebar Main Menu Page End --}}
                    {{-- Sidebar Sub1 Menu Page Start --}}
                        <div class="my-1" id="sidebar_sub1_menu_setting_page">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fw-bold">ตั้งค่า Sidebar Sub1 Menu &nbsp;
                                    <i class="bi bi-sliders"></i>&nbsp;
                                    <div class="spinner-border" id="loadingIconSidebarSub1Menu" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </h3>
                                <button type="button" class="btn btn-success zoom-card sidebar_sub1_menu_modal_add" id="sidebar_sub1_menu_modal_add" data-bs-toggle="modal" data-bs-target="#sidebar_sub1_menu_modal">Add Sidebar Sub1 Menu</button>
                            </div>
                            <hr>
                            <div class="" id="sidebar_sub1_menu_show_data_all"></div>
                        </div>
                    {{-- Sidebar Sub1 Menu Page End --}}
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Function Icon Download Start
                // Main Start
                    function showLoadingIconMain() {
                        $('#loadingIconSidebarMainMenu').show();
                    }

                    function hideLoadingIconMain() {
                        $('#loadingIconSidebarMainMenu').hide();
                    }
                // Main End
                // Sub1 Start
                    function showLoadingIconSub1() {
                        $('#loadingIconSidebarSub1Menu').show();
                    }

                    function hideLoadingIconSub1() {
                        $('#loadingIconSidebarSub1Menu').hide();
                    }
                // Sub1 End
            // Function Icon Download End

            // Default Menu Start
                $('#sidebar_main_menu_setting_page').show();
                $('#sidebar_sub1_menu_setting_page').hide();
            // Default Menu End

            // onClick Change Menu Start
                $('#btn_sidebar_main_menu_setting').on('click', function() {
                    $('#sidebar_main_menu_setting_page').show();
                    $('#sidebar_sub1_menu_setting_page').hide();
                });

                $('#btn_sidebar_sub1_menu_setting').on('click', function() {
                    $('#sidebar_sub1_menu_setting_page').show();
                    $('#sidebar_main_menu_setting_page').hide();
                });
            // onClick Change Menu End

            // Change Mode add || update Start
                // Sidebar Main Menu Start
                    $('.sidebar_main_menu_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#sidebar_main_menu_title').text('เพิ่มข้อมูล');
                        $('#sidebar_main_menu_submit').text('Add Data');
                        $("#sidebar_main_menu_form")[0].reset();
                    });

                    $(document).on('click', '.sidebar_main_menu_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#sidebar_main_menu_title').text('แก้ไขข้อมูล');
                        $('#sidebar_main_menu_submit').text('Update Data');
                    });
                // Sidebar Main Menu End
                // Sidebar Sub1 Menu Start
                    $('.sidebar_sub1_menu_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#sidebar_sub1_menu_title').text('เพิ่มข้อมูล');
                        $('#sidebar_sub1_menu_submit').text('Add Data');
                        $("#sidebar_sub1_menu_form")[0].reset();
                    });

                    $(document).on('click', '.sidebar_sub1_menu_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#sidebar_sub1_menu_title').text('แก้ไขข้อมูล');
                        $('#sidebar_sub1_menu_submit').text('Update Data');
                    });
                // Sidebar Sub1 Menu End
            // Change Mode add || update End

            // Reset Form Start
                $('.btn-close').on('click', function() {
                    $("#sidebar_main_menu_form")[0].reset();
                    $("#sidebar_sub1_menu_form")[0].reset();
                });
            // Reset Form End

            // Fetch All Data Sidebar Main Menu Start
                fetchAllDataSidebarMainMenu();

                function fetchAllDataSidebarMainMenu() {
                    showLoadingIconMain();
                    $.ajax({
                        url: '{{ route('fetchAllDataSidebarMainMenu') }}',
                        method: 'get',
                        success: function(response) {
                            hideLoadingIconMain();
                            $("#sidebar_main_menu_show_data_all").html(response);
                            $("#sidebar_main_menu_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        }
                    });
                }
            // Fetch All Data Sidebar Main Menu End

            // Insert && Update Data Sidebar Main Menu Start
                $("#sidebar_main_menu_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataSidebarMainMenu') }}',
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
                                    fetchAllDataSidebarMainMenu();
                                    $("#sidebar_main_menu_form")[0].reset();
                                    $("#sidebar_main_menu_modal").modal('hide');
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataSidebarMainMenu') }}',
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
                                    fetchAllDataSidebarMainMenu();
                                    $("#sidebar_main_menu_form")[0].reset();
                                    $("#sidebar_main_menu_modal").modal('hide');
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Sidebar Main Menu End

            // Find One Data Sidebar Main Menu Start
                $(document).on('click', '.sidebar_main_menu_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataSidebarMainMenu') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#sidebar_main_menu_name").val(response.sidebar_main_menu_name);
                            $("#link_url_or_route").val(response.link_url_or_route);
                            $("#sidebar_main_menu_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Sidebar Main Menu End

            // Delete Data Sidebar Main Menu Start
                $(document).on('click', '.sidebar_main_menu_delete', function(e) {
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
                                url: '{{ route('deleteDataSidebarMainMenu') }}',
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
                                        fetchAllDataSidebarMainMenu();
                                    }
                                    console.log(response);
                                }
                            });
                        }
                    })
                });
            // Delete Data Sidebar Main Menu End

            // Fetch All Data Sidebar Sub1 Menu Start
                fetchAllDataSidebarSub1Menu();

                function fetchAllDataSidebarSub1Menu() {
                    showLoadingIconSub1();
                    $.ajax({
                        url: '{{ route('fetchAllDataSidebarSub1Menu') }}',
                        method: 'get',
                        success: function(response) {
                            hideLoadingIconSub1();
                            $("#sidebar_sub1_menu_show_data_all").html(response);
                            $("#sidebar_sub1_menu_table").DataTable({
                                // order: [0, 'ASC']
                            });
                        }
                    });
                }
            // Fetch All Data Sidebar Sub1 Menu End

            // Insert && Update Data Sidebar Sub1 Menu Start
                $("#sidebar_sub1_menu_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataSidebarSub1Menu') }}',
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
                                    fetchAllDataSidebarSub1Menu();
                                    $("#sidebar_sub1_menu_form")[0].reset();
                                    $("#sidebar_sub1_menu_modal").modal('hide');
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataSidebarSub1Menu') }}',
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
                                    fetchAllDataSidebarSub1Menu();
                                    $("#sidebar_sub1_menu_form")[0].reset();
                                    $("#sidebar_sub1_menu_modal").modal('hide');
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Sidebar Sub1 Menu End

            // Find One Data Sidebar Sub1 Menu Start
                $(document).on('click', '.sidebar_sub1_menu_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataSidebarSub1Menu') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#sidebar_sub1_menu_name").val(response.sidebar_sub1_menu_name);
                            $("#link_url_or_route").val(response.link_url_or_route);
                            $("#sidebar_sub1_menu_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Sidebar Sub1 Menu End

            // Delete Data Sidebar Sub1 Menu Start
                $(document).on('click', '.sidebar_sub1_menu_delete', function(e) {
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
                                url: '{{ route('deleteDataSidebarSub1Menu') }}',
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
                                        fetchAllDataSidebarSub1Menu();
                                    }
                                    console.log(response);
                                }
                            });
                        }
                    })
                });
            // Delete Data Sidebar Sub1 Menu End
        });
    </script>
@endsection