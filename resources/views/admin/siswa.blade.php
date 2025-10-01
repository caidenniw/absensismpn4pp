@extends('layouts.app')

@section('title', 'Manajemen Siswa')

@section('content')
<div class="container">
    <h1 class="mb-4">Manajemen Siswa</h1>

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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Siswa</span>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                </div>
                <div class="card-body">
                    <!-- Class Navigation -->
                    <div class="mb-4">
                        <h5>Pilih Kelas:</h5>
                        <div class="btn-group flex-wrap" role="group">
                            @foreach($kelasList as $kelas)
                                <a href="{{ route('admin.siswa.byclass', $kelas->id) }}"
                                   class="btn btn-outline-primary mb-2 {{ isset($selectedKelas) && $selectedKelas && $selectedKelas->id == $kelas->id ? 'active' : '' }}">
                                    {{ $kelas->nama_kelas }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Student List -->
                    @if($selectedKelas)
                        <h5 class="mt-4">Siswa Kelas: {{ $selectedKelas->nama_kelas }}</h5>
                        @if($siswa->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Siswa</th>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswa as $s)
                                            <tr>
                                                <td>{{ $s->nama_siswa }}</td>
                                                <td>{{ $s->nis }}</td>
                                                <td>{{ $s->nisn }}</td>
                                                <td>
                                                    <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Tidak ada siswa dalam kelas ini.</p>
                        @endif
                    @else
                        <p>Silakan pilih kelas untuk melihat daftar siswa.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection