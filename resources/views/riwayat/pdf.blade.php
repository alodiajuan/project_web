<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compensation PDF</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>

<body>
    <table class="header">
        <tr>
            <td>
                <img src="{{ public_path('images/logo-polinema.png') }}" class="logo" alt="Logo Polinema">
            </td>
            <td>
                <div class="text">
                    <h1>KEMENTRIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</h1>
                    <h1>POLITEKNIK NEGERI MALANG</h1>
                    <h1>PROGRAM STUDI TEKNIK INFORMATIKA</h1>
                    <p>Jl. Soekarno Hatta No. 9 Malang 65141</p>
                    <p>Telp. 0341404424 Fax. 0341404420, http://www.poltek-malang.ac.id</p>
                </div>
            </td>
        </tr>
    </table>

    <h2>BERITA ACARA KOMPENSASI PRESENSI</h2>

    <table>
        <tr>
            <td class="padding-right">Nama Pengajar</td>
            <td>: {{ $compensation->dosen->nama }}</td>
        </tr>
        <tr>
            <td class="padding-right">NIP</td>
            <td>: {{ $compensation->dosen->username }}</td>
        </tr>
    </table>

    <p class="margin-top font-bold">Memberikan rekomendasi kompensasi kepada :</p>
    <table class="margin-bottom">
        <tr>
            <td class="padding-right">Nama Mahasiswa</td>
            <td>: {{ $compensation->mahasiswa->nama }}</td>
        </tr>
        <tr>
            <td class="padding-right">NIM</td>
            <td>: {{ $compensation->mahasiswa->username }}</td>
        </tr>
        <tr>
            <td class="padding-right">Semester</td>
            <td>: {{ $compensation->semester }}</td>
        </tr>
        <tr>
            <td class="padding-right">Pekerjaan</td>
            <td>: {{ $compensation->task->judul }}</td>
        </tr>
        <tr>
            <td class="padding-right">Jumlah Jam</td>
            <td>: {{ $compensation->task->bobot }} Jam</td>
        </tr>
    </table>

    <table class="w-full">
        <tr>
            <td colspan="3" class="text-right">Malang,
                {{ \Carbon\Carbon::parse($compensation->updated_at)->format('d F Y') }}</td>
        </tr>
        <tr class="bottom-align">
            <td class="w-max-content">
                <p>Mengetahui</p>
                <p>Ka. Program Studi</p>
            </td>
            <td class="w-full"></td>
            <td class="w-max-content">
                <p>Yang memberikan rekomendasi,</p>
            </td>
        </tr>
        <tr>
            <td class="w-max-content">
                <div class="td-height"></div>
                <p class="font-bold underline">({{ $kaprodi['nama'] }})</p>
                <p>NIP. {{ $kaprodi['nip'] }}</p>
            </td>

            <td class="w-full"></td>

            <td class="w-max-content">
                <div class="td-height middle-align"></div>
                <p class="font-bold underline">({{ $compensation->dosen->nama }})</p>
                <p>NIP. {{ $compensation->dosen->username }}</p>
            </td>
        </tr>
    </table>

    <p class="margin-top-18">FRM.RIF.01.07.03</p>
    <p class="font-bold">NB: Form ini wajib disimpan untuk keperluan bebas tanggungan</p>
</body>

</html>
