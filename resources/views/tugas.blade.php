<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tugas</title>
</head>
<body>
    <h1>Data Tugas</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tugas</th>
                <th>Nama Tugas</th>
                <th>Kategori</th>
                <th>Jam Kompen</th>
                <th>Deskripsi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Akhir</th>
                <th>Status</th>
                <th>Dosen Pengunggah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $d)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $d->tugas_kode }}</td>
                <td>{{ $d->tugas_nama }}</td>
                <td>{{ $d->kategori->kategori_nama }}</td>
                <td>{{ $d->jam_kompen }}</td>
                <td>{{ $d->deskripsi ?? '-' }}</td>
                <td>{{ $d->tanggal_mulai }}</td>
                <td>{{ $d->tanggal_akhir }}</td>
                <td>{{ $d->status_dibuka ? 'Dibuka' : 'Ditutup' }}</td>
                <td>
                    @if ($d->sdm)
                        {{ $d->sdm->nama }}
                    @elseif ($d->admin)
                        {{ $d->admin->nama }}
                    @else
                        Tidak diketahui
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
