@extends('layout.dashboard_template')

@section('title')
    <title>System Info</title>
@endsection

@section('content')
    <main class="main-content mb-5">
        <div class="card shadow-lg full-width-bar p-3" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="400">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <div class="d-flex">
                    <button class="btn btn-outline-danger zoom-card me-3" onclick="history.back()">
                        <i class="bi bi-arrow-left-circle-fill"></i>
                        Back
                    </button>
                </div>
                <div class="d-flex" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="400">
                    <h1 class="h2">สถานะเครื่อง Computer</h1>
                </div>
            </div>
        </div>
        <div class="mt-3 card shadow-lg full-width-bar p-3" id="system_information_show_all_data"></div>
    </main>
@endsection

@section('script')
  
    <script>
        $(document).ready(function() {
            fetchDataSystemInfo();

            // ตั้งเวลาให้เรียกใช้งานฟังก์ชัน fetchDataSystemInfo ทุก ๆ 1 วินาที (1000 มิลลิวินาที)
            setInterval(fetchDataSystemInfo, 1000);

            function fetchDataSystemInfo() {
                $.ajax({
                    url: '{{ route('showSystemInfo') }}',
                    method: 'get',
                    success: function(response) {
                        $("#system_information_show_all_data").html(response);
                        
                        // เรียกใช้ DataTables หลังจากสร้างตารางใน DOM แล้ว
                        if ($.fn.DataTable.isDataTable("#system_information_table")) {
                            $("#system_information_table").DataTable().destroy();
                        }
                        
                        $("#system_information_table").DataTable({
                            paging: false,  // ปิดการแบ่งหน้าเพื่อแสดงข้อมูลทั้งหมด
                            order: [0, 'ASC']
                        });
                    }
                });
            }
        });
    </script>
@endsection
