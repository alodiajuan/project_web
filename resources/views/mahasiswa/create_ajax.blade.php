<form action="{{ url('/mahasiswa/store_ajax') }}" method="POST" id="form-tambah-mahasiswa" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Mahasiswa</label>
                    <input type="text" name="mahasiswa_nama" id="mahasiswa_nama" class="form-control" required>
                    <small id="error-mahasiswa_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" required>
                    <small id="error-nim" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept=".png,.jpg,.jpeg">
                    <small id="error-foto" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Semester</label>
                    <input type="number" name="semester" id="semester" class="form-control" required min="1" max="14">
                    <small id="error-semester" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Program Studi</label>
                    <select class="form-control" id="prodi_id" name="prodi_id" required>
                        <option value="">- Pilih Prodi -</option>
                        @foreach ($prodi as $p)
                            <option value="{{ $p->prodi_id }}">{{ $p->prodi_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kompetensi</label>
                    <select name="kompetensi_id" id="kompetensi_id" class="form-control" required>
                        <option value="">- Pilih Kompetensi -</option>
                        @foreach ($kompetensi as $k)
                            <option value="{{ $k->kompetensi_id }}">{{ $k->kompetensi_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-kompetensi_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select name="level_id" id="level_id" class="form-control" required>
                        <option value="">- Pilih Level -</option>
                        @foreach ($level as $l)
                            <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                        @endforeach
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
        $("#form-tambah-mahasiswa").validate({
            rules: {
                mahasiswa_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                nim: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 15
                },
                foto: {
                    accept: "png,jpg,jpeg"
                },
                semester: {
                    required: true,
                    min: 1,
                    max: 10
                },
                prodi_id: {
                    required: true
                },
                kompetensi_id: {
                    required: true
                },
                level_id: {
                    required: true
                }
            },
            submitHandler: function(form) {
                formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tableMahasiswa.ajax.reload();
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
