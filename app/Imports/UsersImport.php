<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] == 'Username' || empty($row[0])) {
            return null;
        }

        return new User([
            'username'      => $row[0],
            'password'      => Hash::make($row[1]),
            'nama'          => $row[2],
            'semester'      => $row[3],
            'id_kompetensi' => $row[4],
            'id_prodi'      => $row[5],
            'role'          => $row[6],
            'foto_profile'  => $row[7],
        ]);
    }
}
