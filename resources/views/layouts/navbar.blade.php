<nav class="main-header navbar navbar-expand navbar-primary navbar-dark border-bottom-0 bg-primary text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="">
                <i class="fas fa-user mr-1"></i>
                <span class="d-none d-md-inline">{{ Auth::user()->nama }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-header bg-primary">
                    <img src="{{ asset('dist/img/default-avatar.jpg') }}" class="img-circle" alt="Foto Profil">
                    <p class="text-center">{{ Auth::user()->nama }}</p>
                </div>
                <a href="{{ route('profil.edit') }}" class="dropdown-item bg-warning text-center">
                    <i class="fas fa-user mr-2"></i> Edit Profil
                </a>
                {{-- <form class="dropdown-item bg-danger text-center" action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-danger" type="submit"><i class="fas fa-sign-out-alt mr-2"></i> Keluar</button>
                  </form> --}}
                <a href="{{ route('logout') }}" class="dropdown-item bg-danger text-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>