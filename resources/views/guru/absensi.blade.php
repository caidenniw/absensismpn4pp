@extends('layouts.app')

@section('title', 'Form Absensi')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3>Absensi Kelas: {{ $kelas->nama_kelas }}</h3>
            <h5>Mata Pelajaran: {{ $mataPelajaran->nama_pelajaran }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.absensi.store') }}" method="post">
                @csrf
                <input type="hidden" name="mata_pelajaran_id" value="{{ $mataPelajaran->id }}">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">NIS</th>
                            <th scope="col">NISN</th>
                            <th scope="col" class="text-center">Hadir</th>
                            <th scope="col" class="text-center">Sakit</th>
                            <th scope="col" class="text-center">Izin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                        <tr>
                            <td>{{ $s->nama_siswa }}</td>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nisn }}</td>
                            <td class="text-center"><input class="form-check-input" type="radio" name="absensi[{{ $s->id }}]" value="hadir" checked></td>
                            <td class="text-center"><input class="form-check-input" type="radio" name="absensi[{{ $s->id }}]" value="sakit"></td>
                            <td class="text-center"><input class="form-check-input" type="radio" name="absensi[{{ $s->id }}]" value="izin"></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada siswa di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Simpan Absensi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection