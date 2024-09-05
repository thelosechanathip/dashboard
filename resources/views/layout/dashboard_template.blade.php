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
    @include('layout.template.footer')
    @include('layout.template.scriptes')

    @yield('script')
    <script>
        $(document).ready(function() {
            $('#palliative_care').ready(function() {
                // ดึงค่า data-value จาก id="palliative_care"
                let palliativeCare = $('#palliative_care').data('value');

                // เรียก AJAX เพื่อส่งข้อมูลไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: '{{ route('check_status') }}',
                    data: {
                        palliativeCare: palliativeCare
                    },
                    method: 'GET',  // หรือ POST ถ้าต้องการ
                    success: function(response) {
                        if(response.palliativeCareStatus === true) {
                            // console.log(response.palliativeCareStatus);
                            $('#palliative_care').show();
                        } else {
                            // console.log(response.palliativeCareStatus);
                            $('#palliative_care').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);  // แสดง error หากมีข้อผิดพลาด
                    }
                });
            });

            $('#menu_setting_admin').ready(function() {
                let admin_group = 'ผู้ดูแลระบบ';
                let admin_department = ''

                $.ajax({
                    url: '{{ route('check_group_and_user') }}',
                    data: {
                        admin_group: admin_group
                    },
                    method: 'GET',
                    success: function(response) {
                        if(response.status === true) {
                            $('#menu_setting_admin').show();
                        } else {
                            $('#menu_setting_admin').hide();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
