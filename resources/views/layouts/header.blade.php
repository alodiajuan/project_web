<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="../../index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Profile -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .avatar {
                width: 40px;
                height: 40px;
                object-fit: cover;
                margin-top: -2px;
            }

            .navbar-nav .nav-link {
                display: flex;
                align-items: center;
                padding-top: 0;
                padding-bottom: 0;
                margin-top: -5px;
            }

            .dropdown-menu {
                min-width: 200px;
            }

            .user-info {
                font-size: 0.9rem;
            }
        </style>
        @php
            $user = Auth::user();
        @endphp

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                data-toggle="dropdown">
                <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('img/default-avatar.png') }}"
                    class="avatar img-fluid rounded-circle" alt="Profile Image" />
                <span class="text-dark">{{ $user->nama }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow">
                <div class="px-4 py-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('img/default-avatar.png') }}"
                            class="avatar rounded-circle me-3" alt="Profile Image">
                        <div>
                            <h6 class="mb-0">{{ $user->nama }}</h6>
                            <small class="text-muted">
                                <strong>{{ $user->role }}</strong>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item py-2" href="/profile">
                    <i class="fas fa-user me-2"></i> Edit Profile
                </a>
                <a class="dropdown-item py-2" href="/logout" <i class="fas fa-sign-out-alt me-2"></i> Log Out
                </a>
            </div>
        </li>
    </ul>
</nav>
