@extends('layouts.app')

@section('title', 'Absensi - ' . $kelas->nama_kelas . ' - ' . $mataPelajaran->nama_pelajaran . ' - Jam ' . $request->jam_ke)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="absensi-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clipboard-check fa-2x text-success me-3"></i>
                        <div>
                            <h1 class="h2 mb-0 fw-bold">Absensi Siswa</h1>
                            <p class="text-muted mb-0">
                                <i class="fas fa-school me-1"></i>{{ $kelas->nama_kelas }} -
                                <i class="fas fa-book me-1"></i>{{ $mataPelajaran->nama_pelajaran }} -
                                <i class="fas fa-clock me-1"></i>Jam ke-{{ $request->jam_ke }}
                            </p>
                        </div>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Info -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="session-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-calendar-day text-primary me-2"></i>Sesi Absensi Hari Ini
                        </h5>
                        <p class="text-muted mb-0">{{ date('l, d F Y') }} - {{ date('H:i') }}</p>
                        @if($existingAbsensi->count() > 0)
                            <div class="mt-2">
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Absensi Sudah Dilakukan ({{ $existingAbsensi->count() }}/{{ $siswa->count() }} siswa)
                                </span>
                                <small class="text-muted ms-2">Anda dapat mengedit absensi yang salah tanpa kehilangan data sebelumnya</small>
                            </div>
                        @else
                            <div class="mt-2">
                                <span class="badge bg-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Absensi Belum Dilakukan
                                </span>
                                <small class="text-muted ms-2">Silakan isi absensi siswa untuk hari ini</small>
                            </div>
                        @endif
                    </div>
                    <div class="session-stats">
                        <span class="badge bg-primary fs-6">{{ $siswa->count() }} Siswa</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="quick-stats">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-text">
                            <span class="stat-number" id="hadir-count">0</span>
                            <span class="stat-label">Hadir</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <div class="stat-text">
                            <span class="stat-number" id="sakit-count">0</span>
                            <span class="stat-label">Sakit</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="stat-text">
                            <span class="stat-number" id="izin-count">0</span>
                            <span class="stat-label">Izin</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon bg-danger">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="stat-text">
                            <span class="stat-number" id="alpa-count">0</span>
                            <span class="stat-label">Alpa</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon bg-secondary">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="stat-text">
                            <span class="stat-number" id="cabut-count">0</span>
                            <span class="stat-label">Cabut</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="progress-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">Progress Absensi</span>
                    <span class="text-muted" id="progress-text">0 dari {{ $siswa->count() }} siswa</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" id="progress-bar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Absensi Form -->
    <div class="row">
        <div class="col-12">
            <div class="absensi-card" data-total-students="{{ $siswa->count() }}">
                <div class="card-header-custom">
                    <i class="fas fa-users me-2"></i>Daftar Siswa - {{ $kelas->nama_kelas }}
                </div>
                <div class="card-body p-0">
                    @if($siswa->count() > 0)
                        <form action="{{ route('guru.absensi.store') }}" method="post" id="absensi-form">
                            @csrf
                            <input type="hidden" name="mata_pelajaran_id" value="{{ $mataPelajaran->id }}">
                            <input type="hidden" name="jam_ke" value="{{ $request->jam_ke }}">

                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="absensi-table">
                                    <thead class="table-header">
                                        <tr>
                                            <th class="ps-4">
                                                <i class="fas fa-user me-2"></i>Nama Siswa
                                            </th>
                                            <th>
                                                <i class="fas fa-id-card me-2"></i>NIS
                                            </th>
                                            <th>
                                                <i class="fas fa-id-badge me-2"></i>NISN
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-check-circle text-success me-2"></i>Hadir
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-hospital text-warning me-2"></i>Sakit
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-envelope-open-text text-info me-2"></i>Izin
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-times text-danger me-2"></i>Alpa
                                            </th>
                                            <th class="text-center">
                                                <i class="fas fa-sign-out-alt text-secondary me-2"></i>Cabut
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswa as $s)
                                        <tr class="student-row" data-student-id="{{ $s->id }}">
                                            <td class="ps-4">
                                                <div class="student-info">
                                                    <div class="student-avatar">
                                                        <i class="fas fa-user-circle"></i>
                                                    </div>
                                                    <div class="student-details">
                                                        <div class="student-name fw-semibold">{{ $s->nama_siswa }}</div>
                                                        <small class="text-muted">Siswa</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-mono">{{ $s->nis }}</td>
                                            <td class="fw-mono">{{ $s->nisn }}</td>
                                            <td class="text-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                       name="absensi[{{ $s->id }}]" value="hadir"
                                                       {{ isset($existingAbsensi[$s->id]) && $existingAbsensi[$s->id]->status == 'hadir' ? 'checked' : (!isset($existingAbsensi[$s->id]) ? 'checked' : '') }}
                                                       data-status="hadir" data-student="{{ $s->id }}">
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                       name="absensi[{{ $s->id }}]" value="sakit"
                                                       {{ isset($existingAbsensi[$s->id]) && $existingAbsensi[$s->id]->status == 'sakit' ? 'checked' : '' }}
                                                       data-status="sakit" data-student="{{ $s->id }}">
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                       name="absensi[{{ $s->id }}]" value="izin"
                                                       {{ isset($existingAbsensi[$s->id]) && $existingAbsensi[$s->id]->status == 'izin' ? 'checked' : '' }}
                                                       data-status="izin" data-student="{{ $s->id }}">
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                       name="absensi[{{ $s->id }}]" value="alpa"
                                                       {{ isset($existingAbsensi[$s->id]) && $existingAbsensi[$s->id]->status == 'alpa' ? 'checked' : '' }}
                                                       data-status="alpa" data-student="{{ $s->id }}">
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input attendance-radio" type="radio"
                                                       name="absensi[{{ $s->id }}]" value="cabut"
                                                       {{ isset($existingAbsensi[$s->id]) && $existingAbsensi[$s->id]->status == 'cabut' ? 'checked' : '' }}
                                                       data-status="cabut" data-student="{{ $s->id }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Action Buttons -->
                            <div class="card-footer bg-light">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="bulk-actions">
                                            <button type="button" class="btn btn-outline-success btn-sm me-2" id="mark-all-hadir">
                                                <i class="fas fa-check-double me-1"></i>Tandai Semua Hadir
                                            </button>
                                            <button type="button" class="btn btn-outline-warning btn-sm" id="reset-all">
                                                <i class="fas fa-undo me-1"></i>Reset Semua
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <button type="submit" class="btn btn-primary btn-lg fw-semibold" id="save-btn">
                                            <i class="fas fa-save me-2"></i>Simpan Absensi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-users fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada siswa di kelas ini</h5>
                            <p class="text-muted">Silakan hubungi administrator untuk menambahkan data siswa</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.absensi-header {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.session-info {
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: none;
}

.quick-stats {
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    height: 100%;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 0.5rem;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 0.5rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.stat-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.stat-text {
    text-align: center;
    width: 100%;
}

.stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 0.25rem;
}

.stat-label {
    display: block;
    font-size: 0.7rem;
    color: #666;
    font-weight: 500;
}

.progress-card {
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.absensi-card {
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

.table-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.table-header th {
    border: none;
    font-weight: 600;
    color: #495057;
    padding: 1rem;
}

.student-row {
    transition: all 0.3s ease;
}

.student-row:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
}

.student-info {
    display: flex;
    align-items: center;
}

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
}

.student-details .student-name {
    font-size: 1rem;
    margin-bottom: 0.125rem;
}

.attendance-radio {
    transform: scale(1.2);
    transition: all 0.3s ease;
}

.attendance-radio:checked {
    background-color: #4CAF50;
    border-color: #4CAF50;
}

.card-footer {
    border-top: 1px solid #e9ecef;
}

.bulk-actions .btn {
    transition: all 0.3s ease;
}

.bulk-actions .btn:hover {
    transform: translateY(-2px);
}

#save-btn {
    transition: all 0.3s ease;
}

#save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

@media (max-width: 768px) {
.absensi-header {
    padding: 1.5rem;
}

.stats-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
}

    .student-info {
        flex-direction: column;
        text-align: center;
    }

    .student-avatar {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }

    .bulk-actions {
        margin-bottom: 1rem;
    }

    .bulk-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const attendanceRadios = document.querySelectorAll('.attendance-radio');
    const hadirCount = document.getElementById('hadir-count');
    const sakitCount = document.getElementById('sakit-count');
    const izinCount = document.getElementById('izin-count');
    const alpaCount = document.getElementById('alpa-count');
    const cabutCount = document.getElementById('cabut-count');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const absensiCard = document.querySelector('.absensi-card');
    const totalStudents = parseInt(absensiCard.dataset.totalStudents);
    const absensiForm = document.getElementById('absensi-form');

    function updateStats() {
        let hadir = 0, sakit = 0, izin = 0, alpa = 0, cabut = 0;

        attendanceRadios.forEach(radio => {
            if (radio.checked) {
                if (radio.dataset.status === 'hadir') hadir++;
                else if (radio.dataset.status === 'sakit') sakit++;
                else if (radio.dataset.status === 'izin') izin++;
                else if (radio.dataset.status === 'alpa') alpa++;
                else if (radio.dataset.status === 'cabut') cabut++;
            }
        });

        hadirCount.textContent = hadir;
        sakitCount.textContent = sakit;
        izinCount.textContent = izin;
        alpaCount.textContent = alpa;
        cabutCount.textContent = cabut;

        const progress = ((hadir + sakit + izin + alpa + cabut) / totalStudents) * 100;
        progressBar.style.width = progress + '%';
        progressText.textContent = (hadir + sakit + izin + alpa + cabut) + ' dari ' + totalStudents + ' siswa';
    }

    attendanceRadios.forEach(radio => {
        radio.addEventListener('change', updateStats);
    });

    // Mark all hadir
    document.getElementById('mark-all-hadir').addEventListener('click', function() {
        document.querySelectorAll('input[value="hadir"]').forEach(radio => {
            radio.checked = true;
        });
        updateStats();
    });

    // Reset all
    document.getElementById('reset-all').addEventListener('click', function() {
        document.querySelectorAll('input[value="hadir"]').forEach(radio => {
            radio.checked = true;
        });
        updateStats();
    });

    // Initial stats update
    updateStats();
});
</script>
@endsection