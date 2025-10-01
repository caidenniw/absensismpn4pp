@extends('layouts.app')

@section('title', 'Kelola Guru')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Guru</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gurus as $guru)
                                    <tr>
                                        <td>{{ $guru->name }}</td>
                                        <td>{{ $guru->email }}</td>
                                        <td>
                                            @if($guru->kelas->count() > 0)
                                                <ul class="list-unstyled">
                                                    @foreach($guru->kelas as $kelas)
                                                        <li>{{ $kelas->nama_kelas }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($guru->mataPelajaran->count() > 0)
                                                <ul class="list-unstyled">
                                                    @foreach($guru->mataPelajaran as $mapel)
                                                        <li>{{ $mapel->nama_pelajaran }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $guru->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada guru yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah Guru Baru</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection