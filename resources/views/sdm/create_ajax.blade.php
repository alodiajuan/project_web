<form action="{{ url('/sdm/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data SDM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama SDM</label>
                    <input type="text" name="sdm_nama" id="sdm_nama" class="form-control" required>
                    <small id="error-sdm_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" required>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
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
                    <label>No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" required>
                    <small id="error-no_telepon" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    <small id="error-foto" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Program Studi</label>
                    <select name="prodi_id" id="prodi_id" class="form-control" required>
                        <option value="">- Pilih Prodi -</option>
                        @foreach ($prodis as $prodi)
                            <option value="{{ $prodi->prodi_id }}">{{ $prodi->prodi_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select name="level_id" id="level_id" class="form-control" required>
                        <option value="">- Pilih Level -</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
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
        $("#form-tambah").validate({
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
                password: {
                    required: true,
                    minlength: 6
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
            messages: {
                sdm_nama: {
                    required: "Nama SDM harus diisi",
                    minlength: "Nama SDM minimal 3 karakter"
                },
                nip: {
                    required: "NIP harus diisi"
                },
                username: {
                    required: "Username harus diisi"
                },
                password: {
                    required: "Password harus diisi",
                    minlength: "Password minimal 6 karakter",
                },
                no_telepon: {
                    required: "No Telepon harus diisi"
                },
                prodi_id: {
                    required: "Prodi harus dipilih"
                },
                level_id: {
                    required: "Level harus dipilih"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
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
