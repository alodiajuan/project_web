@empty($mahasiswa)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan
                    </div>
                    <a href="{{ url('/mahasiswa') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/update_ajax') }}" method="POST" id="form-edit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi_id" id="prodi_id" class="form-control" required>
                            <option value="">- Pilih Program Studi -</option>
                            @foreach ($prodi as $p)
                                <option {{ $p->prodi_id == $mahasiswa->prodi_id ? 'selected' : '' }} 
                                    value="{{ $p->prodi_id }}">{{ $p->prodi_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select name="level_id" id="level_id" class="form-control">
                            <option value="">- Pilih Level -</option>
                            @foreach ($level as $l)
                                <option {{ $l->level_id == $mahasiswa->level_id ? 'selected' : '' }}
                                    value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-level_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Kompetensi</label>
                        <select name="kompetensi_id" id="kompetensi_id" class="form-control">
                            <option value="">- Pilih Kompetensi -</option>
                            @foreach ($kompetensi as $k)
                                <option {{ $k->kompetensi_id == $mahasiswa->kompetensi_id ? 'selected' : '' }}
                                    value="{{ $k->kompetensi_id }}">{{ $k->kompetensi_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-kompetensi_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>NIM</label>
                        <input value="{{ $mahasiswa->nim }}" type="text" name="nim" id="nim" class="form-control" required>
                        <small id="error-nim" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Nama Mahasiswa</label>
                        <input value="{{ $mahasiswa->mahasiswa_nama }}" type="text" name="mahasiswa_nama" id="mahasiswa_nama" class="form-control" required>
                        <small id="error-mahasiswa_nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input value="{{ $mahasiswa->username }}" type="text" name="username" id="username" class="form-control">
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah password</small>
                        <small id="error-password" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Semester</label>
                        <input value="{{ $mahasiswa->semester }}" type="number" name="semester" id="semester" class="form-control" min="1" max="14">
                        <small id="error-semester" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept=".png,.jpg,.jpeg">
                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah foto</small>
                        <small id="error-foto" class="error-text form-text text-danger"></small>
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
                    prodi_id: {
                        required: true,
                        number: true
                    },
                    nim: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    mahasiswa_nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    username: {
                        minlength: 3,
                        maxlength: 50
                    },
                    password: {
                        minlength: 5
                    },
                    semester: {
                        number: true,
                        min: 1,
                        max: 14
                    },
                    foto: {
                        accept: "png,jpg,jpeg"
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
@endempty