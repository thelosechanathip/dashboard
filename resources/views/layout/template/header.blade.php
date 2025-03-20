<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
<!-- ไอคอนสำหรับเบราว์เซอร์ -->
<link rel="icon" href="{{ url('http://akathospital.com/assets/images/moph-sm.png') }}" type="image/x-icon">

<!-- ไอคอนสำหรับ iOS -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ url('http://akathospital.com/assets/images/moph-sm.png') }}">

<!-- ไอคอนสำหรับ Android -->
<link rel="icon" type="image/png" sizes="32x32" href="{{ url('http://akathospital.com/assets/images/moph-sm.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ url('http://akathospital.com/assets/images/moph-sm.png') }}">

{{-- Chart JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

{{-- Ajax && Jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- DataTables --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap5.min.css">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

{{-- AOS CSS --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

{{-- Google Font --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit&family=Patrick+Hand&display=swap" rel="stylesheet">

<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/css/dashboard.css'])