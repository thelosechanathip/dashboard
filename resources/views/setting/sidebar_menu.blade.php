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
                                    <label for="link_url_or_route_main" class="form-label">Link URL หรือ Route บน Laravel</label>
                                    <input type="text" class="form-control" id="link_url_or_route_main" name="link_url_or_route_main">
                                </div>
                                <div class="mb-3" id="hide_status_id_for_sidebar_main_menu">
                                    <label for="status_id_for_sidebar_main_menu" class="form-label">Status</label>
                                    <select class="form-select" aria-label="Default select example" name="status_id_for_sidebar_main_menu" id="status_id_for_sidebar_main_menu">
                                        <option selected value="0">--------------</option>
                                        @foreach($status_model AS $sm)
                                            <option value="{{ $sm->id }}">{{ $sm->status_name }}</option>
                                        @endforeach
                                    </select>
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
                                <div class="mb-3" id="hide_status_id_for_sidebar_sub1_menu">
                                    <label for="status_id_for_sidebar_sub1_menu" class="form-label">Status</label>
                                    <select class="form-select" aria-label="Default select example" name="status_id_for_sidebar_sub1_menu" id="status_id_for_sidebar_sub1_menu">
                                        <option selected value="0">--------------</option>
                                        @foreach($status_model AS $sm)
                                            <option value="{{ $sm->id }}">{{ $sm->status_name }}</option>
                                        @endforeach
                                    </select>
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
    {{-- Offcanvas Start --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar_m_menu" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="d-flex justify-content-start align-items-center">
                    <ul class="text-white">
                        <li class="my-2 zoom-text"><a href="#sidebar_main_menu" id="btn_sidebar_main_menu_setting" class="text-dark text-decoration-none p-2">ตั้งค่า Sidebar Main Menu</a></li>
                        <li class="my-2 zoom-text"><a href="#sidebar_sub1_menu" id="btn_sidebar_sub1_menu_setting" class="text-dark text-decoration-none p-2">ตั้งค่า Sidebar Sub1 Menu</a></li>
                    </ul>
                </div>
            </div>
        </div>
    {{-- Offcanvas End --}}
    <main class="main-content">
        <div class="">
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="my-1 d-flex justify-content-between align-items-center">
                    <h1>Sidebar Menu Page</h1>
                    <div class="p-2">
                        <button class="btn btn-outline-primary ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar_m_menu" aria-controls="offcanvasRight"><i class="bi bi-list"></i></button>
                    </div>
                </div>
            </div>
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400" id="sidebar-menu-page">
                {{-- Sidebar Main Menu Page Start --}}
                    <div class="my-1" id="sidebar_main_menu_setting_page">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold">ตั้งค่า Sidebar Main Menu &nbsp;
                                <i class="bi bi-sliders"></i>&nbsp;
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
                            </h3>
                            <button type="button" class="btn btn-success zoom-card sidebar_sub1_menu_modal_add" id="sidebar_sub1_menu_modal_add" data-bs-toggle="modal" data-bs-target="#sidebar_sub1_menu_modal">Add Sidebar Sub1 Menu</button>
                        </div>
                        <hr>
                        <div class="" id="sidebar_sub1_menu_show_data_all"></div>
                    </div>
                {{-- Sidebar Sub1 Menu Page End --}}
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // Default Menu Start
                $('#sidebar_main_menu_setting_page').show();
                $('#sidebar_sub1_menu_setting_page').hide();
            // Default Menu End

            // onClick Change Menu Start
                $('#btn_sidebar_main_menu_setting').on('click', function() {
                    $('#sidebar_main_menu_setting_page').show();
                    $('#sidebar_sub1_menu_setting_page').hide();
                    $('#sidebar_m_menu').offcanvas('hide');
                });

                $('#btn_sidebar_sub1_menu_setting').on('click', function() {
                    $('#sidebar_sub1_menu_setting_page').show();
                    $('#sidebar_main_menu_setting_page').hide();
                    $('#sidebar_m_menu').offcanvas('hide');
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
                        url: '{{ route('fetchAllDataSidebarMainMenu') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
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
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataSidebarMainMenu();
                                        $("#sidebar_main_menu_form")[0].reset();
                                        $("#sidebar_main_menu_modal").modal('hide');
                                    });
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
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataSidebarMainMenu();
                                        $("#sidebar_main_menu_form")[0].reset();
                                        $("#sidebar_main_menu_modal").modal('hide');
                                    });
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
                            $("#link_url_or_route_main").val(response.link_url_or_route);
                            $("#sidebar_main_menu_id_find_one").val(response.id);
                            $("#hide_status_id_for_sidebar_main_menu").hide();
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
                                        swal.fire({
                                            title: response.title,
                                            text: response.message,
                                            icon: response.icon
                                        }).then((result) => {
                                            fetchAllDataSidebarMainMenu();
                                        });
                                    }
                                    console.log(response);
                                }
                            });
                        }
                    })
                });
            // Delete Data Sidebar Main Menu End

            // Change Status_id In Sidebar Main Menu Start
                $(document).ready(function() {
                    $('.status_checked_in_sidebar_main_menu').each(function() {
                        var status = $(this).val();
                        if (status == 1) {
                            $(this).prop('checked', true);
                        } else if (status == 2) {
                            $(this).prop('checked', false);
                        }
                    });

                    $(document).on('change', '.status_checked_in_sidebar_main_menu', function(e) {
                        e.preventDefault();

                        const status_id_for_sidebar_main_menu = $(this).is(':checked') ? 1 : 2;
                        const form = $(this).closest('form'); // Get the closest form
                        const id = form.find('#sidebar_main_menu_id').val(); // Get the ID from the hidden input

                        // Create a data object to hold the status_id and id
                        let data = {
                            status_id_for_sidebar_main_menu: status_id_for_sidebar_main_menu,
                            id: id,
                            _token: form.find('input[name="_token"]').val()
                        };

                        $.ajax({
                            url: '{{ route('ChangeStatusIdInSidebarMainMenuRealtime') }}',
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
                                        fetchAllDataSidebarMainMenu();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    });
                });
            // Change Status_id In Sidebar Main Menu End

            // Fetch All Data Sidebar Sub1 Menu Start
                fetchAllDataSidebarSub1Menu();

                function fetchAllDataSidebarSub1Menu() {

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
                        url: '{{ route('fetchAllDataSidebarSub1Menu') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
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
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataSidebarSub1Menu();
                                        $("#sidebar_sub1_menu_form")[0].reset();
                                        $("#sidebar_sub1_menu_modal").modal('hide');
                                    });
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
                                    swal.fire({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataSidebarSub1Menu();
                                        $("#sidebar_sub1_menu_form")[0].reset();
                                        $("#sidebar_sub1_menu_modal").modal('hide');
                                    });
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
                            $("#sidebar_main_menu_id").val(response.sidebar_main_menu_id);
                            $("#link_url_or_route_sub1").val(response.link_url_or_route);
                            $("#sidebar_sub1_menu_id_find_one").val(response.id);
                            $("#hide_status_id_for_sidebar_sub1_menu").hide();
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
                                        swal.fire({
                                            title: response.title,
                                            text: response.message,
                                            icon: response.icon
                                        }).then((result) => {
                                            fetchAllDataSidebarSub1Menu();
                                        });
                                    }
                                    console.log(response);
                                }
                            });
                        }
                    })
                });
            // Delete Data Sidebar Sub1 Menu End

            // Change Status_id In Sidebar Sub1 Menu Start
                $(document).ready(function() {
                    $('.status_checked_in_sidebar_sub1_menu').each(function() {
                        var status = $(this).val();
                        if (status == 1) {
                            $(this).prop('checked', true);
                        } else if (status == 2) {
                            $(this).prop('checked', false);
                        }
                    });

                    $(document).on('change', '.status_checked_in_sidebar_sub1_menu', function(e) {
                        e.preventDefault();

                        const status_id_for_sidebar_sub1_menu = $(this).is(':checked') ? 1 : 2;
                        const form = $(this).closest('form'); // Get the closest form
                        const id = form.find('#sidebar_sub1_menu_id').val(); // Get the ID from the hidden input

                        // Create a data object to hold the status_id and id
                        let data = {
                            status_id_for_sidebar_sub1_menu: status_id_for_sidebar_sub1_menu,
                            id: id,
                            _token: form.find('input[name="_token"]').val()
                        };

                        $.ajax({
                            url: '{{ route('ChangeStatusIdInSidebarSub1MenuRealtime') }}',
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
                                        fetchAllDataSidebarSub1Menu();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    });
                });
            // Change Status_id In Sidebar Sub1 Menu End
        });
    </script>
@endsection
