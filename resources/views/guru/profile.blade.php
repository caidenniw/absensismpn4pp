@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Profil Guru</div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('guru.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Foto Profil</label>
                        <input class="form-control" type="file" id="profile_picture" name="profile_picture">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Foto Profil" class="img-thumbnail mt-2" width="150">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui Profil</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection