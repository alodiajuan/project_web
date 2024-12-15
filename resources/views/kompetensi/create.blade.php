@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Kompetensi</h3>
        </div>

        <div class="card-body">
            <form action="{{ url('/kompetensi') }}" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Kompetensi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                        @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-primary mt-3">Simpan</button>
                <a href="{{ url('/kompetensi') }}" class="btn btn-sm btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection