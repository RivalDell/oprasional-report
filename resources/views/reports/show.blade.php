@extends('layouts.app')

@section('title', 'Detail Laporan Operasional - ' . ($report->outlet->name ?? 'Momoyo'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-danger mb-0">Detail Laporan Operasional Toko</h3>
        <small class="text-muted">{{ $report->outlet->name ?? '-' }} | {{ \Carbon\Carbon::parse($report->report_date)->translatedFormat('d F Y') }} (Shift {{ $report->shift }})</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning text-white">Edit Laporan</a>
        <a href="{{ route('reports.print', $report->id) }}" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-printer me-1"></i> Cetak
        </a>
        <a href="{{ route('reports.export-pdf', $report->id) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
    </div>
</div>

<!-- 1. INFORMASI UTAMA TOKO & SHIFT -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-danger text-white fw-bold">1. Informasi Utama Toko & Shift</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <span class="text-muted d-block small">Nama Outlet</span>
                <strong class="fs-6">{{ $report->outlet->name ?? '-' }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block small">Tanggal Laporan</span>
                <strong class="fs-6">{{ \Carbon\Carbon::parse($report->report_date)->translatedFormat('d F Y') }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block small">Shift</span>
                <span class="badge bg-primary fs-6">{{ $report->shift }}</span>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block small">Kondisi Cuaca</span>
                <strong class="fs-6">{{ $report->weather ?? 'Cerah' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- 2. SALES & FINANCIAL PERFORMANCE -->
@php $sales = $report->sales_finance ?? []; @endphp
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">2. Sales & Financial Performance</div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="p-3 bg-light rounded border">
                    <span class="text-muted d-block small">Target Sales</span>
                    <strong class="text-secondary fs-5">Rp {{ number_format($sales['target_sales'] ?? 0, 0, ',', '.') }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded border border-danger">
                    <span class="text-muted d-block small">Actual Sales</span>
                    <strong class="text-danger fs-5">Rp {{ number_format($sales['actual_sales'] ?? 0, 0, ',', '.') }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded border">
                    <span class="text-muted d-block small">Target Transaksi</span>
                    <strong class="text-secondary fs-5">{{ number_format($sales['target_transactions'] ?? 0, 0, ',', '.') }} trx</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded border border-success">
                    <span class="text-muted d-block small">Jumlah Transaksi</span>
                    <strong class="text-success fs-5">{{ number_format($sales['total_transactions'] ?? 0, 0, ',', '.') }} trx</strong>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <span class="text-muted d-block small">Cash Sales</span>
                <strong>Rp {{ number_format($sales['cash_sales'] ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block small">QRIS / E-Wallet</span>
                <strong>Rp {{ number_format($sales['qris_wallet'] ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block small">Debit/Credit Card</span>
                <strong>Rp {{ number_format($sales['debit_card'] ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block small">Online Delivery</span>
                <strong>Rp {{ number_format($sales['online_delivery'] ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block small">Cash In Drawer</span>
                <strong>Rp {{ number_format($sales['cash_in_drawer'] ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block small">Status Variansi Cash</span>
                @if(($sales['variance_status'] ?? 'Match') === 'Match')
                    <span class="badge bg-success">Match (Sesuai)</span>
                @elseif(($sales['variance_status'] ?? '') === 'Over')
                    <span class="badge bg-info text-dark">Over (Lebih)</span>
                @else
                    <span class="badge bg-danger">Short (Kurang)</span>
                @endif
            </div>
            <div class="col-md-6">
                <span class="text-muted d-block small">Penjelasan Selisih Cash</span>
                <strong>{{ $sales['cash_variance_note'] ?? '-' }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- 3. PRODUCT PERFORMANCE & TOP SALES -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">3. Product Performance & Top Sales</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Kategori / Nama Produk</th>
                        <th width="150" class="text-center">Qty Terjual</th>
                        <th width="200" class="text-end">Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($report->top_products ?? [] as $index => $prod)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $prod['product_category'] ?? '-' }}</td>
                            <td class="text-center">{{ number_format($prod['qty_sold'] ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($prod['sales_amount'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Tidak ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 4. STOCK & INVENTORY MANAGEMENT -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">4. Stock & Inventory Management</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <span class="text-muted d-block small">Status Stock Out</span>
            @if($report->is_stock_out)
                <span class="badge bg-danger">Ada Item Habis (Stock Out)</span>
            @else
                <span class="badge bg-success">Aman (Tidak ada stock out)</span>
            @endif
        </div>
        <div class="col-md-8">
            <span class="text-muted d-block small">Daftar Item Low Stock / Habis</span>
            <strong>{{ $report->low_stock_items ?? '-' }}</strong>
        </div>
    </div>
</div>

<!-- 5. STAFF ATTENDANCE & KEHADIRAN CREW -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">5. Staff Attendance & Kehadiran Crew</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Nama Karyawan / Crew</th>
                        <th>Jabatan</th>
                        <th width="150" class="text-center">Status Kehadiran</th>
                        <th>Keterangan / Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($report->attendances ?? [] as $index => $att)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $att['staff_name'] ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $att['schedule'] ?? 'Crew' }}</span></td>
                            <td class="text-center">
                                @php $status = $att['attendance_status'] ?? 'Hadir'; @endphp
                                @if($status === 'Hadir')
                                    <span class="badge bg-success">Hadir</span>
                                @elseif($status === 'Izin' || $status === 'Sakit')
                                    <span class="badge bg-warning text-dark">{{ $status }}</span>
                                @elseif($status === 'Alpha')
                                    <span class="badge bg-danger">Alpha</span>
                                @else
                                    <span class="badge bg-secondary">{{ $status }}</span>
                                @endif
                            </td>
                            <td>{{ $att['remarks'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Tidak ada data absensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 6. KONDISI KEBERSIHAN & STANDAR TOKO -->
@php $hyg = $report->hygiene ?? []; @endphp
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">6. Kondisi Kebersihan & Standar Toko</div>
    <div class="card-body row g-3">
        <div class="col-md-3">
            <span class="text-muted d-block small">Bar & Counter</span>
            <strong>{{ $hyg['bar'] ?? 'Bersih & Rapih' }}</strong>
        </div>
        <div class="col-md-3">
            <span class="text-muted d-block small">Dine In & Meja</span>
            <strong>{{ $hyg['dine_in'] ?? 'Bersih & Rapih' }}</strong>
        </div>
        <div class="col-md-3">
            <span class="text-muted d-block small">Dapur & Gudang</span>
            <strong>{{ $hyg['kitchen'] ?? 'Bersih & Rapih' }}</strong>
        </div>
        <div class="col-md-3">
            <span class="text-muted d-block small">Toilet & Fasilitas</span>
            <strong>{{ $hyg['toilet'] ?? 'Bersih & Rapih' }}</strong>
        </div>
    </div>
</div>

<!-- 7. PEMELIHARAAN MESIN & PERALATAN TOKO -->
@php $eq = $report->equipment ?? []; @endphp
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">7. Pemeliharaan Mesin & Peralatan Toko</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <span class="text-muted d-block small">Mesin Ice Cream</span>
            <strong>{{ $eq['ice_cream_machine'] ?? 'Normal' }}</strong>
        </div>
        <div class="col-md-4">
            <span class="text-muted d-block small">Chiller & Freezer</span>
            <strong>{{ $eq['chiller_freezer'] ?? 'Normal' }}</strong>
        </div>
        <div class="col-md-4">
            <span class="text-muted d-block small">POS Kasir & Printer</span>
            <strong>{{ $eq['pos_printer'] ?? 'Normal' }}</strong>
        </div>
        <div class="col-md-12">
            <span class="text-muted d-block small">Catatan Kerusakan Peralatan</span>
            <strong>{{ $eq['maintenance_note'] ?? '-' }}</strong>
        </div>
    </div>
</div>

<!-- 8. PROMOSI & MARKETING TOKO -->
@php $mkt = $report->marketing ?? []; @endphp
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">8. Promosi & Marketing Toko</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <span class="text-muted d-block small">Promosi Aktif Hari Ini</span>
            <strong>{{ $mkt['active_promo'] ?? '-' }}</strong>
        </div>
        <div class="col-md-6">
            <span class="text-muted d-block small">Respon Pelanggan & Masukan (Feedback)</span>
            <strong>{{ $mkt['customer_feedback'] ?? '-' }}</strong>
        </div>
    </div>
</div>

<!-- 9. DAILY ISSUE & ACTION PLAN -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">9. Daily Issue & Action Plan</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Masalah (Issue)</th>
                        <th>Akar Masalah</th>
                        <th>Tindakan Perbaikan</th>
                        <th width="150">PIC</th>
                        <th width="150">Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($report->action_plans ?? [] as $index => $act)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $act['issue'] ?? '-' }}</td>
                            <td>{{ $act['root_cause'] ?? '-' }}</td>
                            <td>{{ $act['corrective_action'] ?? '-' }}</td>
                            <td>{{ $act['pic'] ?? '-' }}</td>
                            <td>{{ !empty($act['deadline']) ? \Carbon\Carbon::parse($act['deadline'])->format('d/m/Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Tidak ada catatan masalah/isu operasional.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 10. RINGKASAN HARIAN & EVALUASI TARGET -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">10. Ringkasan Harian & Evaluasi Target</div>
    <div class="card-body row g-3">
        <div class="col-md-3">
            <span class="text-muted d-block small">Performance Rating</span>
            @php $rating = $report->performance_rating; @endphp
            @if($rating === 'Excellent')
                <span class="badge bg-success fs-6">Excellent</span>
            @elseif($rating === 'Good')
                <span class="badge bg-info text-dark fs-6">Good</span>
            @elseif($rating === 'Average')
                <span class="badge bg-warning text-dark fs-6">Average</span>
            @else
                <span class="badge bg-danger fs-6">Below Target</span>
            @endif
        </div>
        <div class="col-md-9">
            <span class="text-muted d-block small">Pencapaian Utama (Key Achievement)</span>
            <strong>{{ $report->key_achievement ?? '-' }}</strong>
        </div>
        <div class="col-md-6">
            <span class="text-muted d-block small">Kendala Utama (Main Problem)</span>
            <strong>{{ $report->main_problem ?? '-' }}</strong>
        </div>
        <div class="col-md-6">
            <span class="text-muted d-block small">Rencana Tindakan Besok (Action for Tomorrow)</span>
            <strong>{{ $report->action_for_tomorrow ?? '-' }}</strong>
        </div>
    </div>
</div>

<!-- 11. OTORISASI & PENANGGUNG JAWAB -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">11. Otorisasi & Penanggung Jawab</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <span class="text-muted d-block small">Dibuat Oleh</span>
            <strong class="fs-6">{{ $report->prepared_by ?? '-' }}</strong>
        </div>
        <div class="col-md-4">
            <span class="text-muted d-block small">Supervisor</span>
            <strong class="fs-6">{{ $report->supervisor_name ?? '-' }}</strong>
        </div>
        <div class="col-md-4">
            <span class="text-muted d-block small">Store Manager</span>
            <strong class="fs-6">{{ $report->store_manager_name ?? '-' }}</strong>
        </div>
    </div>
</div>
@endsection