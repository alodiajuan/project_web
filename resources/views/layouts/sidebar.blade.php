<style>
    .sidebar {
        min-height: 100vh;
        width: 250px;
        background: linear-gradient(180deg, #1e3a8a 0%, #172554 100%);
        color: #f3f4f6;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar .form-inline {
        padding: 1rem;
        border-bottom: 1px solid rgba(59, 130, 246, 0.2);
    }

    .form-control-sidebar {
        width: 100%;
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        background-color: rgba(30, 58, 138, 0.3);
        border: none;
        border-radius: 0.5rem;
        color: #f3f4f6;
    }

    .form-control-sidebar::placeholder {
        color: #9ca3af;
    }

    .form-control-sidebar:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    .btn-sidebar {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        background: none;
        border: none;
    }

    .nav-header {
        padding: 1rem 1.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #60a5fa;
        margin-top: 1.5rem;
        border-top: 1px solid rgba(59, 130, 246, 0.1);
    }

    .nav-sidebar {
        padding: 0.5rem;
    }

    .nav-item {
        margin-bottom: 0.25rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: #e5e7eb;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .nav-link:hover {
        background-color: rgba(30, 58, 138, 0.5);
        color: #ffffff;
        transform: translateX(4px);
    }

    .nav-link.active {
        background-color: #1d4ed8;
        color: #ffffff;
        position: relative;
    }

    .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        width: 4px;
        height: 100%;
        background-color: #60a5fa;
        border-radius: 0 4px 4px 0;
    }

    .nav-icon {
        margin-right: 0.75rem;
        font-size: 1.25rem;
        width: 1.25rem;
        text-align: center;
        opacity: 0.8;
    }

    .nav-link:hover .nav-icon {
        opacity: 1;
    }

    .text-truncate {
        margin-left: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .text-truncate {
            font-size: 0.875rem;
        }
    }
</style>

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
                <li class="nav-item">
                    <a href="{{ url('/periode') }}" class="nav-link {{ $activeMenu == 'periode' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-check-circle"></i>
                        <span class="text-truncate">Tahun Ajaran</span>
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
                <li class="nav-item">
                    <a href="{{ url('/tugas') }}" class="nav-link {{ $activeMenu == 'tugas' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <span class="text-truncate">Tugas</span>
                    </a>
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

            @if (in_array($userRole, ['admin', 'dosen', 'tendik']))
                <li class="nav-item">
                    <a href="{{ url('/pengajuan') }}"
                        class="nav-link {{ $activeMenu == 'pengajuan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <span class="text-truncate">Pengajuan</span>
                    </a>
                </li>
                @if (in_array($userRole, ['admin']))
                    <li class="nav-item">
                        <a href="{{ url('/riwayat') }}"
                            class="nav-link {{ $activeMenu == 'riwayat' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <span class="text-truncate">Riwayat</span>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </nav>
</div>
