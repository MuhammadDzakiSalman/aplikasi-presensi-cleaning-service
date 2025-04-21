@section('title', 'Detail')
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
    <div class="container pt-3">
        <h3>Detail Presensi</h3>
        <p><strong>Nama:</strong> {{ $presensiMasuk->user->nama }}</p>

        <div class="card mt-4">
            <div class="card-body">
                <h5>Presensi Masuk</h5>
                <p><strong>Waktu Presensi:</strong> {{ \Carbon\Carbon::parse($presensiMasuk->waktu_presensi)->format('d-m-Y H:i') }}</p>
                <p><strong>Jenis Presensi:</strong> {{ ucfirst($presensiMasuk->jenis_presensi) }}</p>
                <img src="{{ asset('storage/' . $presensiMasuk->gambar) }}" alt="Foto Presensi Masuk" class="img-fluid mb-3" style="max-height: 300px;">

                <div style="height: 300px;">
                    <iframe 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        style="border:0" 
                        src="https://maps.google.com/maps?q={{ $presensiMasuk->latitude }},{{ $presensiMasuk->longitude }}&hl=es&z=15&output=embed" 
                        allowfullscreen>
                    </iframe>
                </div>

                <hr>

                @if ($presensiKeluar)
                    <h5>Presensi Keluar</h5>
                    <p><strong>Waktu Presensi:</strong> {{ \Carbon\Carbon::parse($presensiKeluar->waktu_presensi)->format('d-m-Y H:i') }}</p>
                    <p><strong>Jenis Presensi:</strong> {{ ucfirst($presensiKeluar->jenis_presensi) }}</p>
                    <img src="{{ asset('storage/' . $presensiKeluar->gambar) }}" alt="Foto Presensi Keluar" class="img-fluid mb-3" style="max-height: 300px;">

                    <div style="height: 300px;">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            style="border:0" 
                            src="https://maps.google.com/maps?q={{ $presensiKeluar->latitude }},{{ $presensiKeluar->longitude }}&hl=es&z=15&output=embed" 
                            allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <p><strong>Presensi Keluar Belum Dilakukan</strong></p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
