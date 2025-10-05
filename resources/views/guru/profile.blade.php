@extends('layouts.app')

@section('title', 'Profil Guru - ' . Auth::user()->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="profile-header">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-edit fa-2x text-success me-3"></i>
                    <div>
                        <h1 class="h2 mb-0 fw-bold">Pengaturan Profil</h1>
                        <p class="text-muted mb-0">Kelola informasi pribadi dan foto profil Anda</p>
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

    <div class="row">
        <!-- Profile Preview -->
        <div class="col-lg-4 mb-4">
            <div class="profile-preview-card">
                <div class="card-header-custom">
                    <i class="fas fa-id-card me-2"></i>Preview Profil
                </div>
                <div class="card-body text-center p-4">
                    <div class="profile-avatar mb-3">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Foto Profil" class="profile-img" id="profile-preview">
                        @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="fw-bold mb-1" id="preview-name">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-0">
                        <i class="fas fa-envelope me-1"></i>{{ auth()->user()->email }}
                    </p>
                    <div class="role-badge mt-3">
                        <span class="badge bg-success">
                            <i class="fas fa-chalkboard-teacher me-1"></i>Guru
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="stats-card">
                <div class="card-header-custom">
                    <i class="fas fa-chart-bar me-2"></i>Statistik
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <i class="fas fa-calendar-check text-success"></i>
                        <span>Aktif sejak {{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-shield-alt text-info"></i>
                        <span>Akun terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="col-lg-8">
            <div class="profile-form-card">
                <div class="card-header-custom">
                    <i class="fas fa-edit me-2"></i>Edit Informasi Profil
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('guru.profile.update') }}" enctype="multipart/form-data" id="profile-form">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                       placeholder="Masukkan nama lengkap Anda">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Alamat Email
                                </label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                       placeholder="Masukkan email Anda">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Profile Picture -->
                        <div class="mb-4">
                            <label for="profile_picture" class="form-label fw-semibold">
                                <i class="fas fa-camera me-2 text-primary"></i>Foto Profil
                            </label>
                            <div class="file-upload-area">
                                <input class="form-control @error('profile_picture') is-invalid @enderror" type="file"
                                       id="profile_picture" name="profile_picture" accept="image/*"
                                       onchange="previewImage(this)">
                                <div class="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <p>Klik untuk memilih foto atau drag & drop</p>
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                </div>
                            </div>
                            @error('profile_picture')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Current Photo Display -->
                        @if(auth()->user()->profile_picture)
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Foto Profil Saat Ini</label>
                                <div class="current-photo">
                                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                                         alt="Foto Profil Saat Ini" class="current-photo-img">
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Upload foto baru untuk mengganti yang lama
                                    </small>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-success btn-lg fw-semibold">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-header {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.profile-preview-card, .stats-card, .profile-form-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: none;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.card-header-custom {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
    padding: 1rem 1.5rem;
    font-weight: 600;
    font-size: 1.1rem;
}

.profile-avatar {
    position: relative;
    display: inline-block;
}

.profile-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #4CAF50;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 4px solid #e9ecef;
}

.role-badge .badge {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-item i {
    width: 30px;
    margin-right: 1rem;
    font-size: 1.2rem;
}

.form-label {
    margin-bottom: 0.5rem;
}

.form-control {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
    transform: translateY(-2px);
}

.file-upload-area {
    position: relative;
    border: 2px dashed #4CAF50;
    border-radius: 0.5rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.file-upload-area:hover {
    background: #e8f5e8;
    border-color: #45a049;
}

.upload-placeholder {
    color: #6c757d;
}

.upload-placeholder i {
    color: #4CAF50;
}

.current-photo {
    display: inline-block;
}

.current-photo-img {
    max-width: 200px;
    height: auto;
    border-radius: 0.5rem;
    border: 2px solid #e9ecef;
}

.btn-success {
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

@media (max-width: 768px) {
    .profile-header {
        padding: 1.5rem;
    }

    .profile-img {
        width: 100px;
        height: 100px;
    }

    .avatar-placeholder {
        width: 100px;
        height: 100px;
    }

    .file-upload-area {
        padding: 1.5rem;
    }
}
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('profile-preview');
            if (preview) {
                preview.src = e.target.result;
            } else {
                // Create new preview if doesn't exist
                const avatarDiv = document.querySelector('.profile-avatar');
                avatarDiv.innerHTML = `<img src="${e.target.result}" alt="Preview" class="profile-img" id="profile-preview">`;
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// Update preview name when typing
document.getElementById('name').addEventListener('input', function() {
    document.getElementById('preview-name').textContent = this.value || 'Nama Anda';
});
</script>
@endsection