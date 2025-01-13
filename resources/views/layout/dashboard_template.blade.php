<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.template.header')
    @yield('title')
    @yield('style')
    {{-- ขนาดของ Select 2 && Modal Start --}}
    <style>
        .link_hover:hover {
            color: #198754 !important; /* กำหนดสีดำไว้ก่อน เพื่อให้แน่ใจว่าจะเปลี่ยนเป็นสีเขียวเมื่อ hover */
            text-decoration: none; /* ป้องกันการขีดเส้นใต้เมื่อ hover */
        }
        
        .select2-container--default .select2-selection--single {
            height: 38px !important; /* บังคับความสูง */
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            padding: 0.375rem 0.75rem !important;
            background-color: #fff !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 28px !important;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            top: 4px !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .modal-dialog {
            transition: transform 0.1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 1rem);
        }

        .modal-content {
            margin-top: 1rem;  /* ปรับระยะห่างจากขอบบนของหน้าจอ */
            margin-bottom: 1rem;  /* ปรับระยะห่างจากขอบล่างของหน้าจอ */
        }

        .detail-column {
            max-width: 250px; /* กำหนดความกว้างสูงสุดของคอลัมน์นี้ */
            white-space: nowrap; /* ป้องกันไม่ให้ขึ้นบรรทัดใหม่ */
            overflow: hidden; /* ซ่อนส่วนที่เกิน */
            text-overflow: ellipsis; /* แสดง "..." เมื่อข้อความยาวเกินไป */
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }
        .content-container {
            position: relative;
            z-index: 1;
        }
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            width: 100%;
            height: 100%;
            font-family: "Kanit", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

    </style>
    {{-- ขนาดของ Select 2 && Modal End --}}
