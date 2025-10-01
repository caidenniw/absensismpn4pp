@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dasbor Admin</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Tambah Data</div>
                <div class="card-body">
                    <form action="{{ route('admin.kelas.store') }}" method="post" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="nama_kelas" class="form-control" placeholder="Nama Kelas Baru" required>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                    <form action="{{ route('admin.matapelajaran.store') }}" method="post" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="nama_pelajaran" class="form-control" placeholder="Mata Pelajaran Baru" required>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                    <form action="{{ route('admin.siswa.store') }}" method="post">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="nama_siswa" class="form-control" placeholder="Nama Siswa Baru" required>
                        </div>
                        <div class="mb-2">
                            <input type="number" name="nis" class="form-control" placeholder="NIS" required>
                        </div>
                        <div class="mb-2">
                            <input type="number" name="nisn" class="form-control" placeholder="NISN" required>
                        </div>
                        <div class="input-group">
                            <select name="kelas_id" class="form-select" required>
                                <option selected disabled>Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Unduh Laporan PDF</div>
                <div class="card-body">
                    <form action="{{ route('pdf.absensi') }}" method="get" target="_blank">
                        <div class="mb-2">
                            <select name="kelas_id" class="form-select" required>
                                <option selected disabled>Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <select name="mata_pelajaran_id" class="form-select" required>
                                <option selected disabled>Pilih Mata Pelajaran</option>
                                @foreach($mataPelajaran as $mp)
                                    <option value="{{ $mp->id }}">{{ $mp->nama_pelajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Unduh PDF</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="kelas-tab" data-bs-toggle="tab" data-bs-target="#kelas" type="button" role="tab" aria-controls="kelas" aria-selected="true">Kelas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="matapelajaran-tab" data-bs-toggle="tab" data-bs-target="#matapelajaran" type="button" role="tab" aria-controls="matapelajaran" aria-selected="false">Mata Pelajaran</button>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="{{ route('admin.siswa.index') }}">Siswa</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" href="{{ route('admin.guru.index') }}">Guru</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kelas" role="tabpanel" aria-labelledby="kelas-tab">
                    <ul class="list-group list-group-flush">
                        @foreach($kelas as $k)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $k->nama_kelas }}
                                <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="matapelajaran" role="tabpanel" aria-labelledby="matapelajaran-tab">
                    <ul class="list-group list-group-flush">
                        @foreach($mataPelajaran as $mp)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $mp->nama_pelajaran }}
                                <form action="{{ route('admin.matapelajaran.destroy', $mp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection