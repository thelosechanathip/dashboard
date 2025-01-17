@extends('layout.dashboard_template')

@section('title')
    <title>Setting Working Type</title>
@endsection

@section('content')
    {{-- Working Modal Start --}}
        <div class="modal fade" id="working_type_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="working_type_title"></h5>
                        <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="working_type_form" method="POST">
                            @csrf
                            <input type="hidden" id="mode" mode="">
                            <input type="hidden" id="working_type_id_find_one" name="working_type_id_find_one">
                            <div class="mb-3">
                                <label for="working_type_name" class="form-label">ชื่อประเภทของงาน</label>
                                <input type="text" class="form-control" id="working_type_name" name="working_type_name">
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary zoom-card" id="working_type_submit"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- Working Modal End --}}
    <main class="main-content mb-5">
        <div class="">
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
            {{-- <hr> --}}
            {{-- Working Type Page Start --}}
            <div class="my-1" id="working_type_setting_page">
                
                <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <span class="d-flex">
                            <h2>ประเภทของงาน</h2>
                        </span>
                        <button type="button" class="btn btn-success zoom-card working_type_modal_add mt-2 mt-md-0 " id="working_type_modal_add" data-bs-toggle="modal" data-bs-target="#working_type_modal">เพิ่มรายการประเภทของงาน</button>
                    </div>
                </div>
                <hr>
                <div class="mt-3 card shadow-lg full-width-bar p-3" id="working_type_show_data_all"></div>
            </div>
            {{-- Working Type Page End --}}
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // Change Mode add || update Start
                // Working Type Start
                    $('.working_type_modal_add').on('click', function() {
                        $('#mode').attr('mode', 'add');
                        $('#working_type_title').text('เพิ่มข้อมูล');
                        $('#working_type_submit').text('Add Data');
                        $("#working_type_form")[0].reset();
                    });

                    $(document).on('click', '.working_type_modal_find', function() {
                        $('#mode').attr('mode', 'update');
                        $('#working_type_title').text('แก้ไขข้อมูล');
                        $('#working_type_submit').text('Update Data');
                    });
                // Working Type End
            // Change Mode add || update End

            // Reset Form Start
                $('.btn-close').on('click', function() {
                    $("#working_type_form")[0].reset();
                });
            // Reset Form End

            // Fetch All Data Working Type Start
                fetchAllDataWorkingType();

                function fetchAllDataWorkingType() {

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
                        url: '{{ route('fetchAllDataWorkingType') }}',
                        method: 'get',
                        success: function(response) {
                            Swal.close();
                            $("#working_type_show_data_all").html(response);
                            $("#working_type_table").DataTable({
                                "scrollX": true
                            });
                        }
                    });
                }
            // Fetch All Data Working Type End

            // Insert && Update Data Working Type Start
                $("#working_type_form").submit(function(e) {
                    const mode = $('#mode').attr('mode');
                    if(mode === 'add') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('insertDataWorkingType') }}',
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
                                        tile: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataWorkingType();
                                        $("#working_type_form")[0].reset();
                                        $("#working_type_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else if(mode === 'update') {
                        e.preventDefault();
                        const fd = new FormData(this);
                        $.ajax({
                            url: '{{ route('updateDataWorkingType') }}',
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
                                        tile: response.title,
                                        text: response.message,
                                        icon: response.icon
                                    }).then((result) => {
                                        fetchAllDataWorkingType();
                                        $("#working_type_form")[0].reset();
                                        $("#working_type_modal").modal('hide');
                                    });
                                }
                            }
                        });
                    } else {
                        console.log('Mode ไม่ถูกต้อง');
                    }
                });
            // Insert && Update Data Working Type End

            // Find One Data Working Type Start
                $(document).on('click', '.working_type_modal_find', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('findOneDataWorkingType') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#working_type_name").val(response.working_type_name);
                            $("#working_type_id_find_one").val(response.id);
                        }
                    });
                });
            // Find One Data Working Type End

            // Delete Data Working Type Start
                $(document).on('click', '.working_type_delete', function(e) {
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
                                url: '{{ route('deleteDataWorkingType') }}',
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
                                            fetchAllDataWorkingType();
                                        });
                                    }
                                }
                            });
                        }
                    })
                });
            // Delete Data Working Type End
        }); 
    </script>
@endsection