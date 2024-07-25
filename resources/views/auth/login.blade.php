<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ไอคอนสำหรับเบราว์เซอร์ -->
    <link rel="icon" href="{{ url('https://co-vaccine.moph.go.th/assets/images/moph-logo.gif') }}" type="image/x-icon">

    <!-- ไอคอนสำหรับ iOS -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('https://co-vaccine.moph.go.th/assets/images/moph-logo.gif') }}">

    <!-- ไอคอนสำหรับ Android -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('https://co-vaccine.moph.go.th/assets/images/moph-logo.gif') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('https://co-vaccine.moph.go.th/assets/images/moph-logo.gif') }}">

    @vite('resources/css/app.css')
    <title>Dashboard Login</title>
</head>

<body style="background-color: rgb(142, 24, 245);">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="w-25 shadow-lg p-3 mb-5 bg-body rounded-3 p-5">
            <div class="d-flex justify-content-center align-items-center">
                <img src="https://co-vaccine.moph.go.th/assets/images/moph-logo.gif" class="img-fluid shadow-lg bg-body rounded-circle" width="200px" alt="">
            </div>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <h1 class="fw-bold">Dashboard</h1>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if(isset($data['error']))
                    <div class="alert alert-danger" role="alert">
                        {{ $data['error'] }}
                    </div>
                @endif
                <div class="mb-3">
                    <label for="loginname" class="form-label fw-bold">Username</label>
                    <input type="text" class="form-control shadow-sm bg-body rounded" id="loginname" name="loginname" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="passweb" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control shadow-sm bg-body rounded" id="passweb" name="passweb">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-success shadow-sm rounded">Login</button>
                    <a href="http://www.akathospital.com" class="btn btn-outline-danger shadow-sm rounded">Back</a>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>

</html>
