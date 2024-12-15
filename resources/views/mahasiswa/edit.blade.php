{{-- @extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Mahasiswa</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($mahasiswa)
                <div>
                    Data sedang kosong...
                </div>
            @else
                <form method="POST" action="{{ url('/mahasiswa/' . $mahasiswa->mahasiswa_id) }}" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Program Studi</label>
                        <div class="col-10">
                            <select class="form-control" id="prodi_id" name="prodi_id" required>
                                <option value="">- Pilih Program Studi -</option>
                                @foreach ($prodi as $item)
                                    <option value="{{ $item->prodi_id }}" @if ($item->prodi_id == $mahasiswa->prodi_id) selected @endif>
                                        {{ $item->prodi_nama }}</option>
                                @endforeach
                            </select>
                            @error('prodi_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Level</label>
                        <div class="col-10">
                            <select class="form-control" id="level_id" name="level_id">
                                <option value="">- Pilih Level -</option>
                                @foreach ($level as $item)
                                    <option value="{{ $item->level_id }}" @if ($item->level_id == $mahasiswa->level_id) selected @endif>
                                        {{ $item->level_nama }}</option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Kompetensi</label>
                        <div class="col-10">
                            <select class="form-control" id="kompetensi_id" name="kompetensi_id">
                                <option value="">- Pilih Kompetensi -</option>
                                @foreach ($kompetensi as $item)
                                    <option value="{{ $item->kompetensi_id }}"
                                        @if ($item->kompetensi_id == $mahasiswa->kompetensi_id) selected @endif>
                                        {{ $item->kompetensi_nama }}</option>
                                @endforeach
                            </select>
                            @error('kompetensi_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">NIM</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="nim" name="nim"
                                value="{{ old('nim', $mahasiswa->nim) }}" required>
                            @error('nim')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Nama Mahasiswa</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="mahasiswa_nama" name="mahasiswa_nama"
                                value="{{ old('mahasiswa_nama', $mahasiswa->mahasiswa_nama) }}" required>
                            @error('mahasiswa_nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Username</label>
                        <div class="col-10">
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username', $mahasiswa->username) }}">
                            @error('username')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Password</label>
                        <div class="col-10">
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @else
                                <small class="form-text text-muted">Abaikan (jangan diisi) jika tidak ingin
                                    mengganti password.</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Semester</label>
                        <div class="col-10">
                            <input type="number" class="form-control" id="semester" name="semester"
                                value="{{ old('semester', $mahasiswa->semester) }}" min="1" max="14">
                            @error('semester')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label">Foto</label>
                        <div class="col-10">
                            <input type="file" class="form-control" id="foto" name="foto" accept=".png,.jpg,.jpeg">
                            @error('foto')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @else
                                <small class="form-text text-muted">Abaikan (jangan diisi) jika tidak ingin
                                    mengganti foto.</small>
                            @enderror
                            @if ($mahasiswa->foto)
                                <div class="mt-2">
                                    <img src="{{ $mahasiswa->foto }}" alt="Foto Mahasiswa" class="img-thumbnail"
                                        style="max-height: 200px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 control-label col-form-label"></label>
                        <div class="col-10">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('mahasiswa') }}">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
    <!-- Additional CSS -->
@endpush

@push('js')
    <!-- Additional JavaScript -->
@endpush --}}
