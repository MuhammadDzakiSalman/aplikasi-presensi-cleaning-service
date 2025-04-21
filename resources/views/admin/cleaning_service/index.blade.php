@extends('app.main')
@section('title', 'Cleaning Service')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a class="d-block d-xl-none burger-btn" href="#"><i class="fs-3 bi bi-justify"></i></a>
        </header>
        <div class="page-heading">
            <h3>Data Cleaning Service</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col">
                    <div class="row gx-3 gy-3 mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-primary d-flex align-items-center gap-1" role="button" href="{{ route('cleaning_service.create') }}">
                                            <em class="bi bi-plus-circle d-flex align-items-center"></em>Tambah Anggota
                                        </a>
                                        <a class="btn btn-primary d-flex align-items-center gap-1" href="{{ route('cleaning_service.download_pdf') }}">
                                            <em class="bi bi-filetype-pdf d-flex align-items-center"></em>Download PDF
                                        </a>                                        
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-lg">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Telepon</th>
                                                    <th>Alamat</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-md">
                                                                <a href="#"><img src="{{ asset('storage/'.$user->foto_diri) }}" height="64" width="64" style="object-fit: contain;" alt="Foto"></a>
                                                            </div>
                                                            <p class="font-bold ms-3 mb-0 text-nowrap">{{ $user->nama }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="col-auto text-nowrap">{{ $user->telepon }}</td>
                                                    <td class="text-nowrap">{{ $user->alamat }}</td>
                                                    <td class="text-nowrap">{{ ucfirst($user->jenis_kelamin) }}</td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <form action="{{ route('cleaning_service.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-outline-danger" type="submit">
                                                                    <em class="bi bi-trash"></em>
                                                                </button>
                                                            </form>
                                                        </div>
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
                                            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>
                                    
                                            @if ($users->currentPage() > 3)
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $users->url(1) }}">1</a>
                                                </li>
                                                @if ($users->currentPage() > 4)
                                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                                @endif
                                            @endif
                                    
                                            @for ($i = max(1, $users->currentPage() - 2); $i <= min($users->lastPage(), $users->currentPage() + 2); $i++)
                                                <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor
                                    
                                            @if ($users->currentPage() < $users->lastPage() - 2)
                                                @if ($users->currentPage() < $users->lastPage() - 3)
                                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                                @endif
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a>
                                                </li>
                                            @endif
                                    
                                            <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
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
