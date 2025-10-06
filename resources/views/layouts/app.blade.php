<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Absensi SMPN 4 Padang Panjang')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Custom CSS -->
    <!--<link rel="stylesheet" href="{{ asset('css/custom.css') }}">-->
    <link rel="stylesheet" href="{{ secure_asset('css/custom.v2.css') }}?v={{ time() }}">

</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header Section -->
    <header class="school-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 judul">
                    <h1 class="school-title"><i class="fas fa-school me-3"></i>FourPres</h1>
                    <p class="school-subtitle">Sistem Absensi Digital untuk Pendidikan Berkualitas</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="header-icons">
                        <i class="fas fa-users fa-2x me-3 text-white"></i>
                        <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                        <i class="fas fa-graduation-cap fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    @auth
                    @if(Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    </li>
                    @elseif(Auth::user()->role == 'guru')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guru.absensi.show') }}"><i class="fas fa-clipboard-check me-1"></i>Absensi</a>
                    </li>
                    @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Foto Profil" class="rounded-circle" width="30" height="30">
                            @else
                            <i class="fas fa-user-circle me-1"></i>
                            @endif
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('guru.profile') }}"><i class="fas fa-user-edit me-1"></i>Profil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-school me-2"></i>SMPN 4 PADANG PANJANG</h5>
                    <p>Sistem Absensi Modern untuk Pendidikan Masa Depan</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>&copy; {{ date('Y') }} SMPN 4 PADANG PANJANG. All Rights Reserved.</p>
                    <!-- <p><i class="fas fa-code me-1"></i>Dikembangkan dengan ❤️ untuk Pendidikan</p> -->
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>