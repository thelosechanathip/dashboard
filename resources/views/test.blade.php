@extends('layout.dashboard_template')

@section('title')
    <title>Test</title>
@endsection

@section('content')
    <main class="main-content">
        <div class="container mt-5">
            <h4>Select Multiple Tags</h4>
            <select class="form-control" id="tags" multiple="multiple">
                <option value="yeaw">yeaw</option>
                <option value="maneerat">maneerat</option>
                <option value="thaithank">thaithank</option>
                <option value="adisak">adisak</option>
                <option value="klom">klom</option>
                <option value="wrap">wrap</option>
            </select>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#tags').select2({
                placeholder: "Select tags", // ข้อความแสดงในฟิลด์เมื่อยังไม่ได้เลือกค่า
                allowClear: true // เพิ่มปุ่ม clear เพื่อลบค่าที่เลือกทั้งหมด
            });
        });
    </script>
@endsection
