<form action="{{ url('/admin/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Admin</label>
                    <input type="text" name="admin_nama" id="admin_nama" class="form-control" required>
                    <small id="error-admin_nama" class="error-text form-text text-danger"></small>
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
                    <label>No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" required>
                    <small id="error-no_telepon" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Prodi</label>
                    <select name="prodi_id" id="prodi_id" class="form-control" required>
                        <option value="">Pilih Prodi</option>
                        <!-- Add prodi options -->
                    </select>
                    <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select name="level_id" id="level_id" class="form-control" required>
                        <option value="">Pilih Level</option>
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
        $("#form-tambah").validate({
            rules: {
                admin_nama: {
                    required: true,
                    minlength: 3,
                },
                nip: {
                    required: true,
                },
                username: {
                    required: true,
                },
                no_telepon: {
                    required: true,
                },
                prodi_id: {
                    required: true,
                },
                level_id: {
                    required: true,
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
                            dataAdmin.ajax.reload();
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