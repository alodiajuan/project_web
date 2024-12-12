@empty($tugas)
   <div id="modal-master" class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Kesalahan</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               <div class="alert alert-danger">
                   <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                   Data yang anda cari tidak ditemukan
               </div>
               <a href="{{ url('/tugas') }}" class="btn btn-warning">Kembali</a>
           </div>
       </div>
   </div>
@else
   <form action="{{ url('/tugas/' . $tugas->tugas_id . '/update_ajax') }}" method="POST" id="form-edit">
       @csrf
       @method('PUT')
       <div id="modal-master" class="modal-dialog modal-lg" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Edit Data Tugas</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   <div class="form-group">
                       <label>Kode Tugas</label>
                       <input value="{{ $tugas->tugas_kode }}" type="text" name="tugas_kode" id="tugas_kode" 
                           class="form-control" required>
                       <small id="error-tugas_kode" class="error-text form-text text-danger"></small>
                   </div>
                   <div class="form-group">
                       <label>Nama Tugas</label>
                       <input value="{{ $tugas->tugas_nama }}" type="text" name="tugas_nama" id="tugas_nama"
                           class="form-control" required>
                       <small id="error-tugas_nama" class="error-text form-text text-danger"></small>
                   </div>
                   <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ $tugas->deskripsi }}</textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                   <div class="form-group">
                    <label>Jam Kompen</label>
                    <input value="{{ $tugas->jam_kompen }}" type="number" name="jam_kompen" id="jam_kompen"
                        class="form-control" required>
                    <small id="error-jam_kompen" class="error-text form-text text-danger"></small>
                </div>
                   <div class="form-group">
                       <label>Kategori</label>
                       <select name="kategori_id" id="kategori_id" class="form-control" required>
                           <option value="">- Pilih Kategori -</option>
                           @foreach($kategori as $k)
                               <option value="{{ $k->kategori_id }}" {{ $tugas->kategori_id == $k->kategori_id ? 'selected' : '' }}>
                                   {{ $k->kategori_nama }}
                               </option>
                           @endforeach
                       </select>
                       <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                   </div>
                   <div class="form-group">
                    <label>SDM</label>
                    <select name="sdm_id" id="sdm_id" class="form-control" required>
                        <option value="">- Pilih SDM -</option>
                        @foreach($sdm as $s)
                            <option value="{{ $s->sdm_id }}" {{ $tugas->sdm_id == $s->sdm_id ? 'selected' : '' }}>
                                {{ $s->sdm_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-sdm_id" class="error-text form-text text-danger"></small>
                </div>
                   <div class="form-group">
                       <label>Status</label>
                       <select name="status_dibuka" id="status_dibuka" class="form-control" required>
                        <option value="dibuka" {{ $tugas->status_dibuka == 'dibuka' ? 'selected' : '' }}>Dibuka</option>
                        <option value="ditutup" {{ $tugas->status_dibuka == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                                      
                       <small id="error-status_dibuka" class="error-text form-text text-danger"></small>
                   </div>
                   <div class="form-group">
                       <label>Tanggal Mulai</label>
                       <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" 
                           value="{{ date('Y-m-d', strtotime($tugas->tanggal_mulai)) }}" required>
                       <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                   </div>
                   <div class="form-group">
                       <label>Tanggal Akhir</label>  
                       <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                           value="{{ date('Y-m-d', strtotime($tugas->tanggal_akhir)) }}" required>
                       <small id="error-tanggal_akhir" class="error-text form-text text-danger"></small>
                   </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                   <button type="submit" class="btn btn-primary">Simpan</button>
               </div>
           </div>
       </div>
   </form>

   <script>
       $(document).ready(function() {
           $("#form-edit").validate({
               rules: {
                   tugas_kode: {
                       required: true,
                       minlength: 3
                   },
                   tugas_nama: {
                       required: true
                   },
                   deskripsi: {
                       required: true
                   },
                   jam_kompen: {
                       required: true,
                       number: true
                   },
                   kategori_id: {
                       required: true
                   },
                   sdm_id: {
                       required: true
                   },
                   status_dibuka: {
                       required: true
                   },
                   tanggal_mulai: {
                       required: true,
                       date: true
                   },
                   tanggal_akhir: {
                       required: true,
                       date: true
                   }
               },
               messages: {
                   tugas_kode: {
                       required: "Kode tugas harus diisi",
                       minlength: "Kode tugas minimal 3 karakter"
                   },
                   tugas_nama: {
                       required: "Nama tugas harus diisi"
                   },
                   deskripsi: {
                       required: "Deskripsi harus diisi"
                   },
                   jam_kompen: {
                       required: "Jam kompen harus diisi",
                       number: "Harus berupa angka"
                   },
                   kategori_id: {
                       required: "Kategori harus dipilih"
                   },
                   status_dibuka: {
                       required: "Status harus dipilih"
                   },
                   tanggal_mulai: {
                       required: "Tanggal mulai harus diisi",
                       date: "Format tanggal tidak valid"
                   },
                   tanggal_akhir: {
                       required: "Tanggal akhir harus diisi", 
                       date: "Format tanggal tidak valid"
                   }
               },
               submitHandler: function(form) {
                   var formData = $(form).serialize();
                   $.ajax({
                       url: form.action,
                       type: 'PUT',
                       data: formData,
                       success: function(response) {
                           if (response.status) {
                               $('#myModal').modal('hide');
                               Swal.fire({
                                   icon: 'success',
                                   title: 'Berhasil',
                                   text: response.message
                               });
                               datatugas.ajax.reload();
                           } else {
                               $('.error-text').text('');
                               $.each(response.msgField, function(prefix, val) {
                                   $('#error-' + prefix).text(val[0]);
                               });
                               Swal.fire({
                                   icon: 'error',
                                   title: 'Terjadi Kesalahan',
                                   text: response.message
                               });
                           }
                       },
                       error: function(xhr, status, error) {
                           console.error(xhr.responseText);
                           Swal.fire({
                               icon: 'error',
                               title: 'Terjadi Kesalahan',
                               text: 'Gagal menyimpan data'
                           });
                       }
                   });
                   return false;
               }
           });
       });
   </script>
@endempty