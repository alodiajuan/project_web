@empty($tugas)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
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
    <form action="{{ url('/tugas/' . $tugas->tugas_id . '/update_ajax') }}" method="POST" id="form-edit-tugas">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
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
                        <label>Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->kategori_id }}" {{ $k->kategori_id == $tugas->kategori_id ? 'selected' : '' }}>
                                    {{ $k->kategori_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jam Kompen</label>
                        <input value="{{ $tugas->jam_kompen }}" type="number" name="jam_kompen" id="jam_kompen"
                               class="form-control" required>
                        <small id="error-jam_kompen" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status_dibuka" id="status_dibuka" class="form-control" required>
                            <option value="1" {{ $tugas->status_dibuka ? 'selected' : '' }}>Dibuka</option>
                            <option value="0" {{ !$tugas->status_dibuka ? 'selected' : '' }}>Ditutup</option>
                        </select>
                        <small id="error-status_dibuka" class="error-text form-text text-danger"></small>
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
            $("#form-edit-tugas").validate({
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
                    kategori_id: {
                        required: true
                    },
                    jam_kompen: {
                        required: true,
                        min: 1
                    },
                    status_dibuka: {
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
                                $('#modal-master').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataTable.ajax.reload(); // Reload the DataTable after successful update
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
