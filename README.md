# API SPESIFICATIONS

API ini menyediakan berbagai endpoint untuk menghubungkan mobile apps ke database.

## BASE URL

```
http://localhost:8000/api
```

## RESOURCES

### 1. Authentication

#### a. Create Register

-   **Endpoint** : `/api/register`
-   **Method**: `POST`
-   **Description**: untuk pembuatan akun pengguna baru.
-   **Request:**

```json
{
    "username": "string (required, unique)",
    "password": "string (required, min: 8 characters)",
    "foto_profile": "string (required, URL format)",
    "nama": "string (required)",
    "semester": "integer (required if role is 'mahasiswa')",
    "id_kompetensi": "integer (nullable)",
    "id_prodi": "integer (nullable)",
    "role": "string (required, enum: ['admin', 'dosen', 'tendik', 'mahasiswa'])"
}

```

-   **Response**:

```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "id": 1,
        "username": "user123",
        "foto_profile": "https://example.com/profile.jpg",
        "nama": "John Doe",
        "semester": 4,
        "id_kompetensi": 1,
        "id_prodi": 2,
        "role": "mahasiswa",
        "created_at": "2024-12-15T12:00:00Z"
    }
}

```

#### b. Login

-   **Endpoint:** `/api/login`
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

#### c. Logout

-   **Endpoint:** ` /api/logout`
-   **Method:** `POST`
-   **Description:** Logout Berhasil dan Menghapus token autentikasi pengguna untuk keluar dari sistem.

-   **Response:**

```json
{
    "success": true,
    "message": "Logout successful"
}
```

#### d. User Profile

-   **Endpoint:** `/api/userProfile`
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

### 3. Compensation

### 4. Task_Submission

### 5. Task_Request
