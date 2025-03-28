@extends('layout.dashboard_template')

@section('title')
    <title>ทะเบียนคนไข้ทั้งหมด</title>
@endsection

@section('content')
    <!-- Modal เยี่ยมบ้าน รพ.ครั้ง Start -->
        {{-- ทะเบียนเยี่ยมบ้าน  Z718 Start --}}
            <div class="modal fade " id="all_patients_home_visiting_information_z718" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="all_patients_home_visiting_information_z718_title">ข้อมูลการเยี่ยมบ้าน Family Meeting</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container" id="show-all-patients-home-visiting-information-z718"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ทะเบียนเยี่ยมบ้าน  Z718 End --}}
        {{-- ทะเบียนเยี่ยมบ้าน รพ.(ครั้ง) Start --}}
            <div class="modal fade " id="all_patients_home_visiting_information" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-custom modal-dialog-centered mt-5">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="all_patients_home_visiting_information_title">ข้อมูลการเยี่ยมบ้าน</h5>
                            <button type="button" class="btn-close zoom-card" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container" id="show-all-patients-home-visiting-information"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger zoom-card" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- ทะเบียนเยี่ยมบ้าน รพ.(ครั้ง) End --}}
        
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="" id="imageModalSrc" class="img-fluid" alt="Full Size Image">
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal เยี่ยมบ้าน รพ.ครั้ง End -->
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
                        <h1 class="h2">ทะเบียนคนไข้ทั้งหมด</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}

        {{-- All Form Date Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" id="form_all">
                <div class="d-flex justify-content-center align-items-center mt-4">
                    {{-- Form ดึงรายชื่อคนไข้ทั้งหมด Start --}}
                        <form id="all_patients_list_name_form">
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
                                    <div class="" style="min-width: 120px;">
                                        <span class="" style="width: 100%;">เลือกประเภทการเยี่ยม</span>
                                    </div>
                                    <select class="form-select ms-2" placeholder="เลือกประเภทการเยี่ยม" id="type_of_visit" name="type_of_visit" aria-label="Default select example"
                                        style="min-width: 200px;">
                                        <option selected value="0">------------</option>
                                        <option value="99999">ทั้งหมด</option>
                                        @foreach($ovst_community_service_type as $ocst)
                                            <option value="{{ $ocst->ovst_community_service_type_code }}">{{ $ocst->ovst_community_service_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <div class="" style="min-width: 80px;">
                                        <span class="" style="width: 100%;">เลือกสถานะ</span>
                                    </div>
                                    <select class="form-select ms-2" placeholder="เลือกสถานะ" id="death_type" name="death_type" aria-label="Default select example"
                                        style="min-width: 200px;">
                                        <option selected value="0">------------</option>
                                        <option value="99999">ทั้งหมด</option>
                                        <option value="Y">เสียชีวิต</option>
                                        <option value="N">ยังมีชีวิต</option>
                                    </select>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <button type="button" id="all_patients_list_name_submit" class="btn btn-primary ms-1 zoom-card">ยืนยัน</button>
                                </div>
                            </div>
                        </form>
                    {{-- Form ดึงรายชื่อคนไข้ทั้งหมด End --}}
                </div>
            </div>
        {{-- All Form Date End --}}

        {{-- แสดงข้อมูลคนไข้ทั้งหมด ตาม วันที่, สถานบริการ, สถานการมีชีวิตหรือเสียชีวิต แบบ Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="all_patients_list_name_table">
                <div class="row w-100">
                    <div class="col-12 w-auto">
                        <div class="mx-5 w-auto">
                            <div class="my-5 ms-0 w-auto">
                                <div class="w-auto" id="fetch-list-name"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- แสดงข้อมูลคนไข้ทั้งหมด ตาม วันที่, สถานบริการ, สถานการมีชีวิตหรือเสียชีวิต แบบ Table End --}}
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // เริ่มต้น Hide Start
                $('#all_patients_list_name_table').hide();
                $('.loadingIcon').hide();
            // เริ่มต้น Hide End

            // Set Text Start
                function setText(request) {
                    if(request == 0) {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('');
                        $('#setCount').text('ไม่มีคนไข้ทั้งหมด');
                    } else {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('จำนวนคนไข้ทั้งหมดที่แยกตาม รพสต. : ');
                        $('#setCount').text(request + ' ราย');
                    }
                }
            // Set Text End

            // Hide Form && Chart && Table Start
                function hideForm() {
                    $('#setText').hide();
                    $('#setCount').hide();
                    $('#all_patients_list_name_table').hide();
                    $('#all_patients_list_name_form').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // ดึงข้อมูลรายชื่อคนไข้ทั้งหมด ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือเสียชีวิต Start
                $('#all_patients_list_name_submit').click(function(e) {
                    e.preventDefault();
                    var formData = $('#all_patients_list_name_form').serialize();

                    $('#all_patients_list_name_table').hide();
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
                        url: '{{ route('getAllPatientsFetchListName') }}',
                        type: 'GET',
                        data: formData,
                        success: function(response) {
                            Swal.close();
                            if(response.status === 400) {
                                swal.fire(
                                    response.title,
                                    response.message,
                                    response.icon
                                );
                            } else {
                                $('#all_patients_list_name_table').show();
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
                                    ],
                                    "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อคนไข้ทั้งหมด ตาม วันที่, เวลา, สถานบริการ, สถานะการมีชีวิตหรือเสียชีวิต End

            // ดึงข้อมูลการเยี่ยมบ้าน Z718 แสดงบน Modal Start
                $(document).on('click', '.all-patients-home-visiting-information-z718', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#show-all-patients-home-visiting-information').hide();
                    $('#show-all-patients-home-visiting-information-z718').hide();
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
                        url: '{{ route('getAllPatientsHomeVisitingInformationZ718') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            $('#show-all-patients-home-visiting-information-z718').show();
                            $("#show-all-patients-home-visiting-information-z718").html(response);
                        }
                    });
                });
            // ดึงข้อมูลการเยี่ยมบ้าน Z718 แสดงบน Modal End

            // ดึงข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) แสดงบน Modal Start
                $(document).on('click', '.all-patients-home-visiting-information', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#show-all-patients-home-visiting-information').hide();
                    $('#show-all-patients-home-visiting-information-z718').hide();
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
                        url: '{{ route('getAllPatientsHomeVisitingInformation') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            $('#show-all-patients-home-visiting-information').show();
                            $("#show-all-patients-home-visiting-information").html(response);
                        }
                    });
                });
            // ดึงข้อมูลการเยี่ยมบ้าน รพ.(ครั้ง) แสดงบน Modal End

        });
    </script>
@endsection
