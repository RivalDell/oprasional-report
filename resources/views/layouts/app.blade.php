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
            background-color: #f8fafc;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Desktop Layout (Desktop >= 768px) */
        @media (min-width: 768px) {
            .sidebar-wrapper {
                width: 270px;
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                z-index: 1030;
            }
            .main-content {
                margin-left: 270px;
                padding: 2.25rem;
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
                padding: 1.25rem;
            }
        }

        /* Sidebar Styling (Premium Dark Gradient & Sleek Design) */
        .sidebar-content {
            background: linear-gradient(180deg, #0b0f19 0%, #030712 100%);
            color: #94a3b8;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.08);
        }

        /* Menu Navigation Scrollable */
        .sidebar-menu {
            overflow-y: auto;
            flex-grow: 1;
            padding: 1.5rem 1.15rem;
        }

        /* Custom Label Header Menu yang Jelas */
        .sidebar-label {
            color: #cbd5e1 !important; /* Slate 300 - Terang & Jelas */
            font-size: 10.5px;
            letter-spacing: 1.2px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sidebar-subtitle {
            color: #94a3b8 !important; /* Slate 400 - Terang & Jelas */
            font-size: 10.5px;
            letter-spacing: 0.8px;
            font-weight: 600;
        }

        /* Nav Link Styling with Smooth Transitions */
        .sidebar .nav-link {
            color: #cbd5e1;
            font-weight: 500;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.4rem;
            transition: all 0.25s ease-in-out;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.35);
        }

        /* Footer Sidebar Profile Box */
        .sidebar-footer {
            flex-shrink: 0;
            padding: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(255, 255, 255, 0.01);
        }

        .user-profile-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 0.75rem;
        }

        /* Top Header Khusus Mobile */
        .mobile-header {
            background-color: #0b0f19;
            color: #fff;
            padding: 0.85rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- TOP HEADER UNTUK MOBILE -->
    <div class="mobile-header d-md-none d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-light btn-sm border-0 bg-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                <i class="bi bi-list fs-4"></i>
            </button>
            <span class="fw-bold fs-6 text-white mb-0 tracking-wider">MBI OPERASIONAL</span>
        </div>
        <span class="badge text-white fw-bold px-2 py-1" style="background-color: #4f46e5; font-size: 11px;">
            {{ auth()->user()->role ?? 'Staff' }}
        </span>
    </div>

    <!-- SIDEBAR -->
    <div class="offcanvas-md offcanvas-start sidebar-wrapper" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="sidebar-content sidebar">
            
            <!-- HEADER DRAWER (Khusus Mobile) -->
            <div class="d-md-none d-flex justify-content-between align-items-center px-3 pt-3">
                <h5 class="fw-bold text-white mb-0 fs-6" id="sidebarOffcanvasLabel">MBI OPERASIONAL</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
            </div>

            <!-- AREA MENU UTAMA -->
            <div class="sidebar-menu">
                <div class="mb-4 px-2 d-none d-md-block">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="text-white rounded-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); font-size: 1.1rem;">M</div>
                        <div>
                            <h4 class="fw-bold mb-0 text-white" style="font-size: 1.05rem; letter-spacing: 0.5px;">MBI OPERASIONAL</h4>
                            <span class="sidebar-subtitle">MANAGEMENT SYSTEM</span>
                        </div>
                    </div>
                </div>

                <div class="sidebar-label px-3 mb-2">Menu Utama</div>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2-fill me-3 fs-5"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text-fill me-3 fs-5"></i> Laporan Operasional
                        </a>
                    </li>

                    @if(auth()->check() && auth()->user()->role === 'superadmin')
                        <div class="sidebar-label px-3 mt-4 mb-2">Master Data</div>
                        <li class="nav-item">
                            <a href="{{ route('outlets.index') }}" class="nav-link {{ request()->routeIs('outlets.*') ? 'active' : '' }}">
                                <i class="bi bi-shop me-3 fs-5"></i> Data Outlet
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="bi bi-people-fill me-3 fs-5"></i> Manajemen User
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- FOOTER SIDEBAR -->
            <div class="sidebar-footer">
                <div class="user-profile-box d-flex align-items-center mb-3">
                    <div class="text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-2 shadow-sm" style="width: 36px; height: 36px; flex-shrink: 0; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); font-size: 0.85rem;">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-bold text-truncate text-white" style="font-size: 12.5px;">{{ auth()->user()->name ?? 'Pengguna' }}</h6>
                        <span class="badge bg-secondary text-capitalize mt-0.5" style="font-size: 9.5px; opacity: 0.85;">
                            {{ auth()->user()->role ?? 'Staff' }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm w-100 d-flex align-items-center justify-content-center gap-2 border-0 text-light py-2 rounded-2" style="background-color: rgba(239, 68, 68, 0.15); color: #f87171 !important; transition: all 0.2s;">
                        <i class="bi bi-box-arrow-right fs-6"></i> <span class="fw-semibold" style="font-size: 12px;">Keluar Sistem</span>
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