# API SPESIFICATIONS

API ini menyediakan berbagai endpoint untuk menghubungkan mobile apps ke database.

## BASE URL

```
http://127.0.0.1:8000/api/v1
```

## RESOURCES

### 1. Authentication

#### a. Login

-   **Endpoint:** `/login`
-   **Method:** `POST`
-   **Description:** Login user dengan role (admin, dosen, tendik, mahasiswa)
-   **Request:**

```json
{
    "username": "number (required)",
    "password": "string (required)"
}
```

-   **Response**:

```json
{
    "status": true,
    "message": "Login user berhasil",
    "data": {
        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
        "user": {
            "id": 1,
            "username": "user123",
            "nama": "John Doe",
            "role": "dosen",
            "foto_profile": "http://localhost:8000/images/profile_picture.jpg",
            "semester": null,
            "id_kompetensi": null,
            "id_prodi": null,
            "alfa": null,
            "compensation": null
        }
    }
}
```

#### b. Logout

-   **Endpoint:** `/logout`
-   **Method:** `GET`
-   **Description:** Logout user
-   **Response:**

```json
{
    "status": true,
    "message": "Logout user berhasil"
}
```

#### c. User Profile

-   **Endpoint:** `/profile`
-   **Method:** `GET`
-   **Description:** Mengambil informasi profil pengguna yang sedang login.
-   **Response:**

```json
{
    "status": true,
    "message": "Get data profile berhasil",
    "data": {
        "id": 1,
        "username": "user123",
        "nama": "John Doe",
        "role": "dosen",
        "foto_profile": "http://localhost:8000/images/profile_picture.jpg",
        "semester": null,
        "id_kompetensi": null,
        "id_prodi": null,
        "alfa": null,
        "compensation": null
    }
}
```

### 2. Dashboard

### a. Get Data Dashboard Mahasiswa

-   **Endpoint:** : `/dashboard-students`
-   **Method**: `GET`
-   **Description**: Mengambil data dashboard mahasiswa
-   **Response:**

```json
{
    "status": true,
    "message": "Mendapatkan data dashboard mahasiswa berhasil",
    "data": {
        "total_tasks": 1,
        "total_requests": 2,
        "total_compensations": 3,
        "progress": [
            {
                "id": 1,
                "judul": "Tugas Pemrograman",
                "dosen": "Pak Sujiwo Tejo",
                "status": "terima", // null jika belum direview
                "progress": 80, // null jika belum direview
                "tipe": "file",
                "file": "http://localhost:8000/file/file_pendukung.pdf", // pastikan langsung bisa didownload
                "url": "http://localhost:8000"
            }
        ]
    }
}
```

### b. Get Data Dashboard Mahasiswa

-   **Endpoint:** : `/dashboard-sdn`
-   **Method**: `GET`
-   **Description**: Mengambil data dashboard sdm
-   **Response:**

```json
{
    "status": true,
    "message": "Mendapatkan data dashboard sdm berhasil",
    "data": {
        "total_tasks": 1,
        "total_requests": 2,
        "total_submissions": 3
    }
}
```

### 3. Task

#### a. Create tasks

-   **Endpoint:** `/tasks/store`
-   **Method:** `POST`
-   **Description:** Membuat tugas baru.
-   **Request:**

```json
{
    "judul": "Tugas Pemrograman",
    "deskripsi": "Tugas membuat aplikasi web menggunakan Laravel",
    "bobot": 20,
    "semester": 5,
    "kuota": 5,
    "file": "(binary)", // nullable
    "url": "http://localhost:8000",
    "id_jenis": 2,
    "tipe": "file"
}
```

-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil membuat tugas baru"
}
```

#### b. Get tasks student

-   **Endpoint:** `/tasks-student`
-   **Method:** `GET`
-   **Description:** Mendapatkan semua data tugas yang belum dikerjakan berdasarkan semester user login, jika yang login selain mahasiswa menampilkan tugas yang dibuat user yang login
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan semua tugas",
    "data": [
        {
            "id": 1,
            "dosen": "Pak Sujiwo Tejo",
            "judul": "Tugas Pemrograman",
            "deskripsi": "Tugas membuat aplikasi web menggunakan Laravel",
            "bobot": 20,
            "periode": "2023/2024",
            "jenis": "Tugas Harian",
            "status": "terima", // belum, terima, tolak
            "file": "http://localhost:8000/file/file_pendukung.pdf", // pastikan langsung bisa didownload
            "url": "http://localhost:8000",
            "tipe": "file",
            "deadline": "07:30 12 Desember 2024"
        }
    ]
}
```

#### c. Get tasks student

-   **Endpoint:** `/tasks-sdm`
-   **Method:** `GET`
-   **Description:** Mendapatkan semua data tugas yang dibuat sdm yang login
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan semua tugas",
    "data": [
        {
            "id": 1,
            "dosen": "Pak Sujiwo Tejo",
            "judul": "Tugas Pemrograman",
            "deskripsi": "Tugas membuat aplikasi web menggunakan Laravel",
            "bobot": 20,
            "periode": "2023/2024",
            "jenis": "Tugas Harian",
            "status": "terima", // belum, terima, tolak
            "file": "http://localhost:8000/file/file_pendukung.pdf", // pastikan langsung bisa didownload
            "url": "http://localhost:8000",
            "tipe": "file",
            "deadline": "07:30 12 Desember 2024"
        }
    ]
}
```

#### d. Update tasks

-   **Endpoint:** `/tasks/update`
-   **Method:** `PUT`
-   **Description:** Update tugas.
-   **Request:**

```json
{
    "id_task": 1,
    "judul": "Tugas Pemrograman",
    "deskripsi": "Tugas membuat aplikasi web menggunakan Laravel",
    "bobot": 20,
    "semester": 5,
    "kuota": 5,
    "file": "(binary)", // nullable
    "url": "http://localhost:8000",
    "id_jenis": 2,
    "tipe": "file"
}
```

-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil membuat tugas baru"
}
```

#### e. Get tasks by id

-   **Endpoint:** `/tasks/{id}`
-   **Method:** `GET`
-   **Description:** Mendapatkan semua data tugas berdasarkan id
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan tugas berdasarkan id",
    "data": [
        {
            "id": 1,
            "dosen": "Pak Sujiwo Tejo",
            "judul": "Tugas Pemrograman",
            "deskripsi": "Tugas membuat aplikasi web menggunakan Laravel",
            "bobot": 20,
            "periode": "2023/2024",
            "semester": 3,
            "jenis": "Tugas Harian",
            "id_jenis": 1,
            "status": "terima", // null, terima, tolak (selain mahasiswa null)
            "file": "http://localhost:8000/file/file_pendukung.pdf", // pastikan langsung bisa didownload
            "url": "http://localhost:8000",
            "tipe": "file",
            "deadline": "07:30 12 Desember 2024",
            "tenggat": "2024-12-29 23:59:59"
        }
    ]
}
```

### 4. Task Submission

#### a. Get submissions by id task

-   **Endpoint:** `/task/{id}/submissions`
-   **Method:** `GET`
-   **Description:** Mendapatkan semua data pengumpulan tugas berdasarkan id tugas
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan data pengumpulan tugas",
    "data": {
        "available": true,
        "submissions": [
            {
                "id": 1,
                "judul": "Tugas Pemrograman",
                "deskripsi": "Deskripsi Tugas Pemrograman",
                "dosen": "Pak Sujiwo Tejo",
                "status": "terima", // null jika belum direview
                "progress": 80, // null jika belum direview
                "tipe": "file",
                "file": "http://localhost:8000/file/file_pendukung.pdf", // pastikan langsung bisa didownload
                "url": "http://localhost:8000"
            }
        ]
    }
}
```

#### b. Get submissions for users sdm

-   **Endpoint:** `/submissions-sdm`
-   **Method:** `GET`
-   **Description:** Mendapatkan semua data pengumpulan tugas untuk sdm
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan data pengumpulan tugas",
    "data": [
        {
            "id": 1,
            "judul": "Tugas Pemrograman",
            "deskripsi": "Tugas deskripsi",
            "mahasiswa": "Hanif",
            "tipe": "file",
            "file": "http://localhost:8000/file/file_pendukung.pdf", // pastikan langsung bisa didownload
            "url": "http://localhost:8000"
        }
    ]
}
```

#### c. Submission Task

-   **Endpoint:** `/submissions`
-   **Method:** `POST`
-   **Description:** Update tugas.
-   **Request:**

```json
{
    "id_task": 1,
    "submission": "http://localhost:8000" // bisa juga berupa file tergantung tipe dari task
}
```

-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mengumpulkan tugas"
}
```

#### d. Review Submission

-   **Endpoint:** `/submissions/{id}`
-   **Method:** `POST`
-   **Description:** Review Submission.
-   **Request:**

```json
{
    "id_submissions": 1,
    "nilai": 80, // bisa null jika tolak
    "status": "terima" // bisa terima bisa tolak,
}
```

-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil review pengumpulan tugas"
}
```

#### e. Get submission by id

-   **Endpoint:** `/submission/{id}`
-   **Method:** `GET`
-   **Description:** Mendapatkan data pengumpulan tugas berdasarkan id
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan data pengumpulan tugas",
    "data": [
        {
            "id": 1,
            "judul": "Tugas Pemrograman",
            "mahasiswa": "Hanif",
            "kompetensi": "Pemrograman Python",
            "tipe": "file",
            "file": "http://localhost:8000/file/file_pendukung.pdf", // pastikan langsung bisa didownload
            "url": "http://localhost:8000"
        }
    ]
}
```

#### f. Request Task

-   **Endpoint:** `/task-request/{id}`
-   **Method:** `GET`
-   **Description:** Request pengerjaan tugas
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mengajukan pengerjaan tugas"
}
```

### 5. Compensation

#### a. Get data compensations

-   **Endpoint:** `/compensations`
-   **Method:** `GET`
-   **Description:** Mendapatkan data kompensasi.
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan data kompensasi",
    "data": [
        {
            "id": 1,
            "dosen": "Pak Sujiwo Tejo",
            "mahasiswa": "Hanif",
            "judul_tugas": "Pemrograman Web",
            "bobot": 8,
            "periode": "2023/2024",
            "file": "http://localhost:8000/compensations/{id}" // otomatis download
        }
    ]
}
```

#### b. Get data compensation by id

-   **Endpoint:** `/compensations/{id}`
-   **Method:** `GET`
-   **Description:** Mendapatkan data kompensasi berdasarkan id.
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan data kompensasi berdasarkan id",
    "data": {
        "id": 1,
        "dosen": "Pak Sujiwo Tejo",
        "mahasiswa": "Hanif",
        "judul_tugas": "Pemrograman Web",
        "bobot": 8,
        "periode": "2023/2024",
        "file": "http://localhost:8000/compensations/{id}" // otomatis download
    }
}
```

### 6. Competence

#### a. Get data competence

-   **Endpoint:** `/competences`
-   **Method:** `GET`
-   **Description:** Mendapatkan daftar kompetensi
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan semua kompetensi",
    "data": [
        {
            "id": 1,
            "nama": "Pemrograman"
        },
        {
            "id": 2,
            "nama": "Jaringan Komputer"
        }
    ]
}
```

### 7. Type Task

#### a. Get data type task

-   **Endpoint:** `/type-tasks`
-   **Method:** `GET`
-   **Description:** Mendapatkan daftar jenis tugas.
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan semua jenis tugas",
    "data": [
        {
            "id": 1,
            "nama": "Tugas Mandiri"
        },
        {
            "id": 2,
            "nama": "Tugas Kelompok"
        }
    ]
}
```

### 8. Prodi

#### a. Get data type task

-   **Endpoint:** `/prodi`
-   **Method:** `GET`
-   **Description:** Mendapatkan daftar prodi.
-   **Response:**

```json
{
    "status": true,
    "message": "Berhasil mendapatkan semua prodi",
    "data": [
        {
            "id": 1,
            "nama": "Teknologi Rekayasa Perangkat Lunak"
        }
    ]
}
```
