<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MBI Operasional System')</title>
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f1f5f9;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        /* Sidebar Styling (Modern Indigo/Slate) */
        .sidebar-content {
            background-color: #0f172a; /* Slate 900 */
            color: #f8fafc;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
            border-right: 1px solid #1e293b;
        }

        /* Menu Navigation Scrollable */
        .sidebar-menu {
            overflow-y: auto;
            flex-grow: 1;
            padding: 1.25rem 1rem;
        }

        /* Nav Link Styling */
        .sidebar .nav-link {
            color: #94a3b8;
            font-weight: 500;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.35rem;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: #4f46e5; /* Indigo 600 */
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        /* Footer Sidebar */
        .sidebar-footer {
            flex-shrink: 0;
            padding: 1.25rem 1rem;
            border-top: 1px solid #1e293b;
            background-color: #090d16;
        }

        /* Top Header Khusus Mobile */
        .mobile-header {
            background-color: #0f172a;
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

    <!-- TOP HEADER UNTUK MOBILE -->
    <div class="mobile-header d-md-none d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                <i class="bi bi-list fs-4"></i>
            </button>
            <span class="fw-bold fs-5 text-white mb-0">MBI OPERASIONAL</span>
        </div>
        <span class="badge bg-indigo text-white fw-bold" style="background-color: #4f46e5; font-size: 11px;">
            {{ auth()->user()->role ?? 'Staff' }}
        </span>
    </div>

    <!-- SIDEBAR -->
    <div class="offcanvas-md offcanvas-start sidebar-wrapper" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="sidebar-content sidebar">
            
            <!-- HEADER DRAWER (Khusus Mobile) -->
            <div class="d-md-none d-flex justify-content-between align-items-center px-3 pt-3">
                <h5 class="fw-bold text-white mb-0" id="sidebarOffcanvasLabel">MBI OPERASIONAL</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
            </div>

            <!-- AREA MENU UTAMA -->
            <div class="sidebar-menu">
                <div class="mb-4 px-2 d-none d-md-block">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div class="bg-indigo text-white rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; background-color: #4f46e5;">M</div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.15rem; letter-spacing: 0.5px;">MBI OPERASIONAL</h4>
                    </div>
                    <small class="text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Management System</small>
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
                        <div class="text-muted small fw-bold px-3 mt-4 mb-2" style="font-size: 11px; letter-spacing: 0.8px;">MASTER DATA</div>
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

            <!-- FOOTER SIDEBAR -->
            <div class="sidebar-footer">
                <div class="d-flex align-items-center mb-3">
                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 38px; height: 38px; flex-shrink: 0; background-color: #4f46e5;">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-bold text-truncate text-white" style="font-size: 13px;">{{ auth()->user()->name ?? 'Pengguna' }}</h6>
                        <span class="badge bg-secondary text-capitalize mt-1" style="font-size: 10px;">
                            {{ auth()->user()->role ?? 'Staff' }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100 d-flex align-items-center justify-content-center gap-1 border-secondary text-light">
                        <i class="bi bi-box-arrow-right"></i> Keluar Sistem
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