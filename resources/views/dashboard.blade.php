@extends('layouts.app')

@section('title', 'Dashboard - MBI Operasional')

@section('content')
<!-- BANNER UCAPAN & QUICK ACTIONS -->
<div class="card text-white border-0 shadow-sm mb-4 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);">
    <div class="card-body p-4 p-lg-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <span class="badge bg-white text-indigo fw-bold mb-2 px-3 py-2 rounded-pill" style="color: #4f46e5; font-size: 11px; letter-spacing: 0.5px;">MBI OPERATIONAL MANAGEMENT</span>
            <h3 class="fw-bold mb-1 text-white">Selamat Datang, {{ auth()->user()->name ?? 'User' }}!</h3>
            <p class="mb-0 text-white-50 small">
                Hari ini: <strong class="text-white">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong> | Total Outlet Terdaftar: <strong class="text-white">{{ $totalOutlets }} Outlet</strong>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('reports.create') }}" class="btn btn-light fw-bold px-4 py-2 rounded-3 shadow-sm" style="color: #4f46e5;">
                <i class="bi bi-plus-circle me-1"></i> Buat Laporan Harian
            </a>
            @if(auth()->check() && auth()->user()->role === 'superadmin')
                <a href="{{ route('outlets.index') }}" class="btn btn-outline-light px-3 py-2 rounded-3">
                    <i class="bi bi-shop me-1"></i> Kelola Outlet
                </a>
            @endif
        </div>
    </div>
</div>

<!-- FILTER OUTLET & HEADLINE -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-0">Ringkasan Kinerja Toko</h4>
        <small class="text-muted">Data akumulasi operasional kemarin: <strong>{{ \Carbon\Carbon::parse($yesterday)->translatedFormat('d F Y') }}</strong></small>
    </div>

    <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2">
        <select name="outlet_id" class="form-select form-select-sm shadow-sm rounded-3 px-3" onchange="this.form.submit()">
            <option value="">-- Semua Outlet --</option>
            @foreach($outlets as $outlet)
                <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>
                    {{ $outlet->name }}
                </option>
            @endforeach
        </select>
        @if(request('outlet_id'))
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary rounded-3">Reset</a>
        @endif
    </form>
</div>

<!-- KARTU RINGKASAN DATA KEMARIN -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-4 border-primary h-100 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Actual Sales Kemarin</span>
                    <i class="bi bi-cash-stack fs-4 text-primary"></i>
                </div>
                <h3 class="fw-bold text-dark mb-1 fs-4">Rp {{ number_format($totalActualSales, 0, ',', '.') }}</h3>
                <small class="text-muted">Target: Rp {{ number_format($totalTargetSales, 0, ',', '.') }}</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-4 border-success h-100 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Pencapaian Target</span>
                    <i class="bi bi-graph-up-arrow fs-4 text-success"></i>
                </div>
                <h3 class="fw-bold text-success mb-1 fs-4">{{ $salesAchievementRate }}%</h3>
                <small class="text-muted">Dari total target harian</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-4 border-info h-100 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Transaksi</span>
                    <i class="bi bi-receipt fs-4 text-info"></i>
                </div>
                <h3 class="fw-bold text-dark mb-1 fs-4">{{ number_format($totalTransactions, 0, ',', '.') }}</h3>
                <small class="text-muted">Jumlah struk/transaksi kemarin</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-4 border-warning h-100 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Laporan Masuk</span>
                    <i class="bi bi-journal-check fs-4 text-warning"></i>
                </div>
                <h3 class="fw-bold text-dark mb-1 fs-4">{{ $yesterdayReportCount }}</h3>
                <small class="text-muted">Total shift terlaporkan kemarin</small>
            </div>
        </div>
    </div>
</div>

