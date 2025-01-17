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
                                        <option value="2">ICD10 แบบอย่างเดียวหรือหลายๆรายการ</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <form id="selectIcd10NotForm" class="me-3">
                            @csrf
                            <div class="mb-3 d-flex align-items-center row">
                                <div class="col">
                                    <span class="w-100">เงื่อนไขของ ICD10 ที่ไม่ต้องการ</span>
                                    <select class="form-select" id="selectIcd10Not" aria-label="Default select example">
                                        <option selected value="0">----------</option>
                                        <option value="1">ICD10 แบบอย่างเดียวหรือหลายๆรายการ</option>
                                    </select>
                                </div>
                            </div>
                        </form>
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
                <form id="yearForm"> {{-- ปีงบประมาณ --}}
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
                        <div class="col-2 pe-5 yearIcd10_2" id="yearIcd10_2">
                            <span>เลือก ICD10 ที่ต้องการ</span>
                            <div class="d-flex">
                                <select class="form-select" id="yearIcd10In" name="yearIcd10In[]" aria-label="Default select example"></select>
                                <button type="button" id="addButtonYearIcd10_2" class="btn btn-primary ms-2">+</button>
                            </div>
                        </div>
                        <div class="col-2 pe-5 yearIcd10Not_1" id="yearIcd10Not_1">
                            <span>เลือก ICD10 ที่ไม่ต้องการ</span>
                            <div class="d-flex">
                                <select class="form-select" id="yearIcd10NotIn" name="yearIcd10NotIn[]" aria-label="Default select example"></select>
                                <button type="button" id="addButtonYearIcd10Not_1" class="btn btn-primary ms-2">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-2 d-flex align-items-center mt-4">
                            <button type="button" id="submitYear" class="btn btn-primary zoom-card">ค้นหาข้อมูล</button>
                        </div>
                    </div>
                </form>
                <form id="dateSelectForm"> {{-- กำหนดเอง --}}
                    @csrf
                    <div class="mb-2 row">
                        <div class="col-2">
                            <span class="">วันที่เริ่มต้น</span>
                            <input type="date" class="form-control" id="min_date" name="min_date" placeholder="min_date">
                        </div>
                        <div class="col-2">
                            <span class="">วันที่สิ้นสุด</span>
                            <input type="date" class="form-control" id="max_date" name="max_date" placeholder="max_date">
                        </div>
                        <div class="col-2 dateSelectIcd10_1">
                            <span>เลือก ICD10 ตัวตั้งต้น</span>
                            <select class="form-select" id="dateSelectIcd10Min" name="dateSelectIcd10Min" aria-label="Default select example"></select>
                        </div>
                        <div class="col-2 dateSelectIcd10_1">
                            <span>เลือก ICD10 ตัวสิ้นสุด</span>
                            <select class="form-select" id="dateSelectIcd10Max" name="dateSelectIcd10Max" aria-label="Default select example"></select>
                        </div>
                        <div class="col-2 dateSelectIcd10_2" id="dateSelectIcd10_2">
                            <span>เลือก ICD10 ที่ต้องการ</span>
                            <div class="d-flex">
                                <select class="form-select" id="dateSelectIcd10In" name="dateSelectIcd10In[]" aria-label="Default select example"></select>
                                <button type="button" id="addButtonDateSelectIcd10_2" class="btn btn-primary ms-2">+</button>
                            </div>
                        </div>
                        <div class="col-2 pe-5 dateSelectIcd10Not_1" id="dateSelectIcd10Not_1">
                            <span>เลือก ICD10 ที่ไม่ต้องการ</span>
                            <div class="d-flex">
                                <select class="form-select" id="dateSelectIcd10NotIn" name="dateSelectIcd10NotIn[]" aria-label="Default select example"></select>
                                <button type="button" id="addButtonDateSelectIcd10Not_1" class="btn btn-primary ms-2">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-2 d-flex align-items-center mt-4">
                            <button type="button" id="submitAll" class="btn btn-primary zoom-card">ค้นหาข้อมูล</button>
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
                    
                    // Form( ปีงบประมาณ ) => Form( เงื่อนไขของ ICD10 ที่ต้องการ ) => Select เลือก ICD10 ตัวตั้งต้น Start
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
                    // Form( ปีงบประมาณ ) => Form( เงื่อนไขของ ICD10 ที่ต้องการ ) => Select เลือก ICD10 ตัวตั้งต้น End

                    // Form( ปีงบประมาณ ) => Form( เงื่อนไขของ ICD10 ที่ต้องการ ) => Select เลือก ICD10 ตัวสิ้นสุด Start
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
                    // Form( ปีงบประมาณ ) => Form( เงื่อนไขของ ICD10 ที่ต้องการ ) => Select เลือก ICD10 ตัวสิ้นสุด End

                    // Form( กำหนดเอง ) => Form( เงื่อนไขของ ICD10 ที่ต้องการ ) => Select เลือก ICD10 ตัวตั้งต้น Start
                        $('#dateSelectIcd10Min').select2({
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
                    // Form( กำหนดเอง ) => Form( เงื่อนไขของ ICD10 ที่ต้องการ ) => Select เลือก ICD10 ตัวตั้งต้น End

                    // Form( กำหนดเอง ) => Form( เงื่อนไขของ ICD10 ที่ต้องการ ) => Select เลือก ICD10 ตัวสิ้นสุด Start
                        $('#dateSelectIcd10Max').select2({
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
                    // Form( กำหนดเอง ) => Form( เงื่อนไขของ ICD10 ที่ต้องการ ) => Select เลือก ICD10 ตัวสิ้นสุด End

                    // In( สร้างหลาย Select ) Start
                        // Form( ปีงบประมาณ ) Start
                            // Form( เงื่อนไขของ ICD10 ที่ต้องการ ) Start
                                yearInitializeSelect2($('#yearIcd10In'));

                                $('#addButtonYearIcd10_2').click(function() {
                                    var newSelect = $('<select class="form-select yearIcd10-select" aria-label="Default select example" name="yearIcd10In[]"></select>');
                                    var removeButton = $('<button type="button" class="btn btn-danger ms-2">-</button>');  // สร้างปุ่มลบ
                                    var newDiv = $('<div class="d-flex align-items-center mb-2 mt-2 icd10-input-group"></div>');  // เพิ่ม div ใหม่และใช้ class d-flex เพื่อการจัดวางที่ดีขึ้น
                                    
                                    newDiv.append(newSelect);
                                    newDiv.append(removeButton);  // เพิ่มปุ่มลบไปที่ div
                                    $('#yearIcd10_2').append(newDiv);  // เพิ่มใน div ที่มี ID yearIcd10_3

                                    yearInitializeSelect2(newSelect);

                                    // จัดการเหตุการณ์คลิกสำหรับปุ่มลบ
                                    removeButton.click(function() {
                                        // newSelect.select2('destroy');
                                        $(this).parent().remove();  // ลบ div ที่มี select และปุ่มลบ
                                    });
                                });

                                function yearInitializeSelect2(selectElement) {
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
                            // Form( เงื่อนไขของ ICD10 ที่ต้องการ ) End
                            
                            // Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ ) Start
                                yearNotInitializeSelect2($('#yearIcd10NotIn'));

                                $('#addButtonYearIcd10Not_1').click(function() {
                                    var newSelect = $('<select class="form-select yearIcd10Not-select" aria-label="Default select example" name="yearIcd10NotIn[]"></select>');
                                    var removeButton = $('<button type="button" class="btn btn-danger ms-2">-</button>');  // สร้างปุ่มลบ
                                    var newDiv = $('<div class="d-flex align-items-center mb-2 mt-2 icd10-input-group"></div>');  // เพิ่ม div ใหม่และใช้ class d-flex เพื่อการจัดวางที่ดีขึ้น
                                    
                                    newDiv.append(newSelect);
                                    newDiv.append(removeButton);  // เพิ่มปุ่มลบไปที่ div
                                    $('#yearIcd10Not_1').append(newDiv);  // เพิ่มใน div ที่มี ID yearIcd10_3

                                    yearNotInitializeSelect2(newSelect);

                                    // จัดการเหตุการณ์คลิกสำหรับปุ่มลบ
                                    removeButton.click(function() {
                                        $(this).parent().remove();  // ลบ div ที่มี select และปุ่มลบ
                                    });
                                });

                                function yearNotInitializeSelect2(selectElement) {
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
                            // Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ ) End
                        // Form( ปีงบประมาณ ) End

                        // Form( กำหนดเอง ) Start
                            // Form( เงื่อนไขของ ICD10 ที่ต้องการ ) Start
                                dateSelectInitializeSelect2($('#dateSelectIcd10In'));

                                $('#addButtonDateSelectIcd10_2').click(function() {
                                    var newSelect = $('<select class="form-select dateSelectIcd10-select" aria-label="Default select example" name="dateSelectIcd10In[]"></select>');
                                    var removeButton = $('<button type="button" class="btn btn-danger ms-2">-</button>');  // สร้างปุ่มลบ
                                    var newDiv = $('<div class="d-flex align-items-center mb-2 mt-2"></div>');  // เพิ่ม div ใหม่และใช้ class d-flex เพื่อการจัดวางที่ดีขึ้น
                                    
                                    newDiv.append(newSelect);
                                    newDiv.append(removeButton);  // เพิ่มปุ่มลบไปที่ div
                                    $('#dateSelectIcd10_2').append(newDiv);  // เพิ่มใน div ที่มี ID dateSelectIcd10_2

                                    dateSelectInitializeSelect2(newSelect);

                                    // จัดการเหตุการณ์คลิกสำหรับปุ่มลบ
                                    removeButton.click(function() {
                                        // newSelect.select2('destroy');
                                        $(this).parent().remove();  // ลบ div ที่มี select และปุ่มลบ
                                    });
                                });

                                function dateSelectInitializeSelect2(selectElement) {
                                    selectElement.select2({
                                        placeholder: 'ค้นหา ICD 10',
                                        allowClear: true,
                                        dropdownParent: $('#dateSelectForm'),  // เปลี่ยนจาก icd10_main เป็น dateSelectForm เพื่อความชัดเจนในการจัดวาง
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
                            // Form( เงื่อนไขของ ICD10 ที่ต้องการ ) End
                            
                            // Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ ) Start
                                dateSelectNotInitializeSelect2($('#dateSelectIcd10NotIn'));

                                $('#addButtonDateSelectIcd10Not_2').click(function() {
                                    var newSelect = $('<select class="form-select dateSelectIcd10Not-select" aria-label="Default select example" name="dateSelectIcd10NotIn[]"></select>');
                                    var removeButton = $('<button type="button" class="btn btn-danger ms-2">-</button>');  // สร้างปุ่มลบ
                                    var newDiv = $('<div class="d-flex align-items-center mb-2 mt-2"></div>');  // เพิ่ม div ใหม่และใช้ class d-flex เพื่อการจัดวางที่ดีขึ้น
                                    
                                    newDiv.append(newSelect);
                                    newDiv.append(removeButton);  // เพิ่มปุ่มลบไปที่ div
                                    $('#dateSelectIcd10Not_2').append(newDiv);  // เพิ่มใน div ที่มี ID dateSelectIcd10_2

                                    dateSelectNotInitializeSelect2(newSelect);

                                    // จัดการเหตุการณ์คลิกสำหรับปุ่มลบ
                                    removeButton.click(function() {
                                        // newSelect.select2('destroy');
                                        $(this).parent().remove();  // ลบ div ที่มี select และปุ่มลบ
                                    });
                                });

                                function dateSelectNotInitializeSelect2(selectElement) {
                                    selectElement.select2({
                                        placeholder: 'ค้นหา ICD 10',
                                        allowClear: true,
                                        dropdownParent: $('#dateSelectForm'),  // เปลี่ยนจาก icd10_main เป็น dateSelectForm เพื่อความชัดเจนในการจัดวาง
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
                            // Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ ) End
                        // Form( กำหนดเอง ) End
                    // In( สร้างหลาย Select ) End

                // ICD 10 End
            // Select2 Query End

            // เริ่มต้น Hide Start
                hideAll(); // เรียกใช้งาน Function hideAll เพื่อปิดการมองเห็นของทุก Form ที่มีการกำหนดไว้

                function hideAll() {
                    $('#year_select').hide(); // ปิดการมองเห็น Card ที่มี ID : year_select
                    $('#report_patients_utilizing_icd10_codes_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML

                    $('#selectIcd10Form').hide(); // ปิดการมองเห็น Form( เงื่อนไขของ ICD10 ที่ต้องการ )
                    $('#yearForm').hide(); // ปิดการมองเห็น Form ของปีงบประมาณ
                    $('.yearIcd10_1').hide(); // ปิดการมองเห็น Input ของ Form( ปีงบประมาณ ในส่วนของ( เงื่อนไขของ ICD10 ที่ต้องการ => ICD10 แบบกำหนดตั้งต้นและสิ้นสุด ) )
                    $('.yearIcd10_2').hide(); // ปิดการมองเห็น Input ของ Form( ปีงบประมาณ ในส่วนของ( เงื่อนไขของ ICD10 ที่ต้องการ => ICD10 แบบอย่างเดียวหรือหลายๆรายการ ) )

                    $('#selectIcd10NotForm').hide(); // ปิดการมองเห็น Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ )
                    $('.yearIcd10Not_1').hide(); // ปิดการมองเห็น Input ของ Form( ปีงบประมาณ ในส่วนของ( เงื่อนไขของ ICD10 ที่ไม่ต้องการ => ICD10 แบบอย่างเดียวหรือหลายๆรายการ ) )
                    
                    $('#dateSelectForm').hide(); // ปิดการมองเห็น Form( กำหนดเอง ) 
                    $('.dateSelectIcd10_1').hide(); // ปิดการมองเห็น Input ของ Form( กำหนดเอง ในส่วนของ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด ) )
                    $('.dateSelectIcd10_2').hide(); // ปิดการมองเห็น Input ของ Form( ปีงบประมาณ ในส่วนของ( ICD10 แบบอย่างเดียวหรือหลายๆรายการ ) )

                    $('.dateSelectIcd10Not_1').hide(); // ปิดการมองเห็น Input ของ Form( ปีงบประมาณ ในส่วนของ( เงื่อนไขของ ICD10 ที่ไม่ต้องการ => ICD10 แบบอย่างเดียวหรือหลายๆรายการ ) )
                    
                }
            // เริ่มต้น Hide End

            // Function Reset Form All Start
                function resetFormAll() {
                    $('#selectIcd10Form')[0].reset(); // Reset Form( เงื่อนไขของ ICD10 ที่ต้องการ ) 
                    $('#yearForm')[0].reset(); // Reset Form ของปีงบประมาณ
                    $('#dateSelectForm')[0].reset(); // Reset Form( กำหนดเอง ) 
                }
            // Function Reset Form All End

            // Function Reset Select 2( ล้าง Data ทั้ง Form ของ Select 2 ) Start
                    function resetSelect2Icd10All() {
                        $('#yearIcd10Min').val(null).trigger('change'); // กำหนดค่า Value ของ Select 2 ของ Form( ปีงบประมาณ ในส่วนของ( Input( เลือก ICD10 ตัวตั้งต้น ) ) ) ให้เป็นค่าว่างเมื่อมีการเปลี่ยนแปลง Input
                        $('#yearIcd10Max').val(null).trigger('change'); // กำหนดค่า Value ของ Select 2 ของ Form( ปีงบประมาณ ในส่วนของ( Input( เลือก ICD10 ตัวสิ้นสุด ) ) ) ให้เป็นค่าว่างเมื่อมีการเปลี่ยนแปลง Input
                        $('#yearIcd10In').val(null).trigger('change'); // กำหนดค่า Value ของ Select 2 ของ Form( ปีงบประมาณ ในส่วนของ( Input( เลือก ICD10 ที่ต้องการ ) ) ) ให้เป็นค่าว่างเมื่อมีการเปลี่ยนแปลง Input
                        $('.yearIcd10-select').each(function() {
                            $(this).val(null).trigger('change');
                            $(this).parent().remove();
                        });

                        $('#dateSelectIcdMin').val(null).trigger('change'); // กำหนดค่า Value ของ Select 2 ของ Form( ปีงบประมาณ ในส่วนของ( Input( เลือก ICD10 ตัวตั้งต้น ) ) ) ให้เป็นค่าว่างเมื่อมีการเปลี่ยนแปลง Input
                        $('#dateSelectIcdMax').val(null).trigger('change'); // กำหนดค่า Value ของ Select 2 ของ Form( ปีงบประมาณ ในส่วนของ( Input( เลือก ICD10 ตัวสิ้นสุด ) ) ) ให้เป็นค่าว่างเมื่อมีการเปลี่ยนแปลง Input
                        $('#dateSelectIcdIn').val(null).trigger('change'); // กำหนดค่า Value ของ Select 2 ของ Form( ปีงบประมาณ ในส่วนของ( Input( เลือก ICD10 ที่ต้องการ ) ) ) ให้เป็นค่าว่างเมื่อมีการเปลี่ยนแปลง Input
                        $('.dateSelectIcd-select').each(function() {
                            $(this).val(null).trigger('change');
                            $(this).parent().remove();
                        });
                    }
                    
                    function resetSelect2Icd10NotAll() {
                        $('#yearIcd10NotIn').val(null).trigger('change'); // กำหนดค่า Value ของ Select 2 ของ Form( ปีงบประมาณ ในส่วนของ( Input( เลือก ICD10 ที่ต้องการ ) ) ) ให้เป็นค่าว่างเมื่อมีการเปลี่ยนแปลง Input
                        $('.yearIcd10Not-select').each(function() {
                            $(this).val(null).trigger('change');
                            $(this).parent().remove();
                        });

                        $('#dateSelectIcd10NotIn').val(null).trigger('change'); // กำหนดค่า Value ของ Select 2 ของ Form( ปีงบประมาณ ในส่วนของ( Input( เลือก ICD10 ที่ต้องการ ) ) ) ให้เป็นค่าว่างเมื่อมีการเปลี่ยนแปลง Input
                        $('.dateSelectIcd10Not-select').each(function() {
                            $(this).val(null).trigger('change');
                            $(this).parent().remove();
                        });
                    }
            // Function  Select 2( ล้าง Data ทั้ง Form ของ Select 2 ) End

            // ตัวจัดการพวกเงื่อนไข Reset ต่างๆ Start
                $('#select').on('change', function() {
                    var selectForm = $('#select').val(); // ดึง Value จาก ID select
                    if (selectForm != '0' && selectForm == '1') { // 1 = Year
                        // เงื่อนไขของ ICD10 ที่ต้องการ Start
                            // Reset Form อีกครั้งก่อนที่จะ Show Form ใหม่อีกรอบเพื่อคืนค่า 
                                $('#selectIcd10Form')[0].reset(); // Reset Form( เงื่อนไขของ ICD10 ที่ต้องการ )
                                $('#selectIcd10Form').show(); // Show Form( เงื่อนไขของ ICD10 ที่ต้องการ )
                                $('#selectIcd10NotForm')[0].reset(); // Reset Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ )
                                $('#selectIcd10NotForm').show(); // Show Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ )

                            // ปิดการมองเห็นของ Input( ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด ), กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด ) ) 
                                $('.yearIcd10_1').hide(); // ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                $('.yearIcd10Not_1').hide(); // ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                $('#dateSelectIcd10_1').hide(); // กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                            
                            // เมื่อมีการคลิกที่ปุ่มเลือก( เงื่อนไขของ ICD10 ที่ต้องการ( อ้างอิงจาก ID : selectIcd10Form ) )
                                $('#selectIcd10Form').on('change', function() {
                                    var selectIcd10Form = $('#selectIcd10').val(); // ดึง Value จาก ID selectIcd10

                                    if (selectIcd10Form != '0' && selectIcd10Form == '1' && selectForm != '0' && selectForm == '1') { // selectForm( 1 ) = ปีงบประมาณ | selectIcd10Form( 1 ) = ICD10 แบบกำหนดตั้งต้นและสิ้นสุด
                                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                                        $('.yearIcd10_1').show(); // แสดง Input ของ ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                        $('.yearIcd10_2').hide(); // ปิดการมองเห็น Input ของ ปีงบประมาณ( ICD10 แบบอย่างเดียวหรือหลายๆรายการ )
                                    } else if(selectIcd10Form != '0' && selectIcd10Form == '2' && selectForm != '0' && selectForm == '1') { // selectForm( 1 ) = ปีงบประมาณ | selectIcd10Form( 2 ) = ICD10 แบบอย่างเดียวหรือหลายๆรายการ
                                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset ICD10 Select 2 ทั้งหมด
                                        $('.yearIcd10_1').hide(); // ปิดการมองเห็น Input ของ ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                        $('.yearIcd10_2').show(); // แสดง Input ของ ปีงบประมาณ( ICD10 แบบอย่างเดียวหรือหลายๆรายการ )
                                    } else {
                                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset ICD10 Select 2 ทั้งหมด
                                        $('.yearIcd10_1').hide(); // ปิดการมองเห็น Input ของ ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                        $('.yearIcd10_2').hide(); // ปิดการมองเห็น Input ของ ปีงบประมาณ( ICD10 แบบอย่างเดียวหรือหลายๆรายการ )
                                        $('#report_patients_utilizing_icd10_codes_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                                    }
                                });
                            
                            // เมื่อมีการคลิกที่ปุ่มเลือก( เงื่อนไขของ ICD10 ที่ต้องการ( อ้างอิงจาก ID : selectIcd10NotForm ) )
                                $('#selectIcd10NotForm').on('change', function() {
                                    var selectIcd10NotForm = $('#selectIcd10Not').val(); // ดึง Value จาก ID selectIcd10

                                    if (selectIcd10NotForm != '0' && selectIcd10NotForm == '1' && selectForm != '0' && selectForm == '1') { // selectForm( 1 ) = ปีงบประมาณ | selectIcd10NotForm( 1 ) = ICD10 แบบกำหนดตั้งต้นและสิ้นสุด
                                        resetSelect2Icd10NotAll(); // เรียกใช้งาน Function Reset ICD10 Not Select 2 ทั้งหมด
                                        $('.yearIcd10Not_1').show(); // แสดง Input ของ ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                    } else {
                                        resetSelect2Icd10NotAll(); // เรียกใช้งาน Function Reset ICD10 Not Select 2 ทั้งหมด
                                        $('.yearIcd10Not_1').hide(); // ปิดการมองเห็น Input ของ ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                        $('#report_patients_utilizing_icd10_codes_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                                    }
                                });
                        // เงื่อนไขของ ICD10 ที่ต้องการ End

                        $('#year_select').show(); // แสดง Card ที่มี ID : year_select
                        $('#yearForm').show(); // แสดง Form( ปีงบประมาณ )
                        $('#dateSelectForm').hide(); // ปิดการมองเห็น Form( กำหนดเอง ) 
                        $('#dateSelectForm')[0].reset(); // Reset Form( กำหนดเอง ) ทั้งหมด
                        $('#report_patients_utilizing_icd10_codes_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                    } else if (selectForm != '0' && selectForm == '2') { // 2 = กำหนดเอง
                        // ตัวเลือกรายการ ICD10 Start
                            $('#selectIcd10Form').show(); // Show Form( เงื่อนไขของ ICD10 ที่ต้องการ )
                            $('#selectIcd10Form')[0].reset(); // Reset Form( เงื่อนไขของ ICD10 ที่ต้องการ )
                            $('#selectIcd10NotForm').show(); // Show Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ )
                            $('#selectIcd10NotForm')[0].reset(); // Reset Form( เงื่อนไขของ ICD10 ที่ไม่ต้องการ )

                            // ปิดการมองเห็นของ Input( ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด ), กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด ) ) 
                                $('.yearIcd10_1').hide(); // ปีงบประมาณ( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                $('#dateSelectIcd10_1').hide(); // กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )

                            // เมื่อมีการคลิกที่ปุ่มเลือก( เงื่อนไขของ ICD10 ที่ต้องการ( อ้างอิงจาก ID : selectIcd10Form ) )
                                $('#selectIcd10Form').on('change', function() {
                                    var dateSelectIcd10_1 = $('#selectIcd10').val(); // ดึง Value จาก ID selectIcd10

                                    if (dateSelectIcd10_1 != '0' && dateSelectIcd10_1 == '1' && selectForm != '0' && selectForm == '2') { // selectForm( 1 ) = กำหนดเอง | selectIcd10Form( 1 ) = ICD10 แบบกำหนดตั้งต้นและสิ้นสุด
                                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                                        $('.dateSelectIcd10_1').show(); // แสดง Input ของ กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                        $('.dateSelectIcd10_2').hide(); // ปิดการมองเห็น Input ของ กำหนดเอง( ICD10 แบบอย่างเดียวหรือหลายๆรายการ )
                                    } else if(dateSelectIcd10_1 != '0' && dateSelectIcd10_1 == '2' && selectForm != '0' && selectForm == '2') { // selectForm( 1 ) = กำหนดเอง | selectIcd10Form( 2 ) = ICD10 แบบอย่างเดียวหรือหลายๆรายการ
                                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                                        $('.dateSelectIcd10_1').hide(); // ปิดการมองเห็น Input ของ กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                        $('.dateSelectIcd10_2').show(); // แสดง Input ของ กำหนดเอง( ICD10 แบบอย่างเดียวหรือหลายๆรายการ )
                                    } else {
                                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                                        $('.dateSelectIcd10_1').hide(); // ปิดการมองเห็น Input ของ กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                        $('.dateSelectIcd10_2').hide(); // ปิดการมองเห็น Input ของ กำหนดเอง( ICD10 แบบอย่างเดียวหรือหลายๆรายการ )
                                        $('#report_patients_utilizing_icd10_codes_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                                    }
                                });
                            
                            // เมื่อมีการคลิกที่ปุ่มเลือก( เงื่อนไขของ ICD10 ที่ไม่ต้องการ( อ้างอิงจาก ID : selectIcd10NotForm ) )
                                $('#selectIcd10NotForm').on('change', function() {
                                    var dateSelectIcd10Not_1 = $('#selectIcd10Not').val(); // ดึง Value จาก ID selectIcd10

                                    if (dateSelectIcd10Not_1 != '0' && dateSelectIcd10Not_1 == '1' && selectForm != '0' && selectForm == '2') { // selectForm( 1 ) = กำหนดเอง | dateSelectIcd10Not_1( 1 ) = ICD10 แบบกำหนดตั้งต้นและสิ้นสุด
                                        resetSelect2Icd10NotAll(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                                        $('.dateSelectIcd10Not_1').show(); // แสดง Input ของ กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                    } else {
                                        resetSelect2Icd10NotAll(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                                        $('.dateSelectIcd10Not_1').hide(); // ปิดการมองเห็น Input ของ กำหนดเอง( ICD10 แบบกำหนดตั้งต้นและสิ้นสุด )
                                        $('#report_patients_utilizing_icd10_codes_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                                    }
                                });
                        // ตัวเลือกรายการ ICD10 End

                        $('#year_select').show(); // แสดง Card ที่มี ID : year_select
                        $('#dateSelectForm').show(); // แสดง Form( กำหนดเอง )
                        $('#yearForm').hide(); // ปิดการมองเห็น Form( ปีงบประมาณ ) 
                        $('#yearForm')[0].reset(); // Reset Form( ปีงบประมาณ ) 
                        $('#report_patients_utilizing_icd10_codes_table').hide(); // ปิดการมองเห็นของ Card ที่เก็บ Table ที่ดึงข้อมูลมาแสดงบนหน้า HTML
                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                    } else {
                        hideAll(); // เรียกใช้งาน Function Hide All ของ Form และ Input ต่างๆ
                        resetSelect2Icd10All(); // เรียกใช้งาน Function Reset Select 2 ทั้งหมด
                        resetFormAll(); // เรียกใช้งาน Function Reset Form ทั้งหมด
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
                                    ],
                                    "scrollX": true
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
                                    ],
                                    "scrollX": true
                                });
                            }
                        }
                    });
                });
            // ดึงข้อมูลรายชื่อที่มี ICD 10 ตามวัน-เดือน-ปี ที่เลือกเอง End

        });
    </script>
@endsection
