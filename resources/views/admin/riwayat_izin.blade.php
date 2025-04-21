@extends('app.main')
@section('title', 'Riwayat Izin')
@section('content')
    <div id="main">
        <header class="mb-3"><a class="d-block d-xl-none burger-btn" href="#"><i class="fs-3 bi bi-justify"></i></a>
        </header>
        <div class="page-heading d-flex justify-content-between align-items-center">
            <h3>Riwayat Izin</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="row gy-2 mb-3">
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
                                                    <p>Waktu Izin: {{ $izin->jam_mulai }} - {{ $izin->jam_selesai }}</p>
                                                    <p>{{ $izin->deskripsi }}</p>
                                                    @if ($izin->latitude && $izin->longitude)
                                                        <a href="https://www.google.com/maps?q={{ $izin->latitude }},{{ $izin->longitude }}"
                                                            target="_blank" class="btn btn-sm btn-primary mt-2 p-2">
                                                            <i class="bi bi-geo-alt-fill"></i> Lihat Lokasi
                                                        </a>
                                                    @endif
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
                </div>
            </section>
        </div>
    </div>
@endsection
