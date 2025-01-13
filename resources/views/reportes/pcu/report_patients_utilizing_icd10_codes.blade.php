@extends('layout.dashboard_template')

@section('title')
    <title>รายงานรายชื่อคนไข้ที่มารับบริการด้วย ICD10</title>
@endsection

@section('content')
    <main class="main-content mb-5" id="icd10_main">
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
                        <h1 class="h2">รายงานรายชื่อคนไข้ที่มารับบริการด้วย ICD10</h1>
                    </div>
                </div>
            </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}
        {{-- All Form Date Start --}}
            <div class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="mt-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <form id="selectForm" class="me-3">
                            @csrf
                            <div class="mb-3 d-flex align-items-center row">
                                <div class="col">
                                    <span class="w-100">รายการ</span>
                                    <select class="form-select" id="select" aria-label="Default select example">
                                        <option selected value="0">----------</option>
                                        <option value="1">ปีงบประมาณ</option>
                                        <option value="2">กำหนดเอง</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="year_select" class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <form id="yearForm">
                    @csrf
                    <div class="mb-3 d-flex align-items-center row">
                        <div class="col">
                            <span>เลือกปีงบ</span>
                            <select class="form-select" id="yearSelect" name="yearSelect" aria-label="Default select example">
                                <option selected value="0">----------</option>
                                @foreach($fiscal_year AS $fy)
                                    <option value="{{ $fy->fiscal_year_name }}">ปีงบ {{ $fy->fiscal_year_name + 543 }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <span>เลือก ICD10</span>
                            <select class="form-select" id="yearIcd10" name="yearIcd10" aria-label="Default select example"></select>
                        </div>
                        <div class="col d-flex align-items-center mt-4">
                            <button type="button" id="submitYear" class="btn btn-primary zoom-card">ค้นหาข้อมูล</button>
                        </div>
                    </div>
                </form>
                <form id="dateSelectForm">
                    @csrf
                    <div class="mb-3 d-flex align-items-center row">
                        <div class="col">
                            <div class="">
                                <span class="">วันที่เริ่มต้น</span>
                            </div>
                            <div>
                                <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date">
                            </div>
                        </div>
                        <div class="col">
                            <span class="">ถึงวันที่</span>
                            <div class="">
                                <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date">
                            </div>
                        </div>
                        <div class="col">
                            <span>เลือก ICD10</span>
                            <select class="form-select" id="dateSelectIcd10" name="dateSelectIcd10" aria-label="Default select example"></select>
                        </div>
                        <div class="col d-flex align-items-center mt-4">
                            <button type="button" id="submitAll" class="btn btn-primary ms-3">ค้นหาข้อมูล</button>
                        </div>
                    </div>
                </form>
            </div>
        {{-- All Form Date End --}}
        {{-- Show Table Start --}}
            <div class="mt-3 card shadow-lg w-100" id="report_patients_utilizing_icd10_codes_table">
                <div class="mx-5 w-auto">
                    <div class="my-5 ms-0 w-auto">
                        <div class="w-auto" id="fetch-report-patients-utilizing-icd10-codes"></div>
                    </div>
                </div>
            </div>
        {{-- Show Table End --}}
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // Select2 Query Start
                // ICD 10 Start
                    $('#yearIcd10').select2({
                        placeholder: 'ค้นหา ICD 10',
                        allowClear: true,
                        dropdownParent: $('#icd10_main'),  // Bind the dropdown to a specific element
                        ajax: {
                            url: '{{ route('query_icd10') }}',  // Make sure this outputs the correct URL
                            dataType: 'json',
                            delay: 250,  // Wait 250 milliseconds after typing stops to send the request
                            data: function (params) {
                                return {
                                    searchTerm: params.term  // This sends the input to the server
                                };
                            },
                            processResults: function (data) {
                                return {
                                    results: data.results.map(function(item) {
                                        return { id: item.id, text: item.id + ' : ' + item.text }; // รวม id และ text
                                    })
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 1,  // User must type at least 1 character to trigger the ajax call
                    });

                    $('#dateSelectIcd10').select2({
                        placeholder: 'ค้นหา ICD 10',
                        allowClear: true,
                        dropdownParent: $('#icd10_main'),  // Bind the dropdown to a specific element
                        ajax: {
                            url: '{{ route('query_icd10') }}',  // Make sure this outputs the correct URL
                            dataType: 'json',
                            delay: 250,  // Wait 250 milliseconds after typing stops to send the request
                            data: function (params) {
                                return {
                                    searchTerm: params.term  // This sends the input to the server
                                };
                            },
                            processResults: function (data) {
                                return {
                                    results: data.results.map(function(item) {
                                        return { id: item.id, text: item.id + ' : ' + item.text }; // รวม id และ text
                                    })
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 1,  // User must type at least 1 character to trigger the ajax call
                    });
                // ICD 10 End
            // Select2 Query End

            // เริ่มต้น Hide Start
                $('#report_patients_utilizing_icd10_codes_table').hide();
                $('#yearForm').hide();
                $('#year_select').hide();
                $('#dateSelectForm').hide();
            // เริ่มต้น Hide End

            $('#select').on('change', function() {
                var selectForm = $('#select').val();
                if (selectForm != '0' && selectForm == '1') { // 1 = Year
                    $('#yearForm').show();
                    $('#year_select').show();
                    $('#dateSelectForm').hide();
                    $('#dateSelectForm')[0].reset();
                    $('#report_patients_utilizing_icd10_codes_table').hide();
                    $('#yearIcd10').val(null).trigger('change');
                    $('#dateSelectIcd10').val(null).trigger('change');
                } else if (selectForm != '0' && selectForm == '2') { // 2 = กำหนดเอง
                    $('#dateSelectForm').show();
                    $('#year_select').show();
                    $('#yearForm').hide();
                    $('#yearForm')[0].reset();
                    $('#report_patients_utilizing_icd10_codes_table').hide();
                } else {
                    $('#yearForm')[0].reset();
                    $('#dateSelectForm')[0].reset();
                    $('#year_select').hide();
                    $('#report_patients_utilizing_icd10_codes_table').hide();
                    $('#yearIcd10').val(null).trigger('change'); // Reset Select2
                    $('#dateSelectIcd10').val(null).trigger('change'); // Reset Select2
                }
            });

            // Set Text Start
                function setText(request) {
                    if(request == 0) {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('');
                        $('#setCount').text('ไม่มีรายการ ICD 10');
                    } else {
                        $('#setText').show();
                        $('#setCount').show();
                        $('#setText').text('จำนวนรายการ ICD 10 : ');
                        $('#setCount').text(request + ' ราย');
                    }
                }
            // Set Text End

            // Hide Form && Chart && Table Start
                function hideForm() {
                    $('#setText').hide();
                    $('#setCount').hide();
                    $('#report_patients_utilizing_icd10_codes_table').hide();
                    $('#select').val('0');
                }
            // Hide Form && Chart && Table End

            // ดึงข้อมูลรายชื่อที่มี ICD 10 ตามปีงบประมาณ ที่เลือกเอง Start
                $('#submitYear').click(function(e) {
                    e.preventDefault();
                    var formData = $('#yearForm').serialize();

                    $('#report_patients_utilizing_icd10_codes_table').hide();
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
                        url: '{{ route('getReportPatientsUtilizingIcd10CodesFetch') }}',
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
                                $('#report_patients_utilizing_icd10_codes_table').show();
                                $('#setText').hide();
                                $('#setCount').hide();
                                $("#fetch-report-patients-utilizing-icd10-codes").html(response);
                                $("#table-fetch-report-patients-utilizing-icd10-codes").DataTable({
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
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อที่มี ICD 10 ตามปีงบประมาณ ที่เลือกเอง End

            // ดึงข้อมูลรายชื่อที่มี ICD 10 ตามวัน-เดือน-ปี ที่เลือกเอง Start
                $('#submitAll').click(function(e) {
                    e.preventDefault();
                    var formData = $('#dateSelectForm').serialize();

                    $('#report_patients_utilizing_icd10_codes_table').hide();
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
                        url: '{{ route('getReportPatientsUtilizingIcd10CodesFetch') }}',
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
                                $('#report_patients_utilizing_icd10_codes_table').show();
                                $('#setText').hide();
                                $('#setCount').hide();
                                $("#fetch-report-patients-utilizing-icd10-codes").html(response);
                                $("#table-fetch-report-patients-utilizing-icd10-codes").DataTable({
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
                                    ]
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อที่มี ICD 10 ตามวัน-เดือน-ปี ที่เลือกเอง End

        });
    </script>
@endsection
