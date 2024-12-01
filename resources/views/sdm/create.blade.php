@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('sdm') }}" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama SDM</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="sdm_nama" name="sdm_nama" value="{{ old('sdm_nama') }}" required>
                        @error('sdm_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">NIP</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}" required>
                        @error('nip')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Username</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Password</label>
                    <div class="col-11">
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">No Telepon</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                        @error('no_telepon')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Prodi</label>
                    <div class="col-11">
                        <select class="form-control" id="prodi_id" name="prodi_id" required>
                            <option value="">- Pilih Prodi -</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->prodi_id }}" {{ old('prodi_id') == $prodi->prodi_id ? 'selected' : '' }}>
                                    {{ $prodi->prodi_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Level</label>
                    <div class="col-11">
                        <select class="form-control" id="level_id" name="level_id" required>
                            <option value="">- Pilih Level -</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                                    {{ $level->level_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Foto</label>
                    <div class="col-11">
                        <input type="file" class="form-control" id="foto" name="foto">
                        @error('foto')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('sdm') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush