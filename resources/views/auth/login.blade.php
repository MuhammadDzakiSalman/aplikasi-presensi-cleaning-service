<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Aplikasi Presensi Pelindo</title>
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/iconly.css">
</head>

<body>
    <div class="container-fluid d-flex align-items-center min-vh-100">
        <div class="row gy-4 gy-md-0 d-md-flex justify-content-md-center min-vh-100">
            <div class="col-md-6 col-lg-7 d-flex align-items-center justify-content-center">
                <div class="p-xl-5 m-xl-5"><img class="rounded img-fluid fit-cover" style="min-height: 150px;" src="{{ asset('images/pelindo_logo.png') }}"></div>
            </div>
            <div class="col-lg-5 d-flex align-items-center justify-content-center bg-primary bg-gradient">
                <div class="px-2 px-lg-5 p-5 w-100 text-white">
                    <div class="mb-5">
                        <h1 class="fw-bold text-white">Login</h1>
                    </div>
                    <h6 class="h5 mb-0 text-white">Selamat datang!</h6>
                    <p class="mb-2">Mohon login untuk melanjutkan</p>
                    <form method="POST" action="{{ url('login') }}">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="telepon">Telepon</label>
                            <input class="form-control form-control rounded-3" type="text" id="telepon" name="telepon" required>
                        </div>
                        <div class="form-group mb-5">
                            <label for="password">Password</label>
                            <input class="form-control form-control rounded-3" type="password" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-outline-light w-100 rounded-3 fw-semibold">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
</body>

</html>