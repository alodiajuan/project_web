@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('/prodi/update/' . $prodi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Program Studi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $prodi->nama }}" required>
                        @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ url('/prodi') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
