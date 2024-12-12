@extends('layouts.template')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header text-center bg-primary text-white py-4">
                    <h4>Edit Profil</h4>
                    <p>{{ $profile->mahasiswa_nama ?? $profile->sdm_nama }}</p>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <!-- Username -->
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input id="username" type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       name="username" value="{{ $profile->username }}" 
                                       required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama -->
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input id="nama" type="text" 
                                       class="form-control @error('mahasiswa_nama') is-invalid @enderror @error('sdm_nama') is-invalid @enderror"
                                       name="{{ $userType === 'mahasiswa' ? 'mahasiswa_nama' : 'sdm_nama' }}" 
                                       value="{{ $profile->mahasiswa_nama ?? $profile->sdm_nama }}" required>
                                @error('mahasiswa_nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('sdm_nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Conditional Fields -->
                        @if ($userType === 'mahasiswa')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input id="nim" type="text" 
                                           class="form-control @error('nim') is-invalid @enderror" 
                                           name="nim" value="{{ $profile->nim }}" required>
                                    @error('nim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="semester" class="form-label">Semester</label>
                                    <input id="semester" type="number" 
                                           class="form-control @error('semester') is-invalid @enderror" 
                                           name="semester" value="{{ $profile->semester }}" required>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @elseif ($userType === 'sdm')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input id="nip" type="text" 
                                           class="form-control @error('nip') is-invalid @enderror" 
                                           name="nip" value="{{ $profile->nip }}" required>
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_telepon" class="form-label">No. Telepon</label>
                                    <input id="no_telepon" type="text" 
                                           class="form-control @error('no_telepon') is-invalid @enderror" 
                                           name="no_telepon" value="{{ $profile->no_telepon }}" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Change Password -->
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <label for="old_password" class="form-label">Password Lama</label>
                                <input id="old_password" type="password" 
                                       class="form-control @error('old_password') is-invalid @enderror" 
                                       name="old_password">
                                @error('old_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Foto Profil -->
                        <div class="mb-4">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input id="foto" type="file" class="form-control" name="foto">
                            <small class="text-muted">Format: JPG, PNG, max. 2MB</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">Simpan</button>
                            <a href="{{ url('/') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Adjust form for better responsive layout */
.card-header {
    border-radius: 0.5rem 0.5rem 0 0;
}
.card {
    border-radius: 0.5rem;
}
@media (max-width: 768px) {
    .btn {
        width: 100%;
        margin-top: 0.5rem;
    }
}
</style>
@endsection
