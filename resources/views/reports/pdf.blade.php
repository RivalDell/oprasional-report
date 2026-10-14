<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Operasional - MBI Operasional</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            color: #4f46e5;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 9pt;
            color: #666;
        }
        .section-title {
            background-color: #1e293b;
            color: #ffffff;
            padding: 5px 8px;
            font-size: 10pt;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 6px;
        }
        .section-title.danger {
            background-color: #4f46e5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        table.bordered th, table.bordered td {
            border: 1px solid #cbd5e1;
            padding: 5px;
            font-size: 9pt;
        }
        table.bordered th {
            background-color: #f1f5f9;
            text-align: left;
        }
        .row-info td {
            padding: 4px;
            font-size: 9.5pt;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer-sign {
            margin-top: 25px;
            width: 100%;
        }
        .footer-sign td {
            text-align: center;
            vertical-align: bottom;
            height: 60px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>MBI OPERASIONAL SYSTEM</h2>
        <p>LAPORAN OPERASIONAL HARIAN TOKO</p>
    </div>

    <!-- 1. INFORMASI UTAMA -->
    <div class="section-title danger">1. INFORMASI UTAMA TOKO & SHIFT</div>
    <table class="row-info">
        <tr>
            <td width="15%"><strong>Outlet</strong></td>
            <td width="35%">: {{ $report->outlet->name ?? '-' }}</td>
            <td width="15%"><strong>Shift</strong></td>
            <td width="35%">: {{ $report->shift }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ $formattedDate }}</td>
            <td><strong>Cuaca</strong></td>
            <td>: {{ $report->weather ?? 'Cerah' }}</td>
        </tr>
    </table>

    <!-- 2. SALES PERFORMANCE -->
    @php $sales = $report->sales_finance ?? []; @endphp
    <div class="section-title">2. SALES & FINANCIAL PERFORMANCE</div>
    <table class="bordered">
        <tr>
            <th>Target Sales</th>
            <td>Rp {{ number_format($sales['target_sales'] ?? 0, 0, ',', '.') }}</td>
            <th>Actual Sales</th>
            <td><strong>Rp {{ number_format($sales['actual_sales'] ?? 0, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <th>Target Transaksi</th>
            <td>{{ number_format($sales['target_transactions'] ?? 0, 0, ',', '.') }} trx</td>
            <th>Total Transaksi</th>
            <td><strong>{{ number_format($sales['total_transactions'] ?? 0, 0, ',', '.') }} trx</strong></td>
        </tr>
        <tr>
            <th>Cash Sales</th>
            <td>Rp {{ number_format($sales['cash_sales'] ?? 0, 0, ',', '.') }}</td>
            <th>QRIS / E-Wallet</th>
            <td>Rp {{ number_format($sales['qris_wallet'] ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Debit / Credit Card</th>
            <td>Rp {{ number_format($sales['debit_card'] ?? 0, 0, ',', '.') }}</td>
            <th>Online Delivery</th>
            <td>Rp {{ number_format($sales['online_delivery'] ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Cash In Drawer</th>
            <td>Rp {{ number_format($sales['cash_in_drawer'] ?? 0, 0, ',', '.') }}</td>
            <th>Status Selisih Cash</th>
            <td><strong>{{ $sales['variance_status'] ?? 'Match' }}</strong></td>
        </tr>
        @if(!empty($sales['cash_variance_note']))
        <tr>
            <td colspan="4"><strong>Keterangan Selisih:</strong> {{ $sales['cash_variance_note'] }}</td>
        </tr>
        @endif
    </table>

    <!-- 3. TOP PRODUCTS -->
    <div class="section-title">3. PRODUCT PERFORMANCE & TOP SALES</div>
    <table class="bordered">
        <thead>
            <tr>
                <th width="40">#</th>
                <th>Kategori / Nama Produk</th>
                <th width="100" class="text-center">Qty Terjual</th>
                <th width="150" class="text-right">Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report->top_products ?? [] as $idx => $prod)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $prod['product_category'] ?? '-' }}</td>
                <td class="text-center">{{ number_format($prod['qty_sold'] ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($prod['sales_amount'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">Tidak ada data produk.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- 4. STOCK & INVENTORY -->
    <div class="section-title">4. STOCK & INVENTORY MANAGEMENT</div>
    <table class="row-info">
        <tr>
            <td width="20%"><strong>Status Stock Out</strong></td>
            <td>: {{ $report->is_stock_out ? 'Ada Item Habis (Stock Out)' : 'Aman (Tidak ada stock out)' }}</td>
        </tr>
        <tr>
            <td><strong>Item Low/Habis</strong></td>
            <td>: {{ $report->low_stock_items ?? '-' }}</td>
        </tr>
    </table>

    <!-- 5. STAFF ATTENDANCE -->
    <div class="section-title">5. STAFF ATTENDANCE & KEHADIRAN CREW</div>
    <table class="bordered">
        <thead>
            <tr>
                <th width="30">#</th>
                <th>Nama Karyawan / Crew</th>
                <th>Jabatan</th>
                <th width="100" class="text-center">Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report->attendances ?? [] as $idx => $att)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $att['staff_name'] ?? '-' }}</td>
                <td>{{ $att['schedule'] ?? 'Crew' }}</td>
                <td class="text-center">{{ $att['attendance_status'] ?? 'Hadir' }}</td>
                <td>{{ $att['remarks'] ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Tidak ada data absensi.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- 6. KEBERSIHAN & STANDAR TOKO -->
    @php $hyg = $report->hygiene ?? []; @endphp
    <div class="section-title">6. KONDISI KEBERSIHAN & STANDAR TOKO</div>
    <table class="bordered">
        <tr>
            <th width="25%">Bar & Counter</th>
            <td width="25%">{{ $hyg['bar'] ?? 'Bersih & Rapih' }}</td>
            <th width="25%">Dine In & Meja</th>
            <td width="25%">{{ $hyg['dine_in'] ?? 'Bersih & Rapih' }}</td>
        </tr>
        <tr>
            <th>Dapur & Gudang</th>
            <td>{{ $hyg['kitchen'] ?? 'Bersih & Rapih' }}</td>
            <th>Toilet & Fasilitas</th>
            <td>{{ $hyg['toilet'] ?? 'Bersih & Rapih' }}</td>
        </tr>
    </table>

    <!-- 7. PEMELIHARAAN MESIN & ALAT -->
    @php $eq = $report->equipment ?? []; @endphp
    <div class="section-title">7. PEMELIHARAAN MESIN & PERALATAN TOKO</div>
    <table class="bordered">
        <tr>
            <th width="25%">Mesin Ice Cream</th>
            <td width="25%">{{ $eq['ice_cream_machine'] ?? 'Normal' }}</td>
            <th width="25%">Chiller & Freezer</th>
            <td width="25%">{{ $eq['chiller_freezer'] ?? 'Normal' }}</td>
        </tr>
        <tr>
            <th>POS Kasir & Printer</th>
            <td>{{ $eq['pos_printer'] ?? 'Normal' }}</td>
            <th>Catatan Kerusakan</th>
            <td>{{ $eq['maintenance_note'] ?? '-' }}</td>
        </tr>
    </table>

    <!-- 8. MARKETING & PROMOSI -->
    @php $mkt = $report->marketing ?? []; @endphp
    <div class="section-title">8. PROMOSI & MARKETING TOKO</div>
    <table class="row-info">
        <tr>
            <td width="20%"><strong>Promosi Aktif</strong></td>
            <td>: {{ $mkt['active_promo'] ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Respon Pelanggan</strong></td>
            <td>: {{ $mkt['customer_feedback'] ?? '-' }}</td>
        </tr>
    </table>

    <!-- 9. ACTION PLAN -->
    <div class="section-title">9. DAILY ISSUE & ACTION PLAN</div>
    <table class="bordered">
        <thead>
            <tr>
                <th width="30">#</th>
                <th>Masalah (Issue)</th>
                <th>Akar Masalah</th>
                <th>Tindakan Perbaikan</th>
                <th width="80">PIC</th>
                <th width="80">Deadline</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report->action_plans ?? [] as $idx => $act)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $act['issue'] ?? '-' }}</td>
                <td>{{ $act['root_cause'] ?? '-' }}</td>
                <td>{{ $act['corrective_action'] ?? '-' }}</td>
                <td>{{ $act['pic'] ?? '-' }}</td>
                <td>{{ !empty($act['deadline']) ? \Carbon\Carbon::parse($act['deadline'])->format('d/m/Y') : '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Tidak ada catatan masalah/isu operasional.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- 10. EVALUASI TARGET -->
    <div class="section-title">10. RINGKASAN HARIAN & EVALUASI TARGET</div>
    <table class="row-info">
        <tr>
            <td width="25%"><strong>Performance Rating</strong></td>
            <td>: <strong>{{ $report->performance_rating }}</strong></td>
        </tr>
        <tr>
            <td><strong>Pencapaian Utama</strong></td>
            <td>: {{ $report->key_achievement ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kendala Utama</strong></td>
            <td>: {{ $report->main_problem ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Action Besok</strong></td>
            <td>: {{ $report->action_for_tomorrow ?? '-' }}</td>
        </tr>
    </table>

    <!-- 11. OTORISASI -->
    <div class="section-title">11. OTORISASI & PENANGGUNG JAWAB</div>
    <table class="footer-sign">
        <tr>
            <td width="33%">
                Dibuat Oleh,<br><br><br><br>
                <strong>({{ $report->prepared_by }})</strong><br>
                <small>Staff / Operator</small>
            </td>
            <td width="33%">
                Diperiksa Oleh,<br><br><br><br>
                <strong>({{ $report->supervisor_name ?? '........................' }})</strong><br>
                <small>Supervisor / Leader</small>
            </td>
            <td width="33%">
                Disetujui Oleh,<br><br><br><br>
                <strong>({{ $report->store_manager_name ?? '........................' }})</strong><br>
                <small>Store Manager</small>
            </td>
        </tr>
    </table>

</body>
</html>