<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (empty($row['username'])) {
            return null;
        }

        return new User([
            'username'      => $row['username'] ?? null,
            'password'      => isset($row['password']) ? Hash::make($row['password']) : null,
            'nama'          => $row['nama'] ?? null,
            'semester'      => $row['semester'] ?? null,
            'id_kompetensi' => $row['id_kompetensi'] ?? null,
            'id_prodi'      => $row['id_prodi'] ?? null,
            'role'          => $row['role'] ?? 'mahasiswa',
            'foto_profile'  => $row['foto_profile'] ?? null,
            'alfa'          => $row['alfa'] ?? null,
            'compensation'  => $row['kompensasi'] ?? null,
        ]);
    }
}
