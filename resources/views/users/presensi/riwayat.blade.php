<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Presensi Pelindo</title>
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
</head>

<body>
    <div class="d-flex justify-content-center my-3 my-lg-4 my-xl-5"><h5>Riwayat Presensi</h5></div>
    <div class="min-vh-100 bg-body">
        <div class="container container-fluid">
            <div class="row gy-3 gx-3 pb-3">
                <div class="col">
                    <div class="row gx-3 gy-3 mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-lg">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Tanggal</th>
                                                    <th>Waktu Masuk</th>
                                                    <th>Waktu Keluar</th>
                                                    <th>Status Kehadiran</th>
                                                    <th>Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($presensiList as $presensi)
                                                    <tr>
                                                        <td>{{ $presensi['nama'] }}</td>
                                                        <td>{{ $presensi['tanggal'] }}</td>
                                                        <td class="col-auto">{{ $presensi['waktu_masuk'] }}</td>
                                                        <td class="col-auto">{{ $presensi['waktu_keluar'] }}</td>
                                                        <td>{{ $presensi['status_kehadiran'] }}</td>
                                                        <td>
                                                            <a href="{{ route('presensi.detail', $presensi['id']) }}" class="btn btn-primary btn-sm">Detail</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer p-3 pb-0 border-0">
                                    <nav class="d-flex justify-content-end">
                                        <ul class="pagination">
                                            <!-- Tombol Previous -->
                                            <li class="page-item {{ $presensiData->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $presensiData->previousPageUrl() }}" aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>
                                    
                                            @if ($presensiData->currentPage() > 3)
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $presensiData->url(1) }}">1</a>
                                                </li>
                                                @if ($presensiData->currentPage() > 4)
                                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                                @endif
                                            @endif
                                    
                                            @for ($i = max(1, $presensiData->currentPage() - 2); $i <= min($presensiData->lastPage(), $presensiData->currentPage() + 2); $i++)
                                                <li class="page-item {{ $i == $presensiData->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $presensiData->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor
                                    
                                            @if ($presensiData->currentPage() < $presensiData->lastPage() - 2)
                                                @if ($presensiData->currentPage() < $presensiData->lastPage() - 3)
                                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                                @endif
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $presensiData->url($presensiData->lastPage()) }}">{{ $presensiData->lastPage() }}</a>
                                                </li>
                                            @endif
                                    
                                            <li class="page-item {{ $presensiData->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" href="{{ $presensiData->nextPageUrl() }}" aria-label="Next">
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
</body>

</html>
