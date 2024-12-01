@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($sdm)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('sdm') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/sdm/' . $sdm->sdm_id) }}" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama SDM</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="sdm_nama" name="sdm_nama"
                                value="{{ old('sdm_nama', $sdm->sdm_nama) }}" required>
                            @error('sdm_nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">NIP</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="nip" name="nip"
                                value="{{ old('nip', $sdm->nip) }}" required>
                            @error('nip')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Username</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username', $sdm->username) }}" required>
                            @error('username')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">No Telepon</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                                value="{{ old('no_telepon', $sdm->no_telepon) }}" required>
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
                                @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->prodi_id }}" {{ old('prodi_id', $sdm->prodi_id) == $prodi->prodi_id ? 'selected' : '' }}>
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
                                @foreach ($levels as $level)
                                    <option value="{{ $level->level_id }}" {{ old('level_id', $sdm->level_id) == $level->level_id ? 'selected' : '' }}>
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
                            @if($sdm->foto)
                                <img src="{{ $sdm->foto }}" alt="Current foto" class="mt-2" style="max-height: 100px">
                            @endif
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
            @endempty
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush