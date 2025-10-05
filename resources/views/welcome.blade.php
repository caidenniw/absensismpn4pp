@extends('layouts.app')

@section('title', 'Selamat Datang - Absensi SMPN 4')

@section('content')
<div class="container-fluid py-5">
    <div class="row align-items-center">
        <!-- Hero Section -->
        <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="hero-content">
                <h1 class="display-4 fw-bold text-primary mb-4">
                    <i class="fas fa-school me-3"></i>Sistem Absensi SMPN 4 Padang Panjang
                </h1>
                <p class="lead mb-4">
                    Platform modern untuk mengelola absensi siswa dengan mudah dan efisien.
                    Membantu guru dan administrator dalam memantau kehadiran siswa secara real-time.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk Sistem
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Akun
                    </a>
                    @endif
                    @else
                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                    </a>
                    @elseif(Auth::user()->role == 'guru')
                    <a href="{{ route('guru.dashboard') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Guru
                    </a>
                    @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Illustration -->
        <div class="col-lg-6">
            <div class="text-center">
                <div class="hero-illustration">
                    <i class="fas fa-users fa-5x text-primary mb-4"></i>
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="feature-icon">
                                <i class="fas fa-clipboard-check fa-3x text-success"></i>
                                <p class="mt-2">Absensi Cepat</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-icon">
                                <i class="fas fa-chart-bar fa-3x text-info"></i>
                                <p class="mt-2">Laporan Real-time</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt fa-3x text-warning"></i>
                                <p class="mt-2">Akses Mobile</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mt-5 g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-clock fa-4x text-primary mb-3"></i>
                    <h5 class="card-title">Absensi Real-time</h5>
                    <p class="card-text">Pantau kehadiran siswa secara langsung dengan sistem yang akurat dan cepat.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-chart-line fa-4x text-success mb-3"></i>
                    <h5 class="card-title">Laporan Lengkap</h5>
                    <p class="card-text">Dapatkan laporan absensi detail dengan statistik yang mudah dipahami.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <i class="fas fa-shield-alt fa-4x text-info mb-3"></i>
                    <h5 class="card-title">Keamanan Data</h5>
                    <p class="card-text">Data absensi terlindungi dengan sistem keamanan yang terpercaya.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mt-5 text-center">
        <div class="col-md-3 mb-4">
            <div class="stat-card">
                <h2 class="display-4 text-primary fw-bold">100+</h2>
                <p class="text-muted">Siswa Terdaftar</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card">
                <h2 class="display-4 text-success fw-bold">50+</h2>
                <p class="text-muted">Guru Aktif</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card">
                <h2 class="display-4 text-info fw-bold">95%</h2>
                <p class="text-muted">Tingkat Kehadiran</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stat-card">
                <h2 class="display-4 text-warning fw-bold">24/7</h2>
                <p class="text-muted">Akses Sistem</p>
            </div>
        </div>
    </div>
</div>

<style>
    .hero-content {
        animation: fadeInUp 1s ease-out;
    }

    .hero-illustration {
        animation: fadeInRight 1s ease-out 0.3s both;
    }

    .feature-icon {
        padding: 1rem;
        border-radius: 1rem;
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(33, 150, 243, 0.1));
        transition: transform 0.3s ease;
    }

    .feature-icon:hover {
        transform: translateY(-5px);
    }

    .stat-card {
        padding: 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
@endsection