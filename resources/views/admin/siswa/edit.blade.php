@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Siswa: {{ $siswa->nama_siswa }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label">Nama Siswa</label>
                            <input id="nama_siswa" type="text" class="form-control @error('nama_siswa') is-invalid @enderror" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required autocomplete="nama_siswa">
                            @error('nama_siswa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input id="nis" type="number" class="form-control @error('nis') is-invalid @enderror" name="nis" value="{{ old('nis', $siswa->nis) }}" required autocomplete="nis">
                            @error('nis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input id="nisn" type="number" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" required autocomplete="nisn">
                            @error('nisn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <div class="mt-3">
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Kembali ke Daftar Siswa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection