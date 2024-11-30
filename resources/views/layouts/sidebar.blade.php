<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <span class="text-truncate">Dashboard</span>
                </a>
            </li>

            <!-- Data User Section -->
            <li class="nav-header">Data User</li>
            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ $activeMenu == 'level' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <span class="text-truncate">Level User</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/sdm') }}" class="nav-link {{ $activeMenu == 'sdm' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-shield"></i>
                    <span class="text-truncate">Data SDM</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/mahasiswa') }}" class="nav-link {{ $activeMenu == 'mahasiswa' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-graduate"></i>
                    <span class="text-truncate">Data Mahasiswa</span>
                </a>
            </li>
            </li>
            <li class="nav-item">
                <a href="{{ url('/kompetensi') }}" class="nav-link {{ $activeMenu == 'kompetensi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-book"></i>
                    <span class="text-truncate">Kompetensi Mahasiswa</span>
                </a>
            </li>

            <!-- Pekerjaan Section -->
            <li class="nav-header">Pekerjaan</li>
            <li class="nav-item">
                <a href="{{ url('/tugas') }}" class="nav-link {{ $activeMenu == 'tugas' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <span class="text-truncate">Buat Tugas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/kategori') }}" class="nav-link {{ $activeMenu == 'kategori' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tags"></i>
                    <span class="text-truncate">Kategori Soal</span>
                </a>
            </li>

            <!-- Kompensasi Section -->
            <li class="nav-header">Kompensasi</li>
            <li class="nav-item">
                <a href="{{ url('/presensi') }}" class="nav-link {{ $activeMenu == 'presensi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-history"></i>
                    <span class="text-truncate">Riwayat Pengajuan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/presensi') }}" class="nav-link {{ $activeMenu == 'presensi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <span class="text-truncate">Presensi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/prodi') }}" class="nav-link {{ $activeMenu == 'prodi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <span class="text-truncate">Prodi</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
