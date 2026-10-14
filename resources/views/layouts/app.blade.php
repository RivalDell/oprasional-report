<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'MBI Operasional') }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">

    <!-- Sidebar Modern MBI -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between hidden md:flex shrink-0">
        <div>
            <!-- Branding Header -->
            <div class="h-20 flex items-center px-6 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black text-xl shadow-md shadow-blue-500/20">
                        M
                    </div>
                    <div>
                        <span class="text-lg font-black tracking-wider text-slate-900 block leading-tight">MBI</span>
                        <span class="text-[11px] font-semibold text-blue-600 tracking-wider uppercase">Operational System</span>
                    </div>
                </div>
            </div>

            <!-- Menu Navigation -->
            <nav class="p-4 space-y-1.5">
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Utama</p>
                
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 bg-blue-50 text-blue-600 shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>

                <a href="#" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan Operasional
                </a>

                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-6 mb-2">Master Data</p>

                <a href="#" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Data Outlet
                </a>

                <a href="#" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manajemen User
                </a>
            </nav>
        </div>

        <!-- User Profile Footer -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center mb-3 px-2">
                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm border border-blue-200">
                    {{ substr(Auth::user()->name ?? 'S', 0, 1) }}
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name ?? 'Super Admin' }}</p>
                    <p class="text-xs text-slate-500 truncate">Superadmin</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 rounded-xl bg-white hover:bg-red-50 hover:text-red-600 hover:border-red-200 text-slate-600 text-xs font-semibold transition duration-200 border border-slate-200 shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Content Area -->
    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <div class="p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-8">
            @yield('content')
        </div>
    </main>

</body>
</html>