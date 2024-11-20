<form action="{{ url('/tugas/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Daftar Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Tugas</label>
                    <input value="" type="text" name="tugas_kode" id="tugas_kode" class="form-control" required>
                    <small id="error-tugas_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Tugas</label>
                    <input value="" type="text" name="tugas_nama" id="tugas_nama" class="form-control" required>
                    <small id="error-tugas_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Jam Kompen</label>
                    <input value="" type="number" name="jam_kompen" id="jam_kompen" class="form-control" required>
                    <small id="error-jam_kompen" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status_dibuka" id="status_dibuka" class="form-control" required>
                        <option value="1">Dibuka</option>
                        <option value="0">Ditutup</option>
                    </select>
                    <small id="error-status_dibuka" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input value="" type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                    <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input value="" type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                    <small id="error-tanggal_akhir" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                tugas_kode: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                tugas_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                jam_kompen: {
                    required: true,
                    number: true
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
                            dataTugas.ajax.reload();
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
@endpush
