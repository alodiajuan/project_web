@empty($sdm)
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
                   <a href="{{ url('/sdm') }}" class="btn btn-warning">Kembali</a>
               </div>
           </div>
       </div>
   @else
       <form action="{{ url('/sdm/' . $sdm->sdm_id . '/update_ajax') }}" method="POST" id="form-edit">
           @csrf
           @method('PUT')
           <div id="modal-master" class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title">Edit Data sdm</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   </div>
                   <div class="modal-body">
                       <div class="form-group">
                           <label>Nama sdm</label>
                           <input value="{{ $sdm->sdm_nama }}" type="text" name="sdm_nama" id="sdm_nama" class="form-control" required>
                           <small id="error-sdm_nama" class="error-text form-text text-danger"></small>
                       </div>
                       <div class="form-group">
                           <label>NIP</label>
                           <input value="{{ $sdm->nip }}" type="text" name="nip" id="nip" class="form-control" required>
                           <small id="error-nip" class="error-text form-text text-danger"></small>
                       </div>
                       <div class="form-group">
                           <label>Username</label>
                           <input value="{{ $sdm->username }}" type="text" name="username" id="username" class="form-control" required>
                           <small id="error-username" class="error-text form-text text-danger"></small>
                       </div>
                       <div class="form-group">
                           <label>No Telepon</label>
                           <input value="{{ $sdm->no_telepon }}" type="text" name="no_telepon" id="no_telepon" class="form-control" required>
                           <small id="error-no_telepon" class="error-text form-text text-danger"></small>
                       </div>
                       <div class="form-group">
                           <label>Prodi ID</label>
                           <select name="prodi_id" id="prodi_id" class="form-control" required>
                               <!-- Add prodi options -->
                           </select>
                           <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                       </div>
                       <div class="form-group">
                           <label>Level ID</label>
                           <select name="level_id" id="level_id" class="form-control" required>
                               <!-- Add level options -->
                           </select>
                           <small id="error-level_id" class="error-text form-text text-danger"></small>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                       <button type="submit" class="btn btn-primary">Simpan</button>
                   </div>
               </div>
           </div>
       </form>
       <script>
           $(document).ready(function() {
               $("#form-edit").validate({
                   rules: {
                       sdm_nama: {
                           required: true,
                           minlength: 3
                       },
                       nip: {
                           required: true 
                       },
                       username: {
                           required: true
                       },
                       no_telepon: {
                           required: true
                       },
                       prodi_id: {
                           required: true
                       },
                       level_id: {
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
                                   datasdm.ajax.reload();
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
                   },
                   errorElement: 'span',
                   errorPlacement: function(error, element) {
                       error.addClass('invalid-feedback');
                       element.closest('.form-group').append(error);
                   },
                   highlight: function(element, errorClass, validClass) {
                       $(element).addClass('is-invalid');
                   },
                   unhighlight: function(element, errorClass, validClass) {
                       $(element).removeClass('is-invalid');
                   }
               });
           });
       </script>
   @endempty