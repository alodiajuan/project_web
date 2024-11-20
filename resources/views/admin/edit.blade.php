@extends('layouts.template')
@section('content')
   <div class="card card-outline card-primary">
       <div class="card-header">
           <h3 class="card-title">{{ $page->title }}</h3>
           <div class="card-tools"></div>
       </div>
       <div class="card-body">
           @empty($admin)
               <div class="alert alert-danger alert-dismissible">
                   <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                   Data yang Anda cari tidak ditemukan.
               </div>
               <a href="{{ url('admin') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
           @else
               <form method="POST" action="{{ url('/admin/' . $admin->admin_id) }}" class="form-horizontal">
                   @csrf
                   @method('PUT')
                   <div class="form-group row">
                       <label class="col-1 control-label col-form-label">Nama Admin</label>
                       <div class="col-11">
                           <input type="text" class="form-control" id="admin_nama" name="admin_nama" value="{{ old('admin_nama', $admin->admin_nama) }}" required>
                           @error('admin_nama')
                               <small class="form-text text-danger">{{ $message }}</small>
                           @enderror
                       </div>
                   </div>
                   <div class="form-group row">
                       <label class="col-1 control-label col-form-label">NIP</label>
                       <div class="col-11">
                           <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $admin->nip) }}" required>
                           @error('nip')
                               <small class="form-text text-danger">{{ $message }}</small>
                           @enderror
                       </div>
                   </div>
                   <div class="form-group row">
                       <label class="col-1 control-label col-form-label">Username</label>
                       <div class="col-11">
                           <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $admin->username) }}" required>
                           @error('username')
                               <small class="form-text text-danger">{{ $message }}</small>
                           @enderror
                       </div>
                   </div>
                   <div class="form-group row">
                       <label class="col-1 control-label col-form-label">No Telepon</label>
                       <div class="col-11">
                           <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $admin->no_telepon) }}" required>
                           @error('no_telepon')
                               <small class="form-text text-danger">{{ $message }}</small>
                           @enderror
                       </div>
                   </div>
                   <div class="form-group row">
                       <label class="col-1 control-label col-form-label">Prodi</label>
                       <div class="col-11">
                           <select class="form-control" id="prodi_id" name="prodi_id" required>
                               <!-- Add prodi options -->
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
                               <!-- Add level options -->
                           </select>
                           @error('level_id')
                               <small class="form-text text-danger">{{ $message }}</small>
                           @enderror
                       </div>
                   </div>
                   <div class="form-group row">
                       <label class="col-1 control-label col-form-label"></label>
                       <div class="col-11">
                           <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                           <a class="btn btn-sm btn-default ml-1" href="{{ url('admin') }}">Kembali</a>
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