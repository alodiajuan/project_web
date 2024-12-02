@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('tugas') }}" class="btn btn-sm btn-default">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            @empty($tugas)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('tugas') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/tugas/' . $tugas->tugas_id) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode Tugas</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="tugas_kode" name="tugas_kode"
                                value="{{ old('tugas_kode', $tugas->tugas_kode) }}" required>
                            @error('tugas_kode')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama Tugas</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="tugas_nama" name="tugas_nama"
                                value="{{ old('tugas_nama', $tugas->tugas_nama) }}" required>
                            @error('tugas_nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kategori</label>
                        <div class="col-11">
                            <select class="form-control" id="kategori_id" name="kategori_id" required>
                                <option value="">- Pilih Kategori -</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->kategori_id }}"
                                        {{ old('kategori_id', $tugas->kategori_id) == $k->kategori_id ? 'selected' : '' }}>
                                        {{ $k->kategori_nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Jam Kompen</label>
                        <div class="col-11">
                            <input type="number" class="form-control" id="jam_kompen" name="jam_kompen"
                                value="{{ old('jam_kompen', $tugas->jam_kompen) }}" required>
                            @error('jam_kompen')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Status</label>
                        <div class="col-11">
                            <select class="form-control" id="status_dibuka" name="status_dibuka" required>
                                <option value="1" {{ old('status_dibuka', $tugas->status_dibuka) ? 'selected' : '' }}>
                                    Dibuka</option>
                                <option value="0" {{ !old('status_dibuka', $tugas->status_dibuka) ? 'selected' : '' }}>
                                    Ditutup</option>
                            </select>
                            @error('status_dibuka')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('tugas') }}">Kembali</a>
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
