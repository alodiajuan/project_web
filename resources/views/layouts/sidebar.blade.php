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

    @php
        $userRole = Auth::user()->role;
    @endphp

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

            @if (in_array($userRole, ['admin']))
                <!-- Data User Section -->
                <li class="nav-header">Management Users</li>
                <li class="nav-item">
                    <a href="{{ url('/mahasiswa') }}" class="nav-link {{ $activeMenu == 'mahasiswa' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <span class="text-truncate">Data Mahasiswa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/sdm') }}" class="nav-link {{ $activeMenu == 'sdm' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <span class="text-truncate">Data SDM</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/kompetensi') }}"
                        class="nav-link {{ $activeMenu == 'kompetensi' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <span class="text-truncate">Kompetensi Mahasiswa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/prodi') }}" class="nav-link {{ $activeMenu == 'prodi' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-check-circle"></i>
                        <span class="text-truncate">Program Studi</span>
                    </a>
                </li>
            @endif

            <!-- Pekerjaan Section -->
            @if (in_array($userRole, ['admin', 'dosen', 'tendik']))
                <li class="nav-header">Management Task</li>
                @if (in_array($userRole, ['admin']))
                    <li class="nav-item">
                        <a href="{{ url('/kategori-tugas') }}"
                            class="nav-link {{ $activeMenu == 'kategori-tugas' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <span class="text-truncate">Kategori Tugas</span>
                        </a>
                    </li>
                @endif
                </li>
            @else
                <li class="nav-header">Pekerjaan</li>
                <li class="nav-item">
                    <a href="{{ url('/tasks') }}" class="nav-link {{ $activeMenu == 'tasks' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <span class="text-truncate">Tugas</span>
                    </a>
            @endif


            <!-- Kompensasi Section -->
            <li class="nav-header">Kompensasi</li>
            @if (in_array($userRole, ['mahasiswa']))
                <li class="nav-item">
                    <a href="{{ url('/kompensasi') }}"
                        class="nav-link {{ $activeMenu == 'kompensasi' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <span class="text-truncate">Kompensasi</span>
                    </a>
                </li>
            @endif

            @if (in_array($userRole, ['admin']))
                <li class="nav-item">
                    <a href="{{ url('/pengajuan') }}"
                        class="nav-link {{ $activeMenu == 'pengajuan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <span class="text-truncate">Pengajuan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/riwayat') }}" class="nav-link {{ $activeMenu == 'riwayat' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <span class="text-truncate">Riwayat</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
