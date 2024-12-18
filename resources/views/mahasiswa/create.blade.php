@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Data Mahasiswa</h3>
        </div>

        <div class="card-body">
            <form action="{{ url('/mahasiswa') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="username" class="col-sm-2 col-form-label">NIM</label>
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
                    <label for="prodi_id" class="col-sm-2 col-form-label">Program Studi</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="prodi_id" name="prodi_id" required>
                            <option value="" selected disabled>Pilih Program Studi</option>
                            @foreach ($prodi as $prodiItem)
                                <option value="{{ $prodiItem->id }}"
                                    {{ old('prodi_id') == $prodiItem->id ? 'selected' : '' }}>
                                    {{ $prodiItem->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
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
                    <label for="kompetensi_id" class="col-sm-2 col-form-label">Kompetensi</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="kompetensi_id" name="kompetensi_id" required>
                            <option value="" selected disabled>Pilih Kompetensi</option>
                            @foreach ($kompetensi as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('kompetensi_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kompetensi_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="semester" class="col-sm-2 col-form-label">Semester</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="semester" name="semester"
                            value="{{ old('semester') }}" required>
                        @error('semester')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alfa" class="col-sm-2 col-form-label">Alfa</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="alfa" name="alfa"
                            value="{{ old('alfa') }}" required>
                        @error('alfa')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="compensation" class="col-sm-2 col-form-label">Kompensasi</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="compensation" name="compensation"
                            value="{{ old('compensation') }}" required>
                        @error('compensation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-primary mt-3">Tambah</button>
                <a href="{{ url('/mahasiswa') }}" class="btn btn-sm btn-secondary mt-3">Batal</a>
            </form>
        </div>
    </div>
@endsection
