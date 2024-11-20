@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('kompetensi.update', $kompetensi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $kompetensi->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-control @error('mahasiswa_id') is-invalid @enderror">
                        <option value="">Pilih Mahasiswa</option>
                        @foreach($mahasiswas as $mahasiswa)
                        <option value="{{ $mahasiswa->mahasiswa_id }}" {{ old('mahasiswa_id', $kompetensi->mahasiswa_id) == $mahasiswa->mahasiswa_id ? 'selected' : '' }}>
                            {{ $mahasiswa->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('kompetensi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection