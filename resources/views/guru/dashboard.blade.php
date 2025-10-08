@extends('layouts.app')

@section('title', 'Dashboard Guru - Absensi SMPN 4')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="guru-header">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-chalkboard-teacher fa-2x text-success me-3"></i>
                    <div>
                        <h1 class="h2 mb-0 fw-bold">Dashboard Guru</h1>
                        <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}! Kelola absensi siswa dengan mudah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-school text-primary"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ $kelas->count() }}</h3>
                    <p class="stats-label">Kelas Diampu</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-book text-success"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ $mataPelajaran->count() }}</h3>
                    <p class="stats-label">Mata Pelajaran</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-calendar-check text-info"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ date('d') }}</h3>
                    <p class="stats-label">{{ date('F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Action Card -->
        <div class="col-lg-8 mb-4">
            <div class="action-card">
                <div class="card-header-custom">
                    <i class="fas fa-play-circle me-2"></i>Mulai Sesi Absensi
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-clipboard-check fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Pilih Kelas dan Mata Pelajaran</h5>
                        <p class="text-muted">Pilih kelas dan mata pelajaran untuk memulai pengambilan absensi siswa</p>
                    </div>

                    <form action="{{ route('guru.absensi.show') }}" method="get" class="absensi-form">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-school me-1 text-primary"></i>Kelas
                                </label>
                                <select name="kelas_id" class="form-select form-select-lg" required>
                                    <option selected disabled>Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-book me-1 text-success"></i>Mata Pelajaran
                                </label>
                                <select name="mata_pelajaran_id" class="form-select form-select-lg" required>
                                    <option selected disabled>Pilih Mata Pelajaran</option>
                                    @foreach($mataPelajaran as $mp)
                                    <option value="{{ $mp->id }}">{{ $mp->nama_pelajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-grid">
                                <label class="form-label fw-semibold opacity-0">Action</label>
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                    <i class="fas fa-play me-2"></i>Mulai
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="quick-actions">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat
                        </h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <a href="{{ route('guru.absensi.show') }}" class="btn btn-outline-success w-100">
                                    <i class="fas fa-list me-2"></i>Lihat Riwayat Absensi
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('guru.profile') }}" class="btn btn-outline-info w-100">
                                    <i class="fas fa-user-edit me-2"></i>Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-lg-4">
            <!-- Today's Schedule -->
            <div class="info-card mb-4">
                <div class="card-header-custom">
                    <i class="fas fa-calendar-day me-2"></i>Jadwal Hari Ini
                </div>
                <div class="card-body">
                    <div class="schedule-item">
                        <div class="schedule-time">
                            <i class="fas fa-clock text-primary"></i>
                            <span>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }}</span>
                        </div>
                        <div class="schedule-content">
                            <h6 class="mb-1">Sesi Absensi Aktif</h6>
                            <small class="text-muted">Sistem siap digunakan</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="info-card">
                <div class="card-header-custom">
                    <i class="fas fa-lightbulb me-2"></i>Tips Penggunaan
                </div>
                <div class="card-body">
                    <div class="tips-list">
                        <div class="tip-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Pilih kelas dan mata pelajaran dengan benar</small>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Verifikasi kehadiran siswa secara akurat</small>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Simpan data absensi setelah selesai</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .guru-header {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: none;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(33, 150, 243, 0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: bold;
        margin: 0;
        color: #333;
    }

    .stats-label {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    .action-card,
    .info-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        color: white;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .absensi-form .form-select {
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .absensi-form .form-select:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        transform: translateY(-2px);
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
    }

    .quick-actions {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .schedule-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .schedule-time {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-right: 1rem;
    }

    .schedule-time i {
        font-size: 1.2rem;
        margin-bottom: 0.25rem;
    }

    .schedule-content h6 {
        margin: 0;
        font-weight: 600;
    }

    .tips-list .tip-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .tips-list .tip-item:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .guru-header {
            padding: 1.5rem;
        }

        .absensi-form .row {
            flex-direction: column;
        }

        .absensi-form .col-md-2 {
            margin-top: 1rem;
        }
    }
</style>
@endsection