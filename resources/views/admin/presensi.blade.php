@extends('app.main')
@section('title', 'Presensi')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a class="d-block d-xl-none burger-btn" href="#"><i class="fs-3 bi bi-justify"></i></a>
        </header>
        <div class="page-heading">
            <h3>Presensi</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col">
                    <div class="row gy-3 mb-3">
                        <div class="col-12 col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Jam Kerja</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Jam Masuk -->
                                        <div class="col col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="jamMasuk">Jam Masuk</label>
                                                <input type="text" class="form-control input-time" id="jamMasuk"
                                                    placeholder="HH:MM" maxlength="5" oninput="formatWaktu(this)"
                                                    value="{{ isset($jamKerja) ? $jamKerja->jam_masuk : '' }}">
                                            </div>
                                        </div>
                                        <!-- Jam Keluar -->
                                        <div class="col col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="jamKeluar">Jam Keluar</label>
                                                <input type="text" class="form-control input-time" id="jamKeluar"
                                                    placeholder="HH:MM" maxlength="5" oninput="formatWaktu(this)"
                                                    value="{{ isset($jamKerja) ? $jamKerja->jam_keluar : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="button"
                                            onclick="perbaruiWaktu()">Perbarui</button>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Fungsi untuk memperbarui waktu
                                function perbaruiWaktu() {
                                    const jamMasuk = document.getElementById('jamMasuk').value;
                                    const jamKeluar = document.getElementById('jamKeluar').value;

                                    // Tampilkan data yang akan dikirim untuk debugging
                                    console.log("Jam Masuk: ", jamMasuk, " Jam Keluar: ", jamKeluar);

                                    // Kirim data ke server menggunakan AJAX
                                    fetch("{{ route('jam-kerja.update') }}", {
                                            method: "POST",
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                            },
                                            body: JSON.stringify({
                                                jam_masuk: jamMasuk,
                                                jam_keluar: jamKeluar
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                alert("Jam kerja berhasil diperbarui.");
                                                location.reload(); // Reload halaman setelah berhasil
                                            } else {
                                                alert("Terjadi kesalahan.");
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                        });
                                }

                                // Fungsi untuk memformat waktu saat input
                                function formatWaktu(input) {
                                    let value = input.value.replace(/\D/g, ''); // Hapus karakter selain angka
                                    if (value.length > 2) {
                                        value = value.substring(0, 2) + ':' + value.substring(2, 4); // Menambahkan ":" setelah dua digit pertama
                                    }
                                    input.value = value.substring(0, 5); // Batasi panjang input hingga 5 karakter (HH:MM)
                                }
                            </script>
                        </div>
                    </div>

                    <!-- Tabel Presensi Hari Ini -->
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Presensi Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Waktu</th>
                                                <th>Jenis Presensi</th>
                                                {{-- <th>Bukti Kehadiran</th>
                                                <th>Lokasi</th> --}}
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($presensiHariIni as $presensi)
                                                <tr>
                                                    <td class="col-3">{{ $presensi->user->nama }}</td>
                                                    <td class="col-auto">
                                                        {{ $presensi->waktu_presensi }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $presensi->jenis_presensi == 'masuk' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ ucfirst($presensi->jenis_presensi) }}
                                                        </span>
                                                    </td>
                                                    {{-- <td>
                                                        <button class="btn btn-primary" type="button"
                                                            onclick="window.open('{{ asset('storage/' . $presensi->gambar) }}')">Lihat</button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" type="button"
                                                            onclick="window.open('https://www.google.com/maps?q={{ $presensi->latitude }},{{ $presensi->longitude }}')">Lihat</button>
                                                    </td> --}}
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
                                        <li class="page-item {{ $presensiHariIni->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $presensiHariIni->previousPageUrl() }}" aria-label="Previous">
                                                <span aria-hidden="true">«</span>
                                            </a>
                                        </li>
                                
                                        @if ($presensiHariIni->currentPage() > 3)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $presensiHariIni->url(1) }}">1</a>
                                            </li>
                                            @if ($presensiHariIni->currentPage() > 4)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                        @endif
                                
                                        @for ($i = max(1, $presensiHariIni->currentPage() - 2); $i <= min($presensiHariIni->lastPage(), $presensiHariIni->currentPage() + 2); $i++)
                                            <li class="page-item {{ $i == $presensiHariIni->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $presensiHariIni->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                
                                        @if ($presensiHariIni->currentPage() < $presensiHariIni->lastPage() - 2)
                                            @if ($presensiHariIni->currentPage() < $presensiHariIni->lastPage() - 3)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $presensiHariIni->url($presensiHariIni->lastPage()) }}">{{ $presensiHariIni->lastPage() }}</a>
                                            </li>
                                        @endif
                                
                                        <li class="page-item {{ $presensiHariIni->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $presensiHariIni->nextPageUrl() }}" aria-label="Next">
                                                <span aria-hidden="true">»</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
