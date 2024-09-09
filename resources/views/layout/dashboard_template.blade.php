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
            setUpStatus();

            function setUpStatus() {
                let palliativeCareStatusId = $('#palliative_care').data('value');
                if(palliativeCareStatusId === 1) {
                    $('#palliative_care').show();
                } else{
                    $('#palliative_care').hide();
                }
            }

        });
    </script>
</body>
</html>
