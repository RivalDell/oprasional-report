@extends('layouts.app')

@section('title', 'Daftar Laporan Operasional - Momoyo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-danger mb-0">Daftar Laporan Operasional Harian</h3>
        <small class="text-muted">Momoyo Operational Management System</small>
    </div>
    
    @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('reports.create') }}" class="btn btn-danger">+ Buat Laporan Baru</a>
    @endif
</div>

<!-- Notifikasi Sukses -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Form Filter & Pencarian -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('reports.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">Outlet</label>
                <select name="outlet_id" class="form-select">
                    <option value="">-- Semua Outlet --</option>
                    @foreach($outlets as $outlet)
                        <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>
                            {{ $outlet->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Shift</label>
                <select name="shift" class="form-select">
                    <option value="">-- Semua Shift --</option>
                    <option value="Opening" {{ request('shift') == 'Opening' ? 'selected' : '' }}>Opening</option>
                    <option value="Middle" {{ request('shift') == 'Middle' ? 'selected' : '' }}>Middle</option>
                    <option value="Closing" {{ request('shift') == 'Closing' ? 'selected' : '' }}>Closing</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end gap-1">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary" title="Reset">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Data Laporan -->
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Outlet</th>
                        <th>Shift</th>
                        <th>Actual Sales</th>
                        <th>Rating</th>
                        <th>Dibuat Oleh</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $index => $report)
                        <tr>
                            <td>{{ $index + 1 + ($reports->currentPage() - 1) * $reports->perPage() }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d-m-Y') }}</td>
                            <td><span class="badge bg-secondary">{{ $report->outlet->name ?? 'N/A' }}</span></td>
                            <td>{{ $report->shift }}</td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($report->sales_finance['actual_sales'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($report->performance_rating === 'Excellent')
                                    <span class="badge bg-success">Excellent</span>
                                @elseif($report->performance_rating === 'Good')
                                    <span class="badge bg-info text-dark">Good</span>
                                @elseif($report->performance_rating === 'Average')
                                    <span class="badge bg-warning text-dark">Average</span>
                                @else
                                    <span class="badge bg-danger">Below Target</span>
                                @endif
                            </td>
                            <td>{{ $report->prepared_by }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('reports.show', $report->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                    <a href="{{ route('reports.export-pdf', $report->id) }}" class="btn btn-sm btn-outline-success">PDF</a>

                                    @if(auth()->user()->role === 'superadmin')
                                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada laporan operasional yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-end mt-3">
    {{ $reports->links() }}
</div>
@endsection