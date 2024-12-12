@extends('layouts.template')
@section('content')
   <div class="card card-outline card-primary">
       <div class="card-header">
           <h3 class="card-title">{{ $page->title }}</h3>
           <div class="card-tools"></div>
       </div>
       <div class="card-body">
           <form method="POST" action="{{ route('mahasiswa.store') }}" class="form-horizontal" enctype="multipart/form-data">
               @csrf
               <div class="form-group row">
                   <label class="col-1 control-label col-form-label">Nama Mahasiswa</label>
                   <div class="col-11">
                       <input type="text" class="form-control" id="mahasiswa_nama" name="mahasiswa_nama" value="{{ old('mahasiswa_nama') }}" required>
                       @error('mahasiswa_nama')
                           <small class="form-text text-danger">{{ $message }}</small>
                       @enderror
                   </div>
               </div>

               <div class="form-group row">
                   <label class="col-1 control-label col-form-label">NIM</label>
                   <div class="col-11">
                       <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}" required>
                       @error('nim')
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
                   <label class="col-1 control-label col-form-label">Semester</label>
                   <div class="col-11">
                       <input type="number" class="form-control" id="semester" name="semester" value="{{ old('semester') }}" min="1" max="14" required>
                       @error('semester')
                           <small class="form-text text-danger">{{ $message }}</small>
                       @enderror
                   </div>
               </div>

               <div class="form-group row">
                   <label class="col-1 control-label col-form-label">Prodi</label>
                   <div class="col-11">
                       <select class="form-control" id="prodi_id" name="prodi_id" required>
                           <option value="">- Pilih Prodi -</option>
                           @foreach($prodi as $p)
                               <option value="{{ $p->prodi_id }}" {{ old('prodi_id') == $p->prodi_id ? 'selected' : '' }}>
                                   {{ $p->prodi_nama }}
                               </option>
                           @endforeach
                       </select>
                       @error('prodi_id')
                           <small class="form-text text-danger">{{ $message }}</small>
                       @enderror
                   </div>
               </div>

               <div class="form-group row">
                   <label class="col-1 control-label col-form-label">Kompetensi</label>
                   <div class="col-11">
                       <select class="form-control" id="kompetensi_id" name="kompetensi_id" required>
                           <option value="">- Pilih Kompetensi -</option>
                           @foreach($kompetensi as $k)
                               <option value="{{ $k->kompetensi_id }}" {{ old('kompetensi_id') == $k->kompetensi_id ? 'selected' : '' }}>
                                   {{ $k->kompetensi_nama }}
                               </option>
                           @endforeach
                       </select>
                       @error('kompetensi_id')
                           <small class="form-text text-danger">{{ $message }}</small>
                       @enderror
                   </div>
               </div>

               <div class="form-group row">
                   <label class="col-1 control-label col-form-label">Level</label>  
                   <div class="col-11">
                       <select class="form-control" id="level_id" name="level_id" required>
                           <option value="">- Pilih Level -</option>
                           @foreach($level as $l)
                               <option value="{{ $l->level_id }}" {{ old('level_id') == $l->level_id ? 'selected' : '' }}>
                                   {{ $l->level_nama }}
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
                       <input type="file" class="form-control" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg">
                       <small class="form-text text-muted">Format: jpg, jpeg, png. Maksimal 2MB</small>
                       @error('foto')
                           <small class="form-text text-danger">{{ $message }}</small>
                       @enderror
                   </div>
               </div>

               <div class="form-group row">
                   <label class="col-1 control-label col-form-label"></label>
                   <div class="col-11">
                       <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                       <a class="btn btn-sm btn-default ml-1" href="{{ url('mahasiswa') }}">Kembali</a>
                   </div>
               </div>
           </form>
       </div>
   </div>
@endsection