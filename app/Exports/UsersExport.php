<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function view(): View
    {
        return view('exports.users', [
            'users' => $this->users
        ]);
    }

    // public function collection()
    // {
    //     return $this->users;
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Username',
    //         'Password',
    //         'Nama',
    //         'Semester',
    //         'Kompetensi',
    //         'Prodi',
    //         'Role',
    //         'Foto Profile'
    //     ];
    // }

    // public function map($user): array
    // {
    //     return [
    //         $user->username,
    //         $user->password,
    //         $user->nama,
    //         $user->semester,
    //         $user->competence ? $user->competence->nama : null,
    //         $user->prodi ? $user->prodi->nama : null,
    //         $user->role,
    //         $user->foto_profile
    //     ];
    // }
}
