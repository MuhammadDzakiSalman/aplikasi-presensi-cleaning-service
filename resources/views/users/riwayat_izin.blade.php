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
    <div class="d-flex justify-content-center my-3 my-lg-4 my-xl-5">
        <h5>Riwayat Izin</h5>
    </div>
    <div class="min-vh-100 bg-body">
        <div class="container container-fluid">
            <div class="row gy-3 gx-3 pb-3">
                @if ($izins->isEmpty())
                    <div class="col-12 text-center">
                        <p>Tidak ada riwayat izin</p>
                    </div>
                @else
                    @foreach ($izins as $izin)
                        <div class="col-12">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                                        <h4 class="mb-1">{{ auth()->user()->nama }}</h4>
                                        <small>{{ $izin->created_at->format('d F Y H:i') }}</small>
                                    </div>
                                    <p>{{ $izin->jam_mulai }} - {{ $izin->jam_selesai }}</p>
                                    <p>{{ $izin->deskripsi }}</p>
                                    @if ($izin->files->isNotEmpty())
                                        <hr>
                                        <p class="mb-1">Lampiran</p>
                                        <div>
                                            <ul>
                                                @foreach ($izin->files as $file)
                                                    <li><a href="{{ asset('storage/' . $file->file_path) }}"
                                                            target="_blank">{{ basename($file->file_path) }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
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
</body>

</html>