</head>
<body>
    <!-- Modal Detail การ Update Version Start -->
        <div class="modal fade" id="DetailUpdateVersionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                    @if($version_first)
                        <h5 class="modal-title" id="DetailUpdateVersionTitle">รายการที่มีการ Update ของ Version {{ $version_first->version_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($version_detail_model && $version_detail_model->count() > 0)
                                <span class="fw-bold">รายละเอียดการ Update</span><br>
                                @foreach($version_detail_model as $vdm)
                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $loop->iteration }}. {{ $vdm->version_detail_name }}</span><br>
                                @endforeach
                            @else
                                <span class="fw-bold">ไม่มีรายการ Update</span><br>
                            @endif
                        </div>
                    @else
                        <h5 class="modal-title" id="DetailUpdateVersionTitle">ยังไม่มีข้อมูลการ Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-bold">ไม่มีรายละเอียดการ Update</span><br>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    <!-- Modal Detail การ Update Version End -->

    <video class="video-background" autoplay loop muted playsinline>
        @if (isset($date_now) && isset($month_now))
            {{-- @if ($month_now == '01' && $date_now == '01')
                <source src="{{ asset('video/festival/HappyNewYear.mp4') }}" type="video/mp4">
            @elseif($month_now == '01' && $date_now == '01')
                <source src="{{ asset('video/festival/LoyKrathongDay.mp4') }}" type="video/mp4">
            @else
                
            @endif --}}
            {{-- <source src="{{ asset('video/IT.mp4') }}" type="video/mp4"> --}}
        @endif
    </video> 

    @include('layout.template.navbar')
    <div class="container-fluid" id="sidebar-content">
        <div class="row h-100">
            <!-- Sidebar -->
            <div class="" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="400">
                @include('layout.template.sidebar')
            </div>
            <!-- Content -->
            <div class="mt-3 mb-5" id="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    
    @include('layout.template.footer')
    @include('layout.template.scriptes')

    @yield('script')

    <script>
        $(document).ready(function() {

            $('.pc_menu_offcanvas').on('click', function() {
                $('#palliative_care_menu').offcanvas('hide');
            });

            document.addEventListener("DOMContentLoaded", function() {
                if (typeof someJavaScriptFunction === "undefined") {
                    window.location.href = "/enable-javascript";
                }
            });

            // ปิดการคลิกขวา
            document.addEventListener('contextmenu', event => event.preventDefault());

            // ปิดการกด F12
            document.addEventListener('keydown', event => {
                // ปิดการใช้งาน F12
                if (event.keyCode === 123) { // F12
                    event.preventDefault();
                }
                
                // ปิดการใช้งาน Ctrl + Shift + I
                if (event.ctrlKey && event.shiftKey && event.keyCode === 73) { // Ctrl + Shift + I
                    event.preventDefault();
                }
                
                // ปิดการใช้งาน Ctrl + Shift + J (Console)
                if (event.ctrlKey && event.shiftKey && event.keyCode === 74) { // Ctrl + Shift + J
                    event.preventDefault();
                }

                // ปิดการใช้งาน Ctrl + U (View Source)
                if (event.ctrlKey && event.keyCode === 85) { // Ctrl + U
                    event.preventDefault();
                }
            });

            // AOS Animation Start
                AOS.init();
            // AOS Animation End

            setUpStatus();

            function setUpStatus() {

                $('.sidebar-main-menu').each(function() {
                    var sidebarMainMenuLi = $(this); // เก็บ reference ของ Li ปัจจุบัน
                    var sidebarMainMenuA = sidebarMainMenuLi.find('.sidebar-main-menu-a');

                    if (sidebarMainMenuA.length > 0) {
                        var sidebarMainMenuId = sidebarMainMenuA.data('value');
                        if(sidebarMainMenuId === 1) {
                            sidebarMainMenuLi.show();
                        } else {
                            sidebarMainMenuLi.hide();
                        }
                    } else {
                        console.error('Element .sidebar-main-menu-a not found');
                    }
                });

                $('.sidebar-sub1-menu').each(function() {
                    var sidebarSub1MenuLi = $(this); // เก็บ reference ของ Li ปัจจุบัน
                    var sidebarSub1MenuA = sidebarSub1MenuLi.find('.sidebar-sub1-menu-a');

                    if (sidebarSub1MenuA.length > 0) {
                        var sidebarMainMenuId = sidebarSub1MenuA.data('value');
                        if(sidebarMainMenuId === 1) {
                            sidebarSub1MenuLi.show();
                        } else {
                            sidebarSub1MenuLi.hide();
                        }
                    } else {
                        console.error('Element .sidebar-sub1-menu-a not found');
                    }
                });
                
                // Check Status Ovst Start
                    ovstStatusId();
                    function ovstStatusId() {
                        let ovstStatusId = $('#ovst').data('value');
                        if(ovstStatusId === 1) {
                            $('#ovst_card').show();
                        } else{
                            $('#ovst_card').hide();
                        }
                    }
                // Check Status Ovst End
                
                // Check Status Admit Start
                    admitStatusId();
                    function admitStatusId() {
                        let admitStatusId = $('#admit').data('value');
                        if(admitStatusId === 1) {
                            $('#admit_card').show();
                        } else{
                            $('#admit_card').hide();
                        }
                    }
                // Check Status Admit End

                // Check Status Refer Out Start
                    referOutStatusId();
                    function referOutStatusId() {
                        let referOutStatusId = $('#refer_out').data('value');
                        if(referOutStatusId === 1) {
                            $('#refer_out_card').show();
                        } else{
                            $('#refer_out_card').hide();
                        }
                    }
                // Check Status Refer Out End

                // Check Status Refer In Start
                    referInStatusId();
                    function referInStatusId() {
                        let referInStatusId = $('#refer_in').data('value');
                        if(referInStatusId === 1) {
                            $('#refer_in_card').show();
                        } else{
                            $('#refer_in_card').hide();
                        }
                    }
                // Check Status Refer In End

                // Check Status Er Start
                    erStatusId();
                    function erStatusId() {
                        let erStatusId = $('#er').data('value');
                        if(erStatusId === 1) {
                            $('#er_card').show();
                        } else{
                            $('#er_card').hide();
                        }
                    }
                // Check Status Er End

                // Check Status OpdScreen Start
                    opdscreenStatusId();
                    function opdscreenStatusId() {
                        let opdscreenStatusId = $('#opdscreen').data('value');
                        if(opdscreenStatusId === 1) {
                            $('#opdscreen_card').show();
                        } else{
                            $('#opdscreen_card').hide();
                        }
                    }
                // Check Status OpdScreen End
            }
        });
    </script>
</body>
</html>
