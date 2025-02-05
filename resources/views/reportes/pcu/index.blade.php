@extends('layout.dashboard_template')

@section('title')
    <title>ระบบรวมรายงาน PCU</title>
@endsection

@section('content')
    <main class="main-content mb-5">
        {{-- Title Start --}}
            <div class="card shadow-lg full-width-bar" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="d-flex justify-content-between align-items-center p-2 px-3">
                    <div class="" >
                        <h1 class="h2">ระบบรวมรายงาน PCU</h1>
                    </div>
                    <div class="d-flex pt-3">
                        <p><span class="fw-bold">ชื่อผู้ใช้งาน :</span> {{ $data['name'] }} </p>
                        <p>&nbsp;&nbsp;&nbsp;</p>
                        <p> <span class="fw-bold">Group :</span> {{ $data['groupname'] }}</p>
                    </div>
                </div>
            </div>
        {{-- Title End --}}
        {{-- Content Start --}}
            <div class="mt-3 card shadow-lg" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                <div class="container p-2 mt-3">
                    {{-- <ul>
                        <li class="link_hover"><a href="{{ route('report_z237_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover" id="hover_text">รายงาน Z237</a></li>
                        <li class="link_hover"><a href="{{ route('report_z242_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover" id="hover_text">รายงาน Z242</a></li>
                        <li class="link_hover"><a href="{{ route('report_z251_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงาน Z251</a></li>
                        <li class="link_hover"><a href="{{ route('report_patients_utilizing_icd10_codes_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงานรายชื่อคนไข้ที่มารับบริการด้วย ICD10</a></li>
                        <li class="link_hover"><a href="{{ route('report_cxr_41003_41004_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงาน X-ray CXR 41003 & 41004</a></li>
                        <li class="link_hover"><a href="{{ route('report_mixed_building_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงาน Admit ตึกรวม</a></li>
                        <li class="link_hover"><a href="{{ route('report_monk_nun_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงานรายชื่อพระและแม่ชี</a></li>
                    </ul> --}}
                    <table id="table-fetch-list" class="table table-hover table-bordered table-striped align-middle dt-responsive nowrap">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: auto;">รายการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><a href="{{ route('report_z237_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover" id="hover_text">รายงาน Z237</a></td></tr>
                            <tr><td><a href="{{ route('report_z242_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover" id="hover_text">รายงาน Z242</a></td></tr>
                            <tr><td><a href="{{ route('report_z251_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงาน Z251</a></td></tr>
                            <tr><td><a href="{{ route('report_patients_utilizing_icd10_codes_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">( อยู่ในขั้นตอนการพัฒนา )รายงานรายชื่อคนไข้ที่มารับบริการด้วย ICD10 ที่เลือกเอง</a></td></tr>
                            <tr><td><a href="{{ route('report_choresterol_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงาน รายชื่อผู้ป่วยอายุ 45-70 ปี ที่ตรวจ Cholesterol โดยไม่รวม ICD10 (E70-E79, Z136) และไม่ใช้ Simvastatin, Atorvastatin</a></td></tr>
                            <tr><td><a href="{{ route('report_fbs_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายชื่อคนไข้ตรวจ FBS อายุ 35-59 (ไม่รวม ICD E10-E14)</a></td></tr>
                            <tr><td><a href="{{ route('report_cxr_41003_41004_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงาน X-ray CXR 41003 & 41004</a></td></tr>
                            <tr><td><a href="{{ route('report_mixed_building_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงาน Admit ตึกรวม</a></td></tr>
                            <tr><td><a href="{{ route('report_monk_nun_index', ['id' => $sidebar_sub1_menu_id]) }}" class="link-dark fw-bold text-decoration-none fs-5 link_hover">รายงาน รายชื่อพระและแม่ชี</a></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        {{-- Content End --}}
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#table-fetch-list").DataTable({
                // responsive: true,
                // order: [0, 'desc'],
                // autoWidth: false,
                // buttons: ['excel'],
                // columnDefs: [
                //     {
                //         targets: "_all",
                //         className: "dt-head-center dt-body-center"
                //     }
                // ],
                // dom: '<"top"Bfl>rt<"bottom"ip><"clear">',
                // buttons: [
                //     {
                //         extend: 'copyHtml5',
                //         text: 'Copy'
                //     },
                //     {
                //         extend: 'csvHtml5',
                //         text: 'CSV'
                //     },
                //     {
                //         extend: 'excelHtml5',
                //         text: 'Excel'
                //     }
                // ]
            });
        });
    </script>
@endsection
