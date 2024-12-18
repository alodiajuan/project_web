@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Data SDM</h3>
        </div>

        <div class="card-body">
            <form action="{{ url('/sdm') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                            required>
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">NIP/NIPPK</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username') }}" required>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            required>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="foto_profile" class="col-sm-2 col-form-label">Foto Profile</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" id="foto_profile" name="foto_profile">
                        @if (old('foto_profile'))
                            <p>Preview:</p>
                            <img src="{{ asset('images/' . old('foto_profile')) }}" alt="Foto Profile"
                                class="img-thumbnail mt-2" width="100">
                        @endif
                        @error('foto_profile')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="role" class="col-sm-2 col-form-label">Role User</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="role" name="role" required>
                            <option value="" selected disabled>Pilih Role User</option>
                            <option value="admin">Admin</option>
                            <option value="dosen">Dosen</option>
                            <option value="tendik">Tenaga Pendidik</option>
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-primary mt-3">Tambah</button>
                <a href="{{ url('/sdm') }}" class="btn btn-sm btn-secondary mt-3">Batal</a>
            </form>
        </div>
    </div>
@endsection
