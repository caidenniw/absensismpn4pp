@extends('layouts.app')

@section('title', 'Dashboard Admin - Absensi SMPN 4')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-header">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-tachometer-alt fa-2x text-primary me-3"></i>
                    <div>
                        <h1 class="h2 mb-0 fw-bold">Dashboard Administrator</h1>
                        <p class="text-muted mb-0">Kelola sistem absensi SMPN 4 dengan mudah</p>
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
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-users text-primary"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ $kelas->count() }}</h3>
                    <p class="stats-label">Total Kelas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-user-graduate text-info"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ collect($siswaPerKelas)->flatten()->count() }}</h3>
                    <p class="stats-label">Total Siswa</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-chalkboard-teacher text-warning"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ \App\Models\User::where('role', 'guru')->count() }}</h3>
                    <p class="stats-label">Total Guru</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="action-card">
                <div class="card-header-custom">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Data Baru
                </div>
                <div class="card-body p-4">
                    <!-- Add Class -->
                    <div class="action-item mb-3">
                        <form action="{{ route('admin.kelas.store') }}" method="post" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="nama_kelas" class="form-control" placeholder="Nama Kelas Baru" required>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Add Subject -->
                    <div class="action-item mb-3">
                        <form action="{{ route('admin.matapelajaran.store') }}" method="post" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="nama_pelajaran" class="form-control" placeholder="Mata Pelajaran Baru" required>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Add Student -->
                    <div class="action-item">
                        <button class="btn btn-outline-primary w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#addStudentForm">
                            <i class="fas fa-user-plus me-2"></i>Tambah Siswa
                        </button>
                        <div class="collapse" id="addStudentForm">
                            <form action="{{ route('admin.siswa.store') }}" method="post" class="mt-3">
                                @csrf
                                <div class="mb-2">
                                    <input type="text" name="nama_siswa" class="form-control form-control-sm" placeholder="Nama Siswa" required>
                                </div>
                                <div class="mb-2">
                                    <input type="number" name="nis" class="form-control form-control-sm" placeholder="NIS" required>
                                </div>
                                <div class="mb-2">
                                    <input type="number" name="nisn" class="form-control form-control-sm" placeholder="NISN" required>
                                </div>
                                <div class="mb-3">
                                    <select name="kelas_id" class="form-select form-select-sm" required>
                                        <option selected disabled>Pilih Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-save me-1"></i>Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDF Report -->
            <div class="action-card">
                <div class="card-header-custom">
                    <i class="fas fa-file-pdf me-2"></i>Laporan PDF
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pdf.absensi') }}" method="get" target="_blank">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Kelas</label>
                            <select name="kelas_id" class="form-select form-select-sm" required>
                                <option selected disabled>Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" class="form-select form-select-sm" required>
                                <option selected disabled>Pilih Mata Pelajaran</option>
                                @foreach($mataPelajaran as $mp)
                                    <option value="{{ $mp->id }}">{{ $mp->nama_pelajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control form-control-sm" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-download me-2"></i>Unduh Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Management -->
        <div class="col-lg-8">
            <div class="data-card">
                <div class="card-header-custom">
                    <i class="fas fa-database me-2"></i>Kelola Data
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills nav-fill mb-3 px-4 pt-3" id="dataTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="kelas-tab" data-bs-toggle="pill" data-bs-target="#kelas" type="button" role="tab">
                                <i class="fas fa-school me-1"></i>Kelas ({{ $kelas->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="matapelajaran-tab" data-bs-toggle="pill" data-bs-target="#matapelajaran" type="button" role="tab">
                                <i class="fas fa-book me-1"></i>Mata Pelajaran ({{ $mataPelajaran->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('admin.siswa.index') }}">
                                <i class="fas fa-user-graduate me-1"></i>Siswa
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('admin.guru.index') }}">
                                <i class="fas fa-chalkboard-teacher me-1"></i>Guru
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content px-4 pb-4">
                        <div class="tab-pane fade show active" id="kelas" role="tabpanel">
                            <div class="data-list">
                                @forelse($kelas as $k)
                                    <div class="data-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-school text-primary me-3"></i>
                                            <span class="fw-semibold">{{ $k->nama_kelas }}</span>
                                        </div>
                                        <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-muted">
                                        <i class="fas fa-school fa-2x mb-2"></i>
                                        <p>Belum ada data kelas</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="tab-pane fade" id="matapelajaran" role="tabpanel">
                            <div class="data-list">
                                @forelse($mataPelajaran as $mp)
                                    <div class="data-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-book text-success me-3"></i>
                                            <span class="fw-semibold">{{ $mp->nama_pelajaran }}</span>
                                        </div>
                                        <form action="{{ route('admin.matapelajaran.destroy', $mp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-muted">
                                        <i class="fas fa-book fa-2x mb-2"></i>
                                        <p>Belum ada data mata pelajaran</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.stats-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: none;
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
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

.action-card, .data-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
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

.action-item {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 0.75rem;
}

.data-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.3s ease;
}

.data-item:hover {
    background-color: #f8f9fa;
}

.data-item:last-child {
    border-bottom: none;
}

.nav-pills .nav-link {
    border-radius: 0.5rem;
    margin: 0 0.25rem;
    font-weight: 500;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    border: none;
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem;
    }

    .stats-card {
        margin-bottom: 1rem;
    }

    .action-item form {
        flex-direction: column;
    }

    .action-item form .btn {
        margin-top: 0.5rem;
    }
}
</style>
@endsection