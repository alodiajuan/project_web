@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Profil</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('/profile/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center mb-4">
                    <img src="{{ asset($user->foto_profile) }}" alt="Foto Profil" class="img-thumbnail"
                        style="max-width: 150px;">
                    <div class="form-group mt-3">
                        <label for="foto_profile">Ganti Foto Profil</label>
                        <input type="file" name="foto_profile"
                            class="form-control @error('foto_profile') is-invalid @enderror" id="foto_profile">
                        @error('foto_profile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        id="nama" value="{{ $user->nama }}" required>
                    @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                        id="username" value="{{ $user->username }}" required>
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @if ($role === 'mahasiswa')
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <input type="number" name="semester" class="form-control @error('semester') is-invalid @enderror"
                            id="semester" value="{{ $user->semester }}">
                        @error('semester')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_kompetensi">Kompetensi</label>
                        <select name="id_kompetensi" class="form-control @error('id_kompetensi') is-invalid @enderror"
                            id="id_kompetensi">
                            <option value="">Pilih Kompetensi</option>
                            @foreach ($kompetensi as $kompeten)
                                <option value="{{ $kompeten->id }}"
                                    {{ $user->id_kompetensi === $kompeten->id ? 'selected' : '' }}>{{ $kompeten->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kompetensi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_prodi">Program Studi</label>
                        <select name="id_prodi" class="form-control @error('id_prodi') is-invalid @enderror" id="id_prodi">
                            <option value="">Pilih Program Studi</option>
                            @foreach ($prodi as $program)
                                <option value="{{ $program->id }}"
                                    {{ $user->id_prodi === $program->id ? 'selected' : '' }}>{{ $program->nama }}</option>
                            @endforeach
                        </select>
                        @error('id_prodi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <div class="form-group">
                    <label for="password">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
