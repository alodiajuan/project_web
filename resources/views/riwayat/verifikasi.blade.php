<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kompensasi</title>
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>

<body class="hold-transition bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg rounded-lg">
            <div class="card-header text-center bg-primary text-white">
                <h2 class="mb-0">BUKTI KOMPENSASI DIVERIFIKASI</h2>
            </div>

            <div class="card-body">
                <div class="mb-4">
                    <h3 class="h5 font-weight-bold">Dosen Pengampu</h3>
                    <ul class="list-unstyled">
                        <li><strong>Nama Dosen:</strong> {{ $compensation->dosen->nama }}</li>
                        <li><strong>Username:</strong> {{ $compensation->dosen->username }}</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h3 class="h5 font-weight-bold">Mahasiswa</h3>
                    <ul class="list-unstyled">
                        <li><strong>Nama Mahasiswa:</strong> {{ $compensation->mahasiswa->nama }}</li>
                        <li><strong>Username:</strong> {{ $compensation->mahasiswa->username }}</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h3 class="h5 font-weight-bold">Task yang Diberikan</h3>
                    <ul class="list-unstyled">
                        <li><strong>Judul Task:</strong> {{ $compensation->task->judul }}</li>
                        <li><strong>Bobot:</strong> {{ $compensation->task->bobot }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
