@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Guru: {{ $guru->name }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.guru.update', $guru->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $guru->name) }}" required autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $guru->email) }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas yang Diajar</label>
                            <div class="row">
                                @foreach($kelasList as $kelas)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kelas[]" value="{{ $kelas->id }}" id="kelas{{ $kelas->id }}" {{ $guru->kelas->contains($kelas->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kelas{{ $kelas->id }}">
                                                {{ $kelas->nama_kelas }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('kelas')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran yang Diajar</label>
                            <div class="row">
                                @foreach($mataPelajaranList as $mapel)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="mata_pelajaran[]" value="{{ $mapel->id }}" id="mapel{{ $mapel->id }}" {{ $guru->mataPelajaran->contains($mapel->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mapel{{ $mapel->id }}">
                                                {{ $mapel->nama_pelajaran }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('mata_pelajaran')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <div class="mt-3">
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Kembali ke Daftar Guru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection