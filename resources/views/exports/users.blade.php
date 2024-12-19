<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Semester</th>
            <th>Kompetensi</th>
            <th>Program Studi</th>
            <th>Foto Profil</th>
            <th>Alfa</th>
            <th>Kompensasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->semester ?? '-' }}</td>
                <td>{{ optional($user->competence)->nama ?? '-' }}</td>
                <td>{{ optional($user->prodi)->nama ?? '-' }}</td>
                <td>{{ $user->foto_profile ?? '-' }}</td>
                <td>{{ $user->alfa ?? '-' }}</td>
                <td>{{ $user->compensation ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
