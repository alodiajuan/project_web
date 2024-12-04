<form action="{{ url('/tugas/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tugas_kode">Kode Tugas</label>
                    <input type="text" name="tugas_kode" id="tugas_kode" class="form-control">
                    <span id="error-tugas_kode" class="error-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="tugas_nama">Nama Tugas</label>
                    <input type="text" name="tugas_nama" id="tugas_nama" class="form-control">
                    <span id="error-tugas_nama" class="error-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                    <span id="error-deskripsi" class="error-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="jam_kompen">Jam Kompen</label>
                    <input type="number" name="jam_kompen" id="jam_kompen" class="form-control">
                    <span id="error-jam_kompen" class="error-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control">
                        <option value="">- Pilih Kategori -</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->kategori_id }}">{{ $category->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <span id="error-kategori_id" class="error-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="sdm_id">SDM</label>
                    <select name="sdm_id" id="sdm_id" class="form-control">
                        <option value="">- Pilih SDM -</option>
                        @foreach ($sdm as $s)
                            <option value="{{ $s->sdm_id }}">{{ $s->sdm_nama }}</option>
                        @endforeach
                    </select>
                    <span id="error-sdm_id" class="error-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="status_dibuka">Status</label>
                    <select name="status_dibuka" id="status_dibuka" class="form-control">
                        <option value="">- Pilih Status -</option>
                        <option value="dibuka">Dibuka</option>
                        <option value="ditutup">Ditutup</option>
                    </select>
                    <span id="error-status_dibuka" class="error-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
                    <span id="error-tanggal_mulai" class="error-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="tanggal_akhir">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
                    <span id="error-tanggal_akhir" class="error-text text-danger"></span>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

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
            deskripsi: {
                required: true,
                minlength: 5
            },
            jam_kompen: {
                required: true,
                number: true,
                min: 1
            },
            kategori_id: {
                required: true
            },
            sdm_id: {
                required: true
            },
            status_dibuka: {
                required: true
            },
            tanggal_mulai: {
                required: true,
                date: true
            },
            tanggal_akhir: {
                required: true,
                date: true,
                greaterThan: "#tanggal_mulai"
            }
        },
        messages: {
            tugas_kode: {
                required: "Kode tugas wajib diisi",
                minlength: "Kode tugas minimal 3 karakter",
                maxlength: "Kode tugas maksimal 20 karakter"
            },
            tugas_nama: {
                required: "Nama tugas wajib diisi",
                minlength: "Nama tugas minimal 3 karakter",
                maxlength: "Nama tugas maksimal 100 karakter"
            },
            deskripsi: {
                required: "Deskripsi wajib diisi",
                minlength: "Deskripsi minimal 5 karakter"
            },
            jam_kompen: {
                required: "Jam kompen wajib diisi",
                number: "Masukkan angka yang valid",
                min: "Jam kompen minimal 1"
            },
            kategori_id: {
                required: "Kategori wajib dipilih"
            },
            sdm_id: {
                required: "SDM wajib dipilih"
            },
            status_dibuka: {
                required: "Status wajib dipilih"
            },
            tanggal_mulai: {
                required: "Tanggal mulai wajib diisi",
                date: "Masukkan format tanggal yang valid"
            },
            tanggal_akhir: {
                required: "Tanggal akhir wajib diisi",
                date: "Masukkan format tanggal yang valid",
                greaterThan: "Tanggal akhir harus lebih besar dari tanggal mulai"
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(() => {
                            datatugas.ajax.reload();
                        });
                    } else {
                        $('.error-text').text('');
                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal menghubungi server'
                    });
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

    // Add custom validation method for date comparison
    $.validator.addMethod("greaterThan", function(value, element, param) {
        var startDate = $(param).val();
        if (!startDate || !value) return true;
        return new Date(value) > new Date(startDate);
    });
});
</script>