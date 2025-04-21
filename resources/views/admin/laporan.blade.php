@extends('app.main')
@section('title', 'Laporan')
@section('content')
    <div id="main">
        <header class="mb-3"><a class="d-block d-xl-none burger-btn" href="#"><i class="fs-3 bi bi-justify"></i></a>
        </header>
        <div class="page-heading">
            <h3>Laporan</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col">
                    <div class="row gx-3 gy-3 mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="gap-2 d-flex d-lg-flex flex-column flex-md-row">
                                        <form method="GET" action="{{ route('laporan.index') }}" class="d-flex">
                                            <select name="bulan" class="form-select me-2" required>
                                                <option value="">Pilih Bulan</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ request('bulan') == $i ? 'selected' : '' }}>
                                                        {{ Carbon\Carbon::create()->month($i)->format('F') }}
                                                    </option>
                                                @endfor
                                            </select>
        
                                            <select name="tahun" class="form-select me-2" required>
                                                <option value="">Pilih Tahun</option>
                                                @foreach ($availableYears as $year)
                                                    <option value="{{ $year->year }}"
                                                        {{ request('tahun') == $year->year ? 'selected' : '' }}>
                                                        {{ $year->year }}
                                                    </option>
                                                @endforeach
                                            </select>
        
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </form>
                                        
                                        <form method="GET" action="{{ route('laporan.export.pdf') }}" class="d-inline">
                                            @if(request('bulan'))
                                                <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                            @endif
                                            @if(request('tahun'))
                                                <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                                            @endif
                                            <button type="submit" class="btn btn-danger">Download PDF</button>
                                        </form>
                                        <a href="{{ route('laporan.index') }}" class="btn btn-light">Clear</a>                                       
                                    </div>
                                </div>
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
            </section>
        </div>
    </div>
@endsection
