<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Momoyo Operational System')</title>
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* Desktop Layout (Desktop >= 768px) */
        @media (min-width: 768px) {
            .sidebar-wrapper {
                width: 260px;
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                z-index: 1030;
            }
            .main-content {
                margin-left: 260px;
                padding: 2rem;
                min-height: 100vh;
            }
        }

        /* Mobile Layout (Mobile < 768px) */
        @media (max-width: 767.98px) {
            .sidebar-wrapper {
                width: 280px;
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }

        /* Sidebar Styling */
        .sidebar-content {
            background-color: #dc3545; /* Merah Momoyo */
            color: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Menu Navigation Scrollable */
        .sidebar-menu {
            overflow-y: auto;
            flex-grow: 1;
            padding: 1.25rem 1rem;
        }

        /* Nav Link Styling */
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #dc3545;
            background-color: #ffffff;
            font-weight: 600;
        }

        /* Footer Sidebar (Profil & Logout Locked at Bottom) */
        .sidebar-footer {
            flex-shrink: 0;
            padding: 1.25rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            background-color: #dc3545;
        }

        /* Top Header Khusus Mobile */
        .mobile-header {
            background-color: #dc3545;
            color: #fff;
            padding: 0.75rem 1rem;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- TOP HEADER UNTUK MOBILE (Hanya tampil di layar HP) -->
    <div class="mobile-header d-md-none d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                <i class="bi bi-list fs-4"></i>
            </button>
            <span class="fw-bold fs-5 text-white mb-0">MOMOYO</span>
        </div>
        <span class="badge bg-white text-danger fw-bold" style="font-size: 11px;">
            {{ auth()->user()->role ?? 'Staff' }}
        </span>
    </div>

    <!-- SIDEBAR (DESKTOP FIXED & MOBILE OFFCANVAS) -->
    <div class="offcanvas-md offcanvas-start sidebar-wrapper" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="sidebar-content sidebar">
            
            <!-- HEADER DRAWER (Khusus Mobile) -->
            <div class="d-md-none d-flex justify-content-between align-items-center px-3 pt-3">
                <h5 class="fw-bold text-white mb-0" id="sidebarOffcanvasLabel">MOMOYO OPERATIONAL</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
            </div>

            <!-- AREA MENU UTAMA -->
            <div class="sidebar-menu">
                <div class="mb-4 px-2 d-none d-md-block">
                    <h4 class="fw-bold mb-0 text-white">MOMOYO</h4>
                    <small class="text-white-50" style="font-size: 11px; letter-spacing: 0.5px;">Operational System</small>
                </div>

                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text me-2"></i> Laporan Operasional
                        </a>
                    </li>

                    @if(auth()->check() && auth()->user()->role === 'superadmin')
                        <div class="text-white-50 small fw-bold px-3 mt-4 mb-2" style="font-size: 11px;">MASTER DATA</div>
                        <li class="nav-item">
                            <a href="{{ route('outlets.index') }}" class="nav-link {{ request()->routeIs('outlets.*') ? 'active' : '' }}">
                                <i class="bi bi-shop me-2"></i> Data Outlet
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="bi bi-people me-2"></i> Manajemen User
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- FOOTER SIDEBAR (NAMA PROFIL & LOGOUT KIRI BAWAH) -->
            <div class="sidebar-footer">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px; flex-shrink: 0;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-bold text-truncate text-white" style="font-size: 13px;">{{ auth()->user()->name ?? 'Pengguna' }}</h6>
                        <span class="badge bg-dark text-capitalize" style="font-size: 10px;">
                            {{ auth()->user()->role ?? 'Staff' }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100 d-flex align-items-center justify-content-center gap-1">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>