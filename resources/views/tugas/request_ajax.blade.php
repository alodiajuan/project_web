@empty($tugas)
   <!-- Error modal unchanged -->
@else
   <form action="{{ url('/tugas/' . $tugas->tugas_id . '/request') }}" method="POST" id="form-show">
       @csrf
       <div id="modal-master" class="modal-dialog modal-lg" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Detail Tugas</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Kode Tugas</th>
                        <td class="col-9">{{ $tugas->tugas_kode }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama Tugas</th>
                        <td class="col-9">{{ $tugas->tugas_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Deskripsi</th>
                        <td class="col-9">{{ $tugas->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Jam Kompen</th>
                        <td class="col-9">{{ $tugas->jam_kompen }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kategori</th>
                        <td class="col-9">{{ $tugas->kategori->kategori_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">SDM</th>
                        <td class="col-9">{{ $tugas->sdm->sdm_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Status</th>
                        <td class="col-9">{{ $tugas->status_dibuka }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Mulai</th>
                        <td class="col-9">{{ \Carbon\Carbon::parse($tugas->tanggal_mulai)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Akhir</th>
                        <td class="col-9">{{ \Carbon\Carbon::parse($tugas->tanggal_akhir)->format('d-m-Y') }}</td>
                    </tr>
                       <tr>
                           <th class="text-right col-3">Chatbox</th>
                           <td class="col-9">
                               <div class="form-group">
                                   <textarea name="chatbox" id="chatbox" class="form-control" placeholder="Tulis pesanmu..." rows="3"></textarea>
                               </div>
                           </td>
                       </tr>
                   </table>
               </div>
               <div class="modal-footer">
                   <button type="submit" class="btn btn-primary">Request</button>
               </div>
           </div>
       </div>
   </form>

   <script>
       $(document).ready(function() {
           $("#form-show").validate({
               submitHandler: function(form) {
                   $.ajax({
                       url: $(form).attr('action'),
                       type: 'POST',
                       data: $(form).serialize(),
                       success: function(response) {
                           $('#modal-master').modal('hide');
                           Swal.fire({
                               icon: response.status ? 'success' : 'error',
                               title: response.status ? 'Berhasil' : 'Terjadi Kesalahan',
                               text: response.message
                           }).then(() => {
                               if (response.status) {
                                   dataTugas.ajax.reload();
                               }
                           });
                       },
                       error: function(xhr) {
                           Swal.fire({
                               icon: 'error',
                               title: 'Terjadi Kesalahan',
                               text: xhr.responseJSON?.message || 'Gagal memproses permintaan.'
                           });
                       }
                   });
                   return false;
               }
           });
       });
   </script>
@endempty