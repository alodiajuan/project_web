# API SPESIFICATIONS

API ini menyediakan berbagai endpoint untuk menghubungkan mobile apps ke database.

## BASE URL

```
http://127.0.0.1:8000/api/v1
```

## RESOURCES

### 1. Authentication

#### a. Login

-   **Endpoint:** `/api/v1/login`
-   **Method:** `POST`
-   **Description:** Login User Berhasil
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
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "username": "user123",
            "nama": "John Doe",
            "role": "mahasiswa"
        },
        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
    }
}
```

#### b. Logout

-   **Endpoint:**  `/api/v1/`
-   **Method:** `POST`
-   **Description:** Logout Berhasil dan Menghapus token autentikasi pengguna untuk keluar dari sistem.

-   **Response:**

```json
{
    "success": true,
    "message": "Logout successful"
}
```

#### c. User Profile

-   **Endpoint:** `/api/v1/`
-   **Method:** `GET`
-   **Description:** Mengambil informasi profil pengguna yang sedang login.

-   **Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "username": "user123",
        "foto_profile": "https://example.com/profile.jpg",
        "nama": "John Doe",
        "semester": 4,
        "id_kompetensi": 1,
        "id_prodi": 2,
        "role": "mahasiswa",
        "created_at": "2024-12-15T12:00:00Z",
        "updated_at": "2024-12-15T12:00:00Z"
    }
}
```

### 2. Task

#### a. Create tasks
-   **Endpoint:** `/api/v1/`
-   **Method:** `POST`
-   **Description:** Membuat tugas baru.

-   **Request:**

```json
{
    "id_dosen": 1,
    "judul": "Tugas Pemrograman",
    "deskripsi": "Tugas membuat aplikasi web menggunakan Laravel",
    "bobot": 20,
    "semester": 5,
    "id_jenis": 2,
    "tipe": "file"
}
```

-   **Response:**

```json
{
    "success": true,
    "message": "Task created successfully",
    "data": {
        "id": 1,
        "id_dosen": 1,
        "judul": "Tugas Pemrograman",
        "deskripsi": "Tugas membuat aplikasi web menggunakan Laravel",
        "bobot": 20,
        "semester": 5,
        "id_jenis": 2,
        "tipe": "file",
        "created_at": "2024-12-15T12:00:00Z"
    }
}
```

#### a. Get tasks
-   **Endpoint:** `/api/v1/`
-   **Method:** `GET`
-   **Description:** Mendapatkan daftar semua tugas

-   **Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "id_dosen": 1,
            "judul": "Tugas Pemrograman",
            "deskripsi": "Tugas membuat aplikasi web menggunakan Laravel",
            "bobot": 20,
            "semester": 5,
            "id_jenis": 2,
            "tipe": "file",
            "created_at": "2024-12-15T12:00:00Z"
        }
    ]
}
```

### 3. Compensation
-   **Endpoint:** `/api/v1/compensations`
-   **Method:** `POST`
-   **Description:** Membuat kompensasi atas tugas yang dikirimkan.

-   **Request:**

```json
{
    "id_task": 1,
    "id_submission": 3,
    "id_dosen": 1,
    "id_mahasiswa": 2,
    "semester": 5
}
```

-   **Response:**

```json
{
    "success": true,
    "message": "Compensation created successfully",
    "data": {
        "id": 1,
        "id_task": 1,
        "id_submission": 3,
        "id_dosen": 1,
        "id_mahasiswa": 2,
        "semester": 5,
        "created_at": "2024-12-15T12:00:00Z"
    }
}
```

### 4. Task_Submission

#### a. Create Submission
-   **Endpoint:** `/api/v1/task-submissions`
-   **Method:** `POST`
-   **Description:** Mahasiswa mengirimkan tugas untuk disetujui dosen.

-   **Request:**

```json
{
    "id_task": 1,
    "id_mahasiswa": 2,
    "file": "https://example.com/task-submission.pdf",
    "url": "https://github.com/mahasiswa/project-web"
}
```

-   **Response:**

```json
{
    "success": true,
    "message": "Task submission created successfully",
    "data": {
        "id": 1,
        "id_task": 1,
        "id_mahasiswa": 2,
        "file": "https://example.com/task-submission.pdf",
        "url": "https://github.com/mahasiswa/project-web",
        "created_at": "2024-12-15T12:00:00Z"
    }
}
```

### 5. Task_Request
-   **Endpoint:** `/api/v1/task-requests`
-   **Method:** `POST`
-   **Description:** Mahasiswa mengajukan permintaan untuk menerima atau menolak tugas..

-   **Request:**

```json
{
    "id_task": 1,
    "id_mahasiswa": 2,
    "status": "terima"
}
```

-   **Response:**

```json
{
    "success": true,
    "message": "Task request submitted successfully",
    "data": {
        "id": 1,
        "id_task": 1,
        "id_mahasiswa": 2,
        "status": "terima",
        "created_at": "2024-12-15T12:00:00Z"
    }
}
```

### 6. Competence
-   **Endpoint:** `/api/v1/competences`
-   **Method:** `GET`
-   **Description:**  Mendapatkan daftar kompetensi.

-   **Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nama": "Pemrograman",
            "created_at": "2024-12-15T12:00:00Z"
        },
        {
            "id": 2,
            "nama": "Jaringan Komputer",
            "created_at": "2024-12-15T12:00:00Z"
        }
    ]
}
```

### 7. Type Task
-   **Endpoint:** `/api/v1/type-tasks`
-   **Method:** `GET`
-   **Description:**  Mendapatkan daftar jenis tugas.

-   **Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nama": "Tugas Mandiri",
            "created_at": "2024-12-15T12:00:00Z"
        },
        {
            "id": 2,
            "nama": "Tugas Kelompok",
            "created_at": "2024-12-15T12:00:00Z"
        }
    ]
}
```

### 8. Type Task
-   **Endpoint:** `/api/v1/prodi`
-   **Method:** `GET`
-   **Description:**   Mendapatkan daftar program studi.

-   **Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nama": "Teknik Informatika",
            "created_at": "2024-12-15T12:00:00Z"
        },
        {
            "id": 2,
            "nama": "Sistem Informasi",
            "created_at": "2024-12-15T12:00:00Z"
        }
    ]
}
```