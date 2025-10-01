@extends('layouts.app')

@section('title', 'Dasbor Guru')

@section('content')
<div class="container">
    <h1 class="mb-4">Dasbor Guru</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            Pilih Kelas dan Mata Pelajaran untuk Memulai Absensi
        </div>
        <div class="card-body">
            <form action="{{ route('guru.absensi.show') }}" method="get">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <select name="kelas_id" class="form-select" required>
                            <option selected disabled>Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 mb-2">
                        <select name="mata_pelajaran_id" class="form-select" required>
                            <option selected disabled>Pilih Mata Pelajaran</option>
                            @foreach($mataPelajaran as $mp)
                                <option value="{{ $mp->id }}">{{ $mp->nama_pelajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Mulai</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection