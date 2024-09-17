<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.template.header')
    @yield('title')
    @yield('style')
</head>
<body>
    @include('layout.template.navbar')
    <div class="container-fluid" id="sidebar-content">
        <div class="row h-100">
            <!-- Sidebar -->
            @include('layout.template.sidebar')
            <!-- Content -->
            <div class="" id="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Modal Detail การ Update Version -->
    <div class="modal fade" id="DetailUpdateVersionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-auto">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="DetailUpdateVersionTitle">รายการที่มีการ Update ของ Version 1.1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="fw-bold">รายละเอียดการ Update</span><br>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1. เพิ่มระบบ OPD( ผู้ป่วยนอกเข้ามา )</span><br>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. เพิ่ม Modal ในการดูว่ามีรายการอะไร Update บ้างใน Version นี้</span><br>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3. เพิ่ม การดูข้อมูลแบบแยกของตึกผู้ป่วยในทั้งหมด และเพิ่ม Chart</span><br>
                </div>
            </div>
        </div>
    </div>
    @include('layout.template.footer')
    @include('layout.template.scriptes')

    @yield('script')

    <script>
        $(document).ready(function() {
            setUpStatus();

            function setUpStatus() {
                let palliativeCareStatusId = $('#palliative_care').data('value');
                if(palliativeCareStatusId === 1) {
                    $('#palliative_care').show();
                } else{
                    $('#palliative_care').hide();
                }

                let authenCodeStatusId = $('#authen_code').data('value');
                if(authenCodeStatusId === 1) {
                    $('#authen_code').show();
                } else{
                    $('#authen_code').hide();
                }

                
                let ovstStatusId = $('#ovst').data('value');
                if(ovstStatusId === 1) {
                    $('#ovst_card').show();
                } else{
                    $('#ovst_card').hide();
                }

                let admitStatusId = $('#admit').data('value');
                if(admitStatusId === 1) {
                    $('#admit_card').show();
                } else{
                    $('#admit_card').hide();
                }

                let referOutStatusId = $('#refer_out').data('value');
                if(referOutStatusId === 1) {
                    $('#refer_out_card').show();
                } else{
                    $('#refer_out_card').hide();
                }

                let referInStatusId = $('#refer_in').data('value');
                if(referInStatusId === 1) {
                    $('#refer_in_card').show();
                } else{
                    $('#refer_in_card').hide();
                }

                let erStatusId = $('#er').data('value');
                if(erStatusId === 1) {
                    $('#er_card').show();
                } else{
                    $('#er_card').hide();
                }

                let opdscreenStatusId = $('#opdscreen').data('value');
                if(opdscreenStatusId === 1) {
                    $('#opdscreen_card').show();
                } else{
                    $('#opdscreen_card').hide();
                }
            }

        });
    </script>
</body>
</html>
