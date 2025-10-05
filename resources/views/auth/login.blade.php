@extends('layouts.app')

@section('title', 'Login - Absensi SMPN 4')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-8">
            <div class="login-card">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="school-logo mb-3">
                        <i class="fas fa-school fa-4x text-primary"></i>
                    </div>
                    <h2 class="fw-bold text-primary mb-2">Absensi SMPN 4 Padang Panjang</h2>
                    <p class="text-muted">Masuk ke Sistem Absensi Digital</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">
                            <i class="fas fa-envelope me-2 text-primary"></i>Alamat Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-user"></i>
                            </span>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Masukkan email Anda">
                        </div>
                        @error('email')
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">
                            <i class="fas fa-lock me-2 text-primary"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-key"></i>
                            </span>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password"
                                placeholder="Masukkan password Anda">
                        </div>
                        @error('password')
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk Sistem
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="mb-0 text-muted">Belum memiliki akun?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary fw-semibold">
                        <i class="fas fa-user-plus me-2"></i>Buat Akun Baru
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="row text-center mt-4 pt-4 border-top">
                    <div class="col-4">
                        <div class="stat-mini">
                            <i class="fas fa-users text-success fa-2x mb-2"></i>
                            <small class="text-muted">1000+ Siswa</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-mini">
                            <i class="fas fa-chalkboard-teacher text-info fa-2x mb-2"></i>
                            <small class="text-muted">50+ Guru</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-mini">
                            <i class="fas fa-clipboard-check text-warning fa-2x mb-2"></i>
                            <small class="text-muted">Absensi Cepat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .login-card {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 3rem 2rem;
        animation: slideInUp 0.6s ease-out;
    }

    .school-logo {
        animation: bounceIn 0.8s ease-out;
    }

    .login-form .form-control {
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .login-form .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        transform: translateY(-2px);
    }

    .login-form .input-group-text {
        border: 2px solid #e9ecef;
        border-right: none;
    }

    .login-form .form-control:focus+.input-group-text,
    .login-form .input-group-text:focus-within {
        border-color: #4CAF50;
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
    }

    .stat-mini {
        padding: 1rem;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.05), rgba(33, 150, 243, 0.05));
        transition: transform 0.3s ease;
    }

    .stat-mini:hover {
        transform: scale(1.05);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }

        50% {
            opacity: 1;
            transform: scale(1.05);
        }

        70% {
            transform: scale(0.9);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @media (max-width: 768px) {
        .login-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .school-logo .fa-4x {
            font-size: 3rem;
        }
    }
</style>
@endsection