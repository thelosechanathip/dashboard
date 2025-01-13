<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="http://akathospital.com/assets/images/moph-sm.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="http://akathospital.com/assets/images/moph-sm.png">
    <link rel="icon" type="image/png" sizes="32x32" href="http://akathospital.com/assets/images/moph-sm.png">
    <link rel="icon" type="image/png" sizes="16x16" href="http://akathospital.com/assets/images/moph-sm.png">

    {{-- AOS CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Ajax && Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&family=Patrick+Hand&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')

    <title>Dashboard Login</title>

    <style>
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

        .jump-animation {
            animation: jump 1.5s infinite ease-in-out;
        }

        @keyframes jump {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px); /* กระโดดขึ้น 20px */
            }
        }
    </style>
</head>

<body>
    <video class="video-background" autoplay loop muted playsinline>
        <source src="{{ asset('video/Medical.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>    

    <div class="d-flex justify-content-center align-items-center vh-100 content-container" data-aos="zoom-in" data-aos-easing="linear" data-aos-duration="500">
        <div class="shadow-lg p-3 rounded-3 bg-body" style="width: 100%; max-width: 450px;">
            <div class="text-center mb-3">
                <img src="http://akathospital.com/assets/images/moph-sm.png" class="img-fluid shadow-lg bg-body rounded-circle jump-animation" width="100px" alt="">
                <h1 class="fw-bold text-center mt-3">Dashboard</h1>
            </div>
    
            @if(isset($data['error']))
                <div class="alert alert-danger" role="alert">
                    {{ $data['error'] }}
                </div>
            @endif
    
            <!-- Username Form -->
            <form method="POST" action="{{ route('verify-username') }}" id="username-form">
                @csrf
                <div class="mb-3">
                    <label for="loginname" class="form-label fw-bold">Username</label>
                    <input type="text" class="form-control shadow-sm rounded" id="loginname" name="loginname">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-success shadow-sm rounded">Next</button>
                </div>
            </form>
    
            <!-- Password Form -->
            <form method="POST" action="{{ route('login') }}" id="password-form" style="display: none;">
                @csrf
                <div class="mb-3">
                    <label for="passweb" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control shadow-sm rounded" id="passweb" name="passweb">
                </div>
                <input type="hidden" id="username-hidden" name="loginname">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-success shadow-sm rounded">Login</button>
                </div>
            </form>
        </div>
    </div>    

    @vite('resources/js/app.js')

    {{-- AOS Script --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    {{-- Sweet Alert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // AOS Animation Start
            AOS.init();
        // AOS Animation End

        document.addEventListener('contextmenu', event => event.preventDefault());
        document.addEventListener('keydown', event => {
            if (event.keyCode === 123) event.preventDefault();
            if (event.ctrlKey && event.shiftKey && event.keyCode === 73) event.preventDefault();
            if (event.ctrlKey && event.shiftKey && event.keyCode === 74) event.preventDefault();
            if (event.ctrlKey && event.keyCode === 85) event.preventDefault();
        });

        $('#username-form').on('submit', function(event) {
            event.preventDefault();
            const username = $('#loginname').val();

            // // Show Swal with loading icon
            // let loadingSwal = Swal.fire({
            //     title: 'กำลังโหลดข้อมูล...',
            //     text: 'โปรดรอสักครู่',
            //     icon: 'info',
            //     allowOutsideClick: false,
            //     didOpen: () => {
            //         Swal.showLoading(); // Show spinner inside the Swal
            //     }
            // });

            $.ajax({
                url: "{{ route('verify-username') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: { loginname: username },
                success: function(result) {
                    // Swal.close();
                    if (result.status === 200) { // ตรวจสอบสถานะที่ส่งกลับ
                        // ใช้ Animation ในการเลื่อน
                        $('#username-form').slideUp(300, function() {
                            $('#password-form').slideDown(300);
                            $('#username-hidden').val(username);
                        });
                    } else {
                        Swal.fire(
                            result.title,
                            result.message,
                            result.icon
                        ).then(() => {
                            location.reload(); // รีเฟรชหน้าเว็บ
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred:", error);
                    alert("An error occurred while verifying the username.");
                }
            });
        });

    </script>
</body>
</html>