<!-- PAPAN ALERT & PERHATIAN OPERASIONAL -->
<div class="row g-3 mb-4">
    <!-- ALERT STOCK OUT -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100 rounded-3">
            <div class="card-header bg-slate text-white fw-bold d-flex align-items-center py-3 bg-dark">
                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Alert Stock Out (Item Habis)
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($stockOutAlerts as $alert)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                            <div>
                                <strong class="text-danger">{{ $alert->outlet->name ?? '-' }}</strong>
                                <small class="text-muted d-block">{{ \Carbon\Carbon::parse($alert->report_date)->format('d/m/Y') }} - Shift {{ $alert->shift }}</small>
                                <small class="text-dark"><strong>Item Habis:</strong> {{ $alert->low_stock_items ?? 'Bahan habis' }}</small>
                            </div>
                            <a href="{{ route('reports.show', $alert->id) }}" class="btn btn-sm btn-outline-secondary rounded-2">Cek</a>
                        </li>
                    @empty
                        <li class="list-group-item py-4 text-center text-muted">Aman! Tidak ada laporan stock out terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- ALERT PERFORMA BELOW TARGET -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100 rounded-3">
            <div class="card-header bg-slate text-white fw-bold d-flex align-items-center py-3 bg-dark">
                <i class="bi bi-arrow-down-circle-fill text-danger me-2"></i> Performa Shift Membutuhkan Evaluasi
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($belowTargetAlerts as $alert)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                            <div>
                                <strong class="text-dark">{{ $alert->outlet->name ?? '-' }}</strong>
                                <span class="badge bg-danger ms-1">Below Target</span>
                                <small class="text-muted d-block">{{ \Carbon\Carbon::parse($alert->report_date)->format('d/m/Y') }} - Shift {{ $alert->shift }}</small>
                                <small class="text-muted"><strong>Kendala:</strong> {{ Str::limit($alert->main_problem ?? 'Tidak ada catatan', 50) }}</small>
                            </div>
                            <a href="{{ route('reports.show', $alert->id) }}" class="btn btn-sm btn-outline-danger rounded-2">Detail</a>
                        </li>
                    @empty
                        <li class="list-group-item py-4 text-center text-muted">Semua performa shift toko berada dalam kondisi baik.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- TABEL DAFTAR SEMUA LAPORAN TERBARU -->
<div class="card shadow-sm border-0 mb-4 rounded-3 overflow-hidden">
    <div class="card-header text-white d-flex justify-content-between align-items-center fw-bold py-3 px-4" style="background-color: #1e293b;">
        <span>Rincian Seluruh Laporan Operasional Harian</span>
        <a href="{{ route('reports.create') }}" class="btn btn-sm btn-light text-dark fw-bold px-3">+ Buat Laporan Baru</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-secondary small uppercase">
                    <tr>
                        <th width="50" class="text-center py-3">#</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Outlet</th>
                        <th class="py-3">Shift</th>
                        <th class="py-3">Actual Sales</th>
                        <th class="py-3">Transaksi</th>
                        <th class="py-3">Status Stok</th>
                        <th class="py-3">Performance</th>
                        <th class="py-3">Dibuat Oleh</th>
                        <th width="140" class="text-center py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestReports as $index => $report)
                        @php $sales = $report->sales_finance ?? []; @endphp
                        <tr>
                            <td class="text-center">{{ $index + 1 + ($latestReports->currentPage() - 1) * $latestReports->perPage() }}</td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($report->report_date)->format('d/m/Y') }}</strong>
                            </td>
                            <td class="fw-bold">{{ $report->outlet->name ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $report->shift }}</span></td>
                            <td class="fw-bold text-primary">Rp {{ number_format($sales['actual_sales'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($sales['total_transactions'] ?? 0, 0, ',', '.') }} trx</td>
                            <td>
                                @if($report->is_stock_out)
                                    <span class="badge bg-danger">Stock Out</span>
                                @else
                                    <span class="badge bg-success">Aman</span>
                                @endif
                            </td>
                            <td>
                                @php $rating = $report->performance_rating; @endphp
                                @if($rating === 'Excellent')
                                    <span class="badge bg-success">Excellent</span>
                                @elseif($rating === 'Good')
                                    <span class="badge bg-info text-dark">Good</span>
                                @elseif($rating === 'Average')
                                    <span class="badge bg-warning text-dark">Average</span>
                                @else
                                    <span class="badge bg-danger">Below Target</span>
                                @endif
                            </td>
                            <td>{{ $report->prepared_by }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('reports.show', $report->id) }}" class="btn btn-outline-primary" title="Lihat Detail">
                                        Detail
                                    </a>
                                    <a href="{{ route('reports.print', $report->id) }}" target="_blank" class="btn btn-outline-secondary" title="Cetak">
                                        🖨️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Belum ada laporan operasional yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PAGINATION -->
<div class="d-flex justify-content-end mb-4">
    {{ $latestReports->links() }}
</div>
@endsection