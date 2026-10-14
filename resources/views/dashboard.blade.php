@extends('layouts.app')

@section('content')
<div class="space-y-8">

    <!-- Banner Welcome MBI Operasional -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 p-8 text-white shadow-xl shadow-blue-500/10">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold tracking-wider uppercase mb-3 backdrop-blur-md">
                    MBI OPERATIONAL MANAGEMENT
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="text-blue-100 mt-1 text-sm">
                    Hari ini: <span class="font-semibold">{{ now()->translatedFormat('l, d F Y') }}</span> | Total Outlet Terdaftar: <span class="font-semibold">2 Outlet</span>
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="#" class="px-5 py-2.5 rounded-xl bg-white text-blue-600 hover:bg-blue-50 font-bold text-sm shadow-md transition duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Laporan Harian
                </a>
                <a href="#" class="px-5 py-2.5 rounded-xl bg-blue-800/40 hover:bg-blue-800/60 text-white font-semibold text-sm border border-white/20 transition duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Kelola Outlet
                </a>
            </div>
        </div>
    </div>

    <!-- Ringkasan Kinerja Section -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Ringkasan Kinerja Toko</h3>
                <p class="text-xs text-slate-500">Data akumulasi operasional kemarin: <span class="font-medium text-slate-700">{{ now()->subDay()->translatedFormat('d F Y') }}</span></p>
            </div>
            <div>
                <select class="bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-xl px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>-- Semua Outlet --</option>
                </select>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Actual Sales -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden">
                <div class="w-1.5 h-full bg-blue-600 absolute left-0 top-0"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Actual Sales Kemarin</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <h4 class="text-2xl font-black text-slate-900">Rp 0</h4>
                <p class="text-xs text-slate-400 mt-1">Target: Rp 0</p>
            </div>

            <!-- Target -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden">
                <div class="w-1.5 h-full bg-emerald-500 absolute left-0 top-0"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pencapaian Target</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
                <h4 class="text-2xl font-black text-emerald-600">0%</h4>
                <p class="text-xs text-slate-400 mt-1">Dari total target harian</p>
            </div>

            <!-- Total Transaksi -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden">
                <div class="w-1.5 h-full bg-cyan-500 absolute left-0 top-0"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Transaksi</span>
                    <div class="w-9 h-9 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                </div>
                <h4 class="text-2xl font-black text-slate-900">0</h4>
                <p class="text-xs text-slate-400 mt-1">Jumlah struk/transaksi kemarin</p>
            </div>

            <!-- Laporan Masuk -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden">
                <div class="w-1.5 h-full bg-amber-500 absolute left-0 top-0"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Laporan Masuk</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <h4 class="text-2xl font-black text-amber-500">0</h4>
                <p class="text-xs text-slate-400 mt-1">Total shift terlapor kemarin</p>
            </div>
        </div>
    </div>

    <!-- Status Operational Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-900 text-sm">Alert Stock Out (Item Habis)</h4>
                <p class="text-xs text-slate-500 mt-0.5">Aman! Tidak ada laporan stock out terbaru.</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-900 text-sm">Performa Shift Membutuhkan Evaluasi</h4>
                <p class="text-xs text-slate-500 mt-0.5">Semua performa shift toko berada dalam kondisi baik.</p>
            </div>
        </div>
    </div>

</div>
@endsection