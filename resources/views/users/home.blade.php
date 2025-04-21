<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Aplikasi Presensi Pelindo</title>
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg"
        type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/iconly.css">
</head>

<body class="bg-primary">
    <div class="d-flex justify-content-center" style="height: 10em;">
        <div class="p-4 w-100">
            <div class="d-flex justify-content-end">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <section class="min-vh-100 bg-body">
        <div class="container">
            <div class="min-vh-100 bg-body">
                <div class="col">
                    <div class="d-flex justify-content-center flex-column align-items-center"><img
                            class="rounded-circle bg-white shadow"
                            src="{{ auth()->user()->foto_diri ? Storage::url(auth()->user()->foto_diri) : asset('') }}"
                            style="margin-top: -5em;object-fit: cover;" width="150" height="150">
                        <div>
                            <p class="mb-0 mt-3">Hi, {{ auth()->user()->nama }}</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col d-flex justify-content-center gap-3 flex-column">
                        <div class="d-flex gap-2 justify-content-center">
                            <h5 id="date"></h5>
                            <h5 id="time"></h5>
                        </div>
                    </div>
                </div>
                <div class="row px-3 my-4">
                    <div class="col">
                        <h4>Jam Kerja</h4>
                        <p class="mb-0">
                            {{ optional($jamKerja)->jam_masuk && optional($jamKerja)->jam_keluar 
                                ? "$jamKerja->jam_masuk - $jamKerja->jam_keluar" 
                                : 'Belum diatur' }}
                        </p>                        
                    </div>
                </div>
                <div class="row px-4">
                    @if (session('message'))
                        <div class="alert alert-light-primary color-primary">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                <div class="row px-3">
                    <div class="col">
                        <h4>Menu</h4>
                    </div>
                </div>
                <div class="row gx-3 gy-3 px-3">
                    <div class="col-6 col-md-4 d-flex justify-content-center gap-3"><a href="{{ route('presensi.in') }}"
                            class="btn btn-success d-flex align-items-center justify-content-center" role="button"
                            style="height: 5rem;width: 100%;">Presensi Masuk</a></div>
                    <div class="col-6 col-md-4 d-flex justify-content-center gap-3"><a
                            href="{{ route('presensi.out') }}"
                            class="btn btn-danger d-flex align-items-center justify-content-center" role="button"
                            style="height: 5rem;width: 100%;">Presensi Keluar</a></div>
                    <div class="col-12 col-md-4 d-flex justify-content-center gap-3"><a
                            href="{{ route('user.izin-form') }}"
                            class="btn btn-warning text-white d-flex align-items-center justify-content-center"
                            role="button" style="height: 5rem;width: 100%;">Buat Izin</a></div>
                    <div class="col-6 col-md-6 col-lg-6 d-flex justify-content-center gap-3"><a
                            href="{{ route('riwayat.presensi') }}"
                            class="btn btn-primary d-flex align-items-center justify-content-center" role="button"
                            style="height: 5rem;width: 100%;">Riwayat Presensi</a></div>
                    <div class="col-6 col-md-6 col-lg-6 d-flex justify-content-center gap-3"><a
                            href="{{ route('riwayat.izin') }}"
                            class="btn btn-primary d-flex align-items-center justify-content-center" role="button"
                            style="height: 5rem;width: 100%;">Riwayat Izin</a></div>
                </div>
                <div class="row px-3 mt-4">
                    <div class="col">
                        <h4>Izin Hari Ini</h4>
                    </div>
                </div>
                <div class="row gy-3 gx-3 pb-3 px-3">
                    @if ($izins->isEmpty())
                        <div class="col-12 text-center">
                            <p>Tidak ada Izin hari ini</p>
                        </div>
                    @else
                        @foreach ($izins as $izin)
                            <div class="col-12 col-xl-6">
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
    </section>
    <script
        src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
    <script>
        function updateTimeAndDate() {
            const nowInJakarta = new Date();

            const optionsDate = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };

            const formattedDate = new Intl.DateTimeFormat('id-ID', optionsDate).format(nowInJakarta);

            const hours = String(nowInJakarta.getHours()).padStart(2, '0');
            const minutes = String(nowInJakarta.getMinutes()).padStart(2, '0');
            const seconds = String(nowInJakarta.getSeconds()).padStart(2, '0');

            const formattedTime = `${hours}:${minutes}:${seconds}`;

            document.getElementById('date').textContent = `${formattedDate}`;
            document.getElementById('time').textContent = `${formattedTime}`;
        }

        setInterval(updateTimeAndDate, 1000);
        updateTimeAndDate();
    </script>
</body>

</html>
