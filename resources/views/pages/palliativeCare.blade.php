@extends('layout.dashboard_template')

@section('title')
    <title>Palliative Care</title>
@endsection

@section('content')
    <main class="main-content">
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก Start --}}
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom full-width-bar">
            <div class="">
                <h1 class="h2">Palliative Care</h1>
            </div>
            <div class="d-flex">
                <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                <p>&nbsp;&nbsp;&nbsp;</p>
                <p> <span class="fw-bold">แผนก :</span> {{ $data['groupname'] }}</p>
            </div>
        </div>
        {{-- Title แสดงข้อมูล ชื่อผู้ใช้งาน และ แผนก End --}}

        <div class="mt-2 d-flex justify-content-between align-items-center border-bottom full-width-bar">
            <div class="d-flex align-items-center">
                <form id="selectForm" class="me-3">
                    @csrf
                    <div class="mb-3 d-flex align-items-center">
                        <span class="w-100">รายการ</span>
                        <select class="form-select ms-2 me-2" id="select" aria-label="Default select example"
                            style="min-width: 210px;">
                            <option selected value="0">-------------------------</option>
                            <option value="1">ดูจำนวนผู้เสียชีวิต</option>
                            <option value="2">ดูรายชื่อ Palliative Care</option>
                        </select>
                        {{-- <button type="button" id="submitSelect" class="btn btn-primary">ยืนยัน</button> --}}
                    </div>
                </form>
            </div>
            <div class="">
                <p><span id="setText"></span><span id="setCount"></span></p>
            </div>
        </div>

        <div class="mt-3 d-flex align-item-center justify-content-start">
            {{-- Form ดึงจำนวนคนไข้ที่เสียชีวิต Palliative Care แยกตาม Diag Start --}}
            <form id="palliative_count_death_form">
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
                        <button type="button" id="palliative_count_death_submit" class="btn btn-primary ms-3">ยืนยัน</button>
                    </div>
                    <div class="spinner-border loadingIcon " style="" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </form>
            {{-- Form ดึงจำนวนคนไข้ที่เสียชีวิต Palliative Care แยกตาม Diag End --}}
            {{-- Form ดึงรายชื่อคนไข้ Palliative Care Start --}}
            <form id="palliative_list_name_form">
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
                    {{-- <div class="col d-flex align-items-center">
                        <div class="" style="min-width: 120px;">
                            <span class="" style="width: 100%;">เลือกหน่วยบริการ</span>
                        </div>
                        <select class="form-select ms-2" placeholder="เลือกหน่วยบริการ" id="service_unit" name="service_unit" aria-label="Default select example"
                            style="min-width: 200px;">
                            <option selected value="0">------------</option>
                            <option value="99999">ทั้งหมด</option>
                            <option value="00000">นอกเขตบริการ</option>
                            @foreach($zbm_rpst_name as $zrn)
                                <option value="{{ $zrn->rpst_id }}">{{ $zrn->rpst_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="" style="min-width: 80px;">
                            <span class="" style="width: 100%;">เลือกสถานะ</span>
                        </div>
                        <select class="form-select ms-2" placeholder="เลือกหน่วยบริการ" id="death_type" name="death_type" aria-label="Default select example"
                            style="min-width: 200px;">
                            <option selected value="0">------------</option>
                            <option value="99999">ทั้งหมด</option>
                            <option value="Y">เสียชีวิต</option>
                            <option value="N">ยังมีชีวิต</option>
                        </select>
                    </div> --}}
                    <div class="col d-flex align-items-center">
                        <button type="button" id="palliative_list_name_submit" class="btn btn-primary ms-3">ยืนยัน</button>
                    </div>
                    <div class="spinner-border loadingIcon " style="" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </form>
            {{-- Form ดึงรายชื่อคนไข้ Palliative Care End --}}
        </div>

        {{-- แสดงข้อมูลเสียชีวิต Palliative Care ตาม Diag แบบ Chart Start --}}
        <div class="mt-3 card shadow-lg w-auto" id="palliative_count_death_all_chart">
            <div class="row">
                <div class="col-12">
                    <div class="container">
                        <div class="mt-5">
                            <canvas id="palliative_my_chart" width="300" height="100"></canvas>
                        </div>
                        <div class="mb-5">
                            <div class="" id="fetch-list-name"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- แสดงข้อมูลเสียชีวิต Palliative Care ตาม Diag แบบ Chart End --}}
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#palliative_count_death_all_chart').hide();
            $('#palliative_count_death_form').hide();
            $('#palliative_list_name_form').hide();

            $('#select').change(function() {
                var selectForm = $('#select').val();
                if (selectForm != '0' && selectForm == '1') {
                    $('#palliative_count_death_form').show();
                    $('#palliative_list_name_form').hide();
                } else if (selectForm != '0' && selectForm == '2') {
                    $('#palliative_list_name_form').show();
                    $('#palliative_count_death_form').hide();
                } else {
                    $('#palliative_list_name_form').hide();
                    $('#palliative_count_death_form').hide();
                }
            });

            function showLoadingIcon() {
                $('.loadingIcon').show();
                $('#palliative_my_chart').hide();
                $('#palliative_count_death_all_chart').show();
                $('#table-not-authen-code').hide();
            }

            function hideLoadingIcon() {
                $('.loadingIcon').hide();
                $('#palliative_my_chart').show();
                $('#table-not-authen-code').show();
            }

            hideLoadingIcon();

            function setText(request) {
                if(request == 0) {
                    $('#setText').text('');
                    $('#setCount').text('ไม่มีคนไข้ Palliative Care');
                } else {
                    $('#setText').text('จำนวนคนไข้ Palliative Care ทั้งหมดที่เสียชีวิตแยกตาม Diag ทั้งหมด : ');
                    $('#setCount').text(request + ' ราย');
                }
            }

            // ตัวแปรเก็บ Chart Start
            var chart;
            // ตัวแปรเก็บ Chart End

            // ดึงข้อมูลเสียชีวิต Palliative Care ตาม Diag Start
            $('#palliative_count_death_submit').click(function(e) {
                e.preventDefault();
                var formData = $('#palliative_count_death_form').serialize();
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('getPalliativeCareSelectData') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        hideLoadingIcon();
                        var chart_count_death = response.chart_count_death;

                        if (chart) {
                            chart.destroy();
                        }

                        var ctx = document.getElementById('palliative_my_chart').getContext('2d');
                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: chart_count_death,
                            options: chart_count_death.options
                        });

                        var total = chart_count_death.datasets[0].data.reduce(function(sum, value) {
                            return sum + value;
                        }, 0).toLocaleString();

                        if(parseInt(total) == 0) {
                            setText(total);
                        } else {
                            setText(total);
                        }
                    }
                });
            });
            // ดึงข้อมูลเสียชีวิต Palliative Care ตาม Diag End

            $('#palliative_list_name_submit').click(function(e) {
                e.preventDefault();
                var formData = $('#palliative_list_name_form').serialize();
                showLoadingIcon();
                $.ajax({
                    url: '{{ route('getPalliativeCareFetchListName') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        hideLoadingIcon();
                        // console.log(response.message);  // เพิ่ม console.log เพื่อตรวจสอบการตอบกลับ
                        $("#fetch-list-name").html(response);
                        $("#table-fetch-list-name").DataTable({
                            responsive: true,
                            order: [0, 'desc']
                        });
                    }
                });
            });

        });
    </script>
@endsection
