{{-- views/admin/cleaning_service/create.blade.php --}}
@extends('app.main')
@section('title', 'Cleaning Service')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a class="d-block d-xl-none burger-btn" href="#"><i class="fs-3 bi bi-justify"></i></a>
        </header>
        <div class="page-heading">
            <h3>Tambah Data</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col">
                    <div class="row gx-3 gy-3 mb-3">
                        <div class="col-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('cleaning_service.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" name="nama" class="form-control" id="nama"
                                                        placeholder="Nama" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="telepon">Telepon</label>
                                                    <input type="text" name="telepon" class="form-control" id="telepon"
                                                        placeholder="Telepon" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    <div>
                                                        <div class="form-check">
                                                            <input type="radio" name="jenis_kelamin"
                                                                class="form-check-input" id="laki_laki" value="laki-laki"
                                                                checked>
                                                            <label class="form-check-label"
                                                                for="laki_laki">Laki-laki</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio" name="jenis_kelamin"
                                                                class="form-check-input" id="perempuan" value="perempuan">
                                                            <label class="form-check-label"
                                                                for="perempuan">Perempuan</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <input type="text" name="alamat" class="form-control" id="alamat"
                                                        placeholder="Alamat" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="foto_diri">Foto Diri</label>
                                                    <input type="file" name="foto_diri" class="form-control"
                                                        id="foto_diri" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                        id="password" placeholder="Password" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Konfirmasi Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        id="password_confirmation" placeholder="Konfirmasi Password"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
