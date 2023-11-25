<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link bg-primary">
        <img src="{{ asset('dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Kinerja Produk</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                {{-- <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"> --}}
                <img src="{{ asset('dist/img/default-avatar.jpg') }}" class="img-circle elevation-2 img-fluid" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block user-select-none">{{ Auth::user()->nama }}</a>
                <a class="d-block text-sm user-select-none">{{ Auth::user()->role }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kriteria.index') }}" class="nav-link {{ (request()->segment(1) == 'kriteria') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Kriteria</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('asset.index') }}" class="nav-link {{ (request()->segment(1) == 'asset') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Aset</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('analisis.index') }}" class="nav-link {{ (request()->segment(1) == 'analisis') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Analisis</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hasil.index') }}" class="nav-link {{ (request()->segment(1) == 'hasil') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Hasil</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>