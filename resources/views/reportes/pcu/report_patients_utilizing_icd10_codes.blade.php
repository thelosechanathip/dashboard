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
                                    <span class="w-100">เงื่อนไข</span>
                                    <select class="form-select" id="select" aria-label="Default select example">
                                        <option selected value="0">----------</option>
                                        <option value="1">ปีงบประมาณ</option>
                                        <option value="2">กำหนดเอง</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <form id="selectIcd10Form" class="me-3">
                            @csrf
                            <div class="mb-3 d-flex align-items-center row">
                                <div class="col">
                                    <span class="w-100">เงื่อนไขของ ICD10 ที่ต้องการ</span>
                                    <select class="form-select" id="selectIcd10" aria-label="Default select example">
                                        <option selected value="0">----------</option>
                                        <option value="1">ICD10 แบบกำหนดตั้งต้นและสิ้นสุด</option>
                                        <option value="2">ICD10 หลายๆรายการ</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        {{-- <form id="selectNotIcd10Form" class="me-3">
                            @csrf
                            <div class="mb-3 d-flex align-items-center row">
                                <div class="col">
                                    <span class="w-100">เงื่อนไขของ ICD10 ที่ไม่ต้องการ</span>
                                    <select class="form-select" id="selectNotIcd10" aria-label="Default select example">
                                        <option selected value="0">----------</option>
                                        <option value="1">ICD10 แบบกำหนดตั้งต้นและสิ้นสุด</option>
                                        <option value="2">ICD10 หลายๆรายการ</option>
                                    </select>
                                </div>
                            </div>
                        </form> --}}
                        {{-- <form id="selectPttypeForm" class="me-3">
                            @csrf
                            <div class="mb-3 d-flex align-items-center row">
                                <div class="col">
                                    <span class="w-100">เงื่อนไขของสิทธิ์การรักษา</span>
                                    <select class="form-select" id="selectPttype" aria-label="Default select example">
                                        <option selected value="0">----------</option>
                                        <option value="1">สิทธิ์การรักษา รายการเดียว</option>
                                    </select>
                                </div>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
            <div id="year_select" class="mt-3 card shadow-lg full-width-bar p-3" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <form id="yearForm">
                    @csrf
                    <div class="mb-2 row">
                        <div class="col-2">
                            <span>เลือกปีงบ</span>
                            <select class="form-select" id="yearSelect" name="yearSelect" aria-label="Default select example">
                                <option selected value="0">----------</option>
                                @foreach($fiscal_year AS $fy)
                                    <option value="{{ $fy->fiscal_year_name }}">ปีงบ {{ $fy->fiscal_year_name + 543 }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 yearIcd10_1">
                            <span>เลือก ICD10 ตัวตั้งต้น</span>
                            <select class="form-select" id="yearIcd10Min" name="yearIcd10Min" aria-label="Default select example"></select>
                        </div>
                        <div class="col-2 yearIcd10_1">
                            <span>เลือก ICD10 ตัวสิ้นสุด</span>
                            <select class="form-select" id="yearIcd10Max" name="yearIcd10Max" aria-label="Default select example"></select>
                        </div>
                        <div class="col-2 yearIcd10_2" id="yearIcd10_2">
                            <span>เลือก ICD10 ที่ต้องการ</span>
                            <div class="d-flex">
                                <select class="form-select" id="yearIcd10In" name="yearIcd10In[]" aria-label="Default select example"></select>
                                <button type="button" id="addButtonYearIcd10_2" class="btn btn-primary ms-2">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-2 d-flex align-items-center mt-4">
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
                        <div class="col" id="dateSelectIcd10_1">
                            <span>เลือก ICD10</span>
                            <select class="form-select" id="dateSelectIcd10" name="dateSelectIcd10" aria-label="Default select example"></select>
                        </div>
                        <div class="col-2 dateSelectIcd10_2">
                            <span>เลือก ICD10 ตัวตั้งต้น</span>
                            <select class="form-select" id="dateSelectIcdMin" name="dateSelectIcdMin" aria-label="Default select example"></select>
                        </div>
                        <div class="col-2 dateSelectIcd10_2">
                            <span>เลือก ICD10 ตัวสิ้นสุด</span>
                            <select class="form-select" id="dateSelectIcdMax" name="dateSelectIcdMax" aria-label="Default select example"></select>
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
                    $('#yearIcd10Min').select2({
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

                    $('#yearIcd10Max').select2({
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

                    $('#dateSelectIcdMin').select2({
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

                    $('#dateSelectIcdMax').select2({
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

                    // In( สร้างหลาย Select ) Start
                        initializeSelect2($('#yearIcd10In'));

                        $('#addButtonYearIcd10_2').click(function() {
                            var newSelect = $('<select class="form-select yearIcd10-select" aria-label="Default select example" name="yearIcd10In[]"></select>');
                            var removeButton = $('<button type="button" class="btn btn-danger ms-2">-</button>');  // สร้างปุ่มลบ
                            var newDiv = $('<div class="d-flex align-items-center mb-2 mt-2"></div>');  // เพิ่ม div ใหม่และใช้ class d-flex เพื่อการจัดวางที่ดีขึ้น
                            
                            newDiv.append(newSelect);
                            newDiv.append(removeButton);  // เพิ่มปุ่มลบไปที่ div
                            $('#yearIcd10_2').append(newDiv);  // เพิ่มใน div ที่มี ID yearIcd10_3

                            initializeSelect2(newSelect);

                            // จัดการเหตุการณ์คลิกสำหรับปุ่มลบ
                            removeButton.click(function() {
                                // newSelect.select2('destroy');
                                $(this).parent().remove();  // ลบ div ที่มี select และปุ่มลบ
                            });
                        });

                        function initializeSelect2(selectElement) {
                            selectElement.select2({
                                placeholder: 'ค้นหา ICD 10',
                                allowClear: true,
                                dropdownParent: $('#yearForm'),  // เปลี่ยนจาก icd10_main เป็น yearForm เพื่อความชัดเจนในการจัดวาง
                                ajax: {
                                    url: '{{ route('query_icd10') }}',
                                    dataType: 'json',
                                    delay: 250,
                                    data: function (params) {
                                        return {
                                            searchTerm: params.term
                                        };
                                    },
                                    processResults: function (data) {
                                        return {
                                            results: data.results.map(function(item) {
                                                return { id: item.id, text: item.id + ' : ' + item.text };
                                            })
                                        };
                                    },
                                    cache: true
                                },
                                minimumInputLength: 1
                            });
                        }
                    // In( สร้างหลาย Select ) End

                // ICD 10 End
            // Select2 Query End

            // เริ่มต้น Hide Start
                hideAll();

                function hideAll() {
                    // Table( ตาราง ) ในการแสดงข้อมูลที่ได้มาจาก Database Start
                        $('#report_patients_utilizing_icd10_codes_table').hide();
                    // Table( ตาราง ) ในการแสดงข้อมูลที่ได้มาจาก Database End

                    // Form ของปีงบประมาณ Start
                        $('#yearForm').hide();
                    // Form ของปีงบประมาณ End
                    
                    // Select ปีงบประมาณ Start
                        $('#year_select').hide();
                    // Select ปีงบประมาณ End
                    
                    // Form สำหรับจัดการเองเกี่ยวกับวันที่ต้องการหาข้อมูล Start
                        $('#dateSelectForm').hide();
                    // Form สำหรับจัดการเองเกี่ยวกับวันที่ต้องการหาข้อมูล End

                    // Form เงื่อนไขของ ICD10 ที่ต้องการ Start
                        $('#selectIcd10Form').hide();
                    // Form เงื่อนไขของ ICD10 ที่ต้องการ End

                    // Class ICD10 แบบกำหนดตั้งต้นและสิ้นสุด Start
                        $('.yearIcd10_1').hide();
                    // Class ICD10 แบบกำหนดตั้งต้นและสิ้นสุด End

                    // Class ICD10 แบบอย่างเดียวหรือหลายๆรายการ Start
                        $('.yearIcd10_2').hide();
                    // Class ICD10 แบบอย่างเดียวหรือหลายๆรายการ End                  

                    // Form เงื่อนไขของ Pttype( สิทธิ์การรักษา ) ที่ต้องการ Start
                        $('#selectPttypeForm').hide();
                    // Form เงื่อนไขของ Pttype( สิทธิ์การรักษา ) ที่ต้องการ End
                    
                    // Form เงื่อนไขของ ICD10 ที่ไม่ต้องการ Start
                        $('#selectNotIcd10Form').hide();
                    // Form เงื่อนไขของ ICD10 ที่ไม่ต้องการ End

                    $('#dateSelectIcd10_1').hide();
                    $('.dateSelectIcd10_2').hide();
                }
            // เริ่มต้น Hide End

            // Function Reset Form All Start
                function resetFormAll() {
                    $('#selectIcd10Form')[0].reset();
                    $('#selectNotIcd10Form')[0].reset();
                    $('#yearForm')[0].reset();
                    $('#dateSelectForm')[0].reset();
                }
            // Function Reset Form All End

            // Function Reset Select 2( ล้าง Data ทั้ง Form ของ Select 2 ) Start
                    function resetSelect2All() {
                        $('#yearIcd10Min').val(null).trigger('change');
                        $('#yearIcd10Max').val(null).trigger('change');
                        $('#dateSelectIcd10').val(null).trigger('change');
                        $('#yearIcd10In').val(null).trigger('change');
                        $('.yearIcd10-select').each(function() {
                            $(this).val(null).trigger('change');
                            $(this).parent().remove();
                        });
                    }
            // Function Reset Select 2( ล้าง Data ทั้ง Form ของ Select 2 ) End

            // ตัวจัดการพวกเงื่อนไขต่างๆ Start
                $('#select').on('change', function() {
                    var selectForm = $('#select').val();
                    if (selectForm != '0' && selectForm == '1') { // 1 = Year
                        // ตัวเลือกรายการ ICD10 Start
                            $('#selectIcd10Form').show();
                            $('#selectIcd10Form')[0].reset();
                            $('.yearIcd10_1').hide();
                            $('#dateSelectIcd10_1').hide();
                            $('#selectIcd10Form').on('change', function() {
                                var selectIcd10Form = $('#selectIcd10').val();

                                if (selectIcd10Form != '0' && selectIcd10Form == '1' && selectForm != '0' && selectForm == '1') {
                                    resetSelect2All();
                                    $('.yearIcd10_1').show();
                                    $('.yearIcd10_2').hide();
                                } else if(selectIcd10Form != '0' && selectIcd10Form == '2' && selectForm != '0' && selectForm == '1') {
                                    resetSelect2All();
                                    $('.yearIcd10_1').hide();
                                    $('.yearIcd10_2').show();
                                } else {
                                    resetSelect2All();
                                    $('.yearIcd10_1').hide();
                                    $('.yearIcd10_2').hide();
                                    $('#report_patients_utilizing_icd10_codes_table').hide();
                                }
                            });
                        // ตัวเลือกรายการ ICD10 End
                        $('#yearForm').show();
                        $('#year_select').show();
                        $('#dateSelectForm').hide();
                        $('#dateSelectForm')[0].reset();
                        $('#report_patients_utilizing_icd10_codes_table').hide();
                        $('#selectPttypeForm').show();
                        $('#selectNotIcd10Form').show();
                        resetSelect2All();
                    } else if (selectForm != '0' && selectForm == '2') { // 2 = กำหนดเอง
                        // ตัวเลือกรายการ ICD10 Start
                            $('#selectIcd10Form').show();
                            $('.yearIcd10_1').hide();
                            $('#selectIcd10Form')[0].reset();
                            $('#dateSelectIcd10_1').hide();

                            // เมื่อมีการเปลี่อนแปลงของ เงื่อนไขของ
                            $('#selectIcd10Form').on('change', function() {
                                var dateSelectIcd10_1 = $('#selectIcd10').val();

                                if (dateSelectIcd10_1 != '0' && dateSelectIcd10_1 == '1' && selectForm != '0' && selectForm == '2') {
                                    resetSelect2All();
                                    $('#dateSelectIcd10_1').show();
                                    $('.dateSelectIcd10_2').hide();
                                } else if(dateSelectIcd10_1 != '0' && dateSelectIcd10_1 == '2' && selectForm != '0' && selectForm == '2') {
                                    resetSelect2All();
                                    $('#dateSelectIcd10_1').hide();
                                    $('.dateSelectIcd10_2').show();
                                } else {
                                    resetSelect2All();
                                    resetFormAll();
                                }
                            });
                        // ตัวเลือกรายการ ICD10 End
                        $('#dateSelectForm').show();
                        $('#year_select').show();
                        $('#yearForm').hide();
                        $('#yearForm')[0].reset();
                        $('#report_patients_utilizing_icd10_codes_table').hide();
                        $('#selectPttypeForm').show();
                        resetSelect2All();
                    } else {
                        // เรียกใช้งาน Function Hide All ของ Form และ Input ต่างๆ Start
                            hideAll();
                        // เรียกใช้งาน Function Hide All ของ Form และ Input ต่างๆ End

                        // เรียกใช้งาน Funtion Reset Data ของ Select2 Start
                            resetSelect2All();
                        // เรียกใช้งาน Funtion Reset Data ของ Select2 End

                        // เรียกใช้งาน Function Reset Form ทั้งหมด Start
                            resetFormAll();
                        // เรียกใช้งาน Function Reset Form ทั้งหมด End
                    }
                });
            // ตัวจัดการพวกเงื่อนไขต่างๆ End

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
