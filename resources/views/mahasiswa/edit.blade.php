@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Data Mahasiswa</h3>
        </div>

        <div class="card-body">
            <form action="{{ url('/mahasiswa/update/' . $mahasiswa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ old('nama', $mahasiswa->nama) }}" required>
                        @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">NIM</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username', $mahasiswa->username) }}" required>
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="prodi_id" class="col-sm-2 col-form-label">Program Studi</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="prodi_id" name="prodi_id" required>
                            @foreach ($prodi as $prodiItem)
                                <option value="{{ $prodiItem->id }}"
                                    {{ old('prodi_id', $mahasiswa->id_prodi) == $prodiItem->id ? 'selected' : '' }}>
                                    {{ $prodiItem->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="foto_profile" class="col-sm-2 col-form-label">Foto Profile</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" id="foto_profile" name="foto_profile">
                        @if ($mahasiswa->foto_profile)
                            <img src="{{ asset($mahasiswa->foto_profile) }}" alt="Foto Profile"
                                class="img-thumbnail mt-2" width="100">
                        @else
                            <p>No Image</p>
                        @endif
                        @error('foto_profile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kompetensi_id" class="col-sm-2 col-form-label">Kompetensi</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="kompetensi_id" name="kompetensi_id" required>
                            @foreach ($kompetensi as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('kompetensi_id', $mahasiswa->id_kompetensi) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kompetensi_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="semester" class="col-sm-2 col-form-label">Semester</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="semester" name="semester"
                            value="{{ old('semester', $mahasiswa->semester) }}" required>
                        @error('semester')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alfa" class="col-sm-2 col-form-label">Alfa</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="alfa" name="alfa"
                            value="{{ old('alfa', $mahasiswa->alfa) }}" required>
                        @error('alfa')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="compensation" class="col-sm-2 col-form-label">Kompensasi</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="compensation" name="compensation"
                            value="{{ old('compensation', $mahasiswa->compensation) }}" required>
                        @error('compensation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation">
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-primary mt-3">Update</button>
                <a href="{{ url('/mahasiswa') }}" class="btn btn-sm btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
