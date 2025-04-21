<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo"><a href="index.html"><img class="img-fluid" src="{{ asset('images/pelindo_logo.png') }}" alt="Logo"></a></div>
                <div class="sidebar-toggler x"><a class="d-block d-xl-none sidebar-hide" href="#"><i class="bi bi-x bi-middle"></i></a></div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><a href="dashboard" class="sidebar-link"><i class="bi bi-grid-fill"></i><span>Dashboard</span></a></li>
                <li class="sidebar-item {{ request()->routeIs('presensi.index') ? 'active' : '' }}"><a href="{{ route('presensi.index') }}" class="sidebar-link"><i class="bi bi-clipboard-fill"></i><span>Presensi</span></a></li>
                <li class="sidebar-item {{ request()->routeIs('cleaning_service.index') ? 'active' : '' }}"><a href="{{ route('cleaning_service.index') }}" class="sidebar-link"><i class="bi bi-people-fill"></i><span class="small">Data Cleaning Service</span></a></li>
                <li class="sidebar-item {{ request()->routeIs('izin.index') ? 'active' : '' }}"><a href="{{ route('izin.index') }}" class="sidebar-link"><i class="bi bi-chat-dots-fill"></i><span>Izin</span></a></li>
                <li class="sidebar-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}"><a href="{{ route('laporan.index') }}" class="sidebar-link"><i class="bi bi-file-text-fill"></i><span>Laporan</span></a></li>
                <!-- Tombol Logout -->
                <li class="sidebar-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link w-100 h-100 btn border-0">
                            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
