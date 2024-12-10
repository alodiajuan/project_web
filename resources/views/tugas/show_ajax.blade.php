@empty($tugas)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
    <form action="{{ url('/tugas/' . $tugas->id_tugas . '/detail_ajax') }}" method="POST" id="form-show">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
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
                </table>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>

</form>
   <script>
    $(document).ready(function() {
        $("#form-show").validate({
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#modal-master').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataTugas.ajax.reload(); // Reload datatable
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal memproses permintaan.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
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