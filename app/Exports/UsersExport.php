<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'Username',
            'Password',
            'Nama',
            'Semester',
            'Kompetensi',
            'Prodi',
            'Role',
            'Foto Profile'
        ];
    }

    public function map($user): array
    {
        return [
            $user->username,
            $user->password,
            $user->nama,
            $user->semester,
            $user->competence ? $user->competence->nama : null,
            $user->prodi ? $user->prodi->nama : null,
            $user->role,
            $user->foto_profile
        ];
    }
}
