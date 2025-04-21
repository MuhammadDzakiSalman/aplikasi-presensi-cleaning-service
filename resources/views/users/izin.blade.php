<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Presensi Pelindo</title>
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg"
        type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
</head>

<body>
    <div class="d-flex justify-content-center mt-5">
        <h5>Form Izin</h5>
    </div>
    <div class="min-vh-100 bg-body">
        <div class="container container-fluid">
            <div class="row mb-3">
                <div class="col-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="jamMulai">Jam Mulai</label>
                                            <input type="text" class="form-control" name="jam_mulai" id="jamMulai"
                                                placeholder="HH:MM" maxlength="5" oninput="formatWaktu(this)">
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jamSelesai">Jam Selesai</label>
                                            <input type="text" class="form-control" name="jam_selesai"
                                                id="jamSelesai" placeholder="HH:MM" maxlength="5"
                                                oninput="formatWaktu(this)">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="formFile">Lampiran (Opsional)</label>
                                    <input type="file" class="form-control" name="files[]" id="formFile" multiple>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-primary" type="submit">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script
        src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>

    <script>
        function formatWaktu(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + ':' + value.substring(2, 4);
            }
            input.value = value.substring(0, 5);
        }
    </script>

    <script>
        // Dapatkan lokasi user saat halaman dimuat
        window.onload = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                }, function(error) {
                    console.error("Geolocation error:", error.message);
                });
            } else {
                console.warn("Browser tidak mendukung Geolocation.");
            }
        };
    </script>

</body>

</html>
