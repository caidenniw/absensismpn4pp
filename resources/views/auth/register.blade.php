@extends('layouts.app')

@section('title', 'Registrasi - Absensi SMPN 4')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="register-card">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="school-logo mb-3">
                        <i class="fas fa-user-plus fa-4x text-success"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-2">Bergabung dengan SMPN 4</h2>
                    <p class="text-muted">Buat akun untuk mengakses sistem absensi digital</p>
                </div>

                <!-- Progress Indicator -->
                <div class="progress mb-4" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register.store') }}" class="register-form">
                    @csrf

                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                       placeholder="Masukkan nama lengkap Anda">
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary"></i>Alamat Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-at"></i>
                                </span>
                                <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       placeholder="Masukkan email institusi Anda">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="new-password"
                                       placeholder="Minimal 8 karakter">
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                <input id="password_confirmation" type="password" class="form-control form-control-lg"
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Ulangi password">
                            </div>
                        </div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="password-requirements mb-4">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Password harus mengandung minimal 8 karakter
                        </small>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-success btn-lg fw-semibold">
                            <i class="fas fa-user-plus me-2"></i>Buat Akun Guru
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="mb-0 text-muted">Sudah memiliki akun?</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary fw-semibold">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk Sistem
                    </a>
                </div>

                <!-- Benefits -->
                <div class="row text-center mt-4 pt-4 border-top">
                    <div class="col-4">
                        <div class="benefit-item">
                            <i class="fas fa-clock text-info fa-2x mb-2"></i>
                            <small class="text-muted">Absensi Cepat</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="benefit-item">
                            <i class="fas fa-chart-bar text-success fa-2x mb-2"></i>
                            <small class="text-muted">Laporan Real-time</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="benefit-item">
                            <i class="fas fa-shield-alt text-warning fa-2x mb-2"></i>
                            <small class="text-muted">Data Aman</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.register-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 3rem 2rem;
    animation: slideInUp 0.6s ease-out;
}

.school-logo {
    animation: bounceIn 0.8s ease-out;
}

.register-form .form-control {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.register-form .form-control:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
    transform: translateY(-2px);
}

.register-form .input-group-text {
    border: 2px solid #e9ecef;
    border-right: none;
}

.register-form .form-control:focus + .input-group-text,
.register-form .input-group-text:focus-within {
    border-color: #4CAF50;
}

.btn-success {
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

.password-requirements {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 0.5rem;
    border-left: 4px solid #4CAF50;
}

.benefit-item {
    padding: 1rem;
    border-radius: 0.5rem;
    background: linear-gradient(135deg, rgba(76, 175, 80, 0.05), rgba(33, 150, 243, 0.05));
    transition: transform 0.3s ease;
}

.benefit-item:hover {
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
    .register-card {
        padding: 2rem 1.5rem;
        margin: 1rem;
    }

    .school-logo .fa-4x {
        font-size: 3rem;
    }

    .row .col-md-6 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection