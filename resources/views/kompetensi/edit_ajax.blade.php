@empty($kompetensi)
   <div id="modal-master" class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Kesalahan</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <div class="modal-body">
                   <div class="alert alert-danger">
                       <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                       Data yang anda cari tidak ditemukan
                   </div>
                   <a href="{{ url('/kompetensi') }}" class="btn btn-warning">Kembali</a>
               </div>
           </div>
       </div>
   </div>
@else
   <form action="{{ url('/kompetensi/' . $kompetensi->kompetensi_id . '/edit_ajax') }}" method="POST" id="form-edit">
       @csrf
       @method('PUT')
       <div id="modal-master" class="modal-dialog modal-lg" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Edit Data Kompetensi</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <div class="modal-body">
                   <div class="form-group">
                       <label>Deskripsi</label>
                       <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ $kompetensi->deskripsi }}</textarea>
                       <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                   </div>
                   <div class="form-group">
                       <label>Mahasiswa</label>
                       <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                           <option value="">Pilih Mahasiswa</option>
                           @foreach($mahasiswas as $mahasiswa)
                               <option value="{{ $mahasiswa->mahasiswa_id }}" {{ $kompetensi->mahasiswa_id == $mahasiswa->mahasiswa_id ? 'selected' : '' }}>
                                   {{ $mahasiswa->nama }}
                               </option>
                           @endforeach
                       </select>
                       <small id="error-mahasiswa_id" class="error-text form-text text-danger"></small>
                   </div>
               </div>
               <div class="modal-footer">
                   <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                   <button type="submit" class="btn btn-primary">Update</button>
               </div>
           </div>
       </div>
   </form>
   <script>
       $(document).ready(function() {
           $("#form-edit").validate({
               rules: {
                   deskripsi: {
                       required: true
                   },
                   mahasiswa_id: {
                       required: true
                   }
               },
               submitHandler: function(form) {
                   $.ajax({
                       url: form.action,
                       type: form.method,
                       data: $(form).serialize(),
                       success: function(response) {
                           if (response.status) {
                               $('#myModal').modal('hide');
                               Swal.fire({
                                   icon: 'success',
                                   title: 'Berhasil',
                                   text: response.message
                               });
                               tableKompetensi.ajax.reload();
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
                       }
                   });
                   return false;
               }
           });
       });
   </script>
@endempty