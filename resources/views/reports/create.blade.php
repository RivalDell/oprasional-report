@extends('layouts.app')

@section('title', 'Buat Laporan Operasional - Momoyo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-danger mb-0">Input Laporan Operasional Harian</h3>
        <small class="text-muted">Isi 11 poin laporan operasional outlet secara lengkap</small>
    </div>
    <a href="{{ route('reports.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <strong>Terjadi Kesalahan!</strong> Mohon periksa kembali inputan Anda.
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('reports.store') }}" method="POST">
    @csrf

    <!-- POIN 1: INFORMASI UTAMA TOKO & SHIFT -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-danger text-white fw-bold">1. Informasi Utama Toko & Shift</div>
        <div class="card-body row g-3">
            <div class="col-md-3">
                <label for="outlet_id" class="form-label fw-bold">Outlet <span class="text-danger">*</span></label>
                <select name="outlet_id" id="outlet_id" class="form-select @error('outlet_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Outlet --</option>
                    @foreach($outlets as $outlet)
                        <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                            {{ $outlet->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="report_date" class="form-label fw-bold">Tanggal Laporan <span class="text-danger">*</span></label>
                <input type="date" name="report_date" id="report_date" class="form-control" value="{{ old('report_date', date('Y-m-d')) }}" required>
            </div>

            <div class="col-md-3">
                <label for="shift" class="form-label fw-bold">Shift <span class="text-danger">*</span></label>
                <select name="shift" id="shift" class="form-select" required>
                    <option value="Opening" {{ old('shift') == 'Opening' ? 'selected' : '' }}>Opening</option>
                    <option value="Middle" {{ old('shift') == 'Middle' ? 'selected' : '' }}>Middle</option>
                    <option value="Closing" {{ old('shift') == 'Closing' ? 'selected' : '' }}>Closing</option>
                    <option value="Full Day" {{ old('shift') == 'Full Day' ? 'selected' : '' }}>Full Day</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="weather" class="form-label fw-bold">Kondisi Cuaca</label>
                <select name="weather" id="weather" class="form-select">
                    <option value="Cerah" {{ old('weather') == 'Cerah' ? 'selected' : '' }}>Cerah</option>
                    <option value="Hujan" {{ old('weather') == 'Hujan' ? 'selected' : '' }}>Hujan</option>
                    <option value="Mendung" {{ old('weather') == 'Mendung' ? 'selected' : '' }}>Mendung</option>
                </select>
            </div>
        </div>
    </div>

    <!-- POIN 2: SALES & FINANCIAL PERFORMANCE -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">2. Sales & Financial Performance</div>
        <div class="card-body row g-3">
            <div class="col-md-3">
                <label for="target_sales" class="form-label fw-bold">Target Sales (Rp)</label>
                <input type="number" name="sales_finance[target_sales]" id="target_sales" class="form-control bg-light" value="{{ old('sales_finance.target_sales') }}" placeholder="Otomatis dari Outlet" readonly>
                <small class="text-muted small">Otomatis menyesuaikan Weekday/Weekend</small>
            </div>

            <div class="col-md-3">
                <label for="actual_sales" class="form-label fw-bold">Actual Sales (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="sales_finance[actual_sales]" id="actual_sales" class="form-control" value="{{ old('sales_finance.actual_sales', 0) }}" required>
            </div>

            <div class="col-md-3">
                <label for="target_transactions" class="form-label fw-bold">Target Transaksi</label>
                <input type="number" name="sales_finance[target_transactions]" id="target_transactions" class="form-control bg-light" value="{{ old('sales_finance.target_transactions') }}" placeholder="Otomatis dari Outlet" readonly>
            </div>

            <div class="col-md-3">
                <label for="total_transactions" class="form-label fw-bold">Jumlah Transaksi <span class="text-danger">*</span></label>
                <input type="number" name="sales_finance[total_transactions]" id="total_transactions" class="form-control" value="{{ old('sales_finance.total_transactions', 0) }}" required>
            </div>

            <div class="col-md-3">
                <label for="cash_sales" class="form-label">Cash Sales (Rp)</label>
                <input type="number" name="sales_finance[cash_sales]" id="cash_sales" class="form-control" value="{{ old('sales_finance.cash_sales', 0) }}">
            </div>

            <div class="col-md-3">
                <label for="qris_wallet" class="form-label">QRIS / E-Wallet (Rp)</label>
                <input type="number" name="sales_finance[qris_wallet]" id="qris_wallet" class="form-control" value="{{ old('sales_finance.qris_wallet', 0) }}">
            </div>

            <div class="col-md-3">
                <label for="debit_card" class="form-label">Debit/Credit Card (Rp)</label>
                <input type="number" name="sales_finance[debit_card]" id="debit_card" class="form-control" value="{{ old('sales_finance.debit_card', 0) }}">
            </div>

            <div class="col-md-3">
                <label for="online_delivery" class="form-label">Online Delivery (Rp)</label>
                <input type="number" name="sales_finance[online_delivery]" id="online_delivery" class="form-control" value="{{ old('sales_finance.online_delivery', 0) }}">
            </div>

            <div class="col-md-3">
                <label for="cash_in_drawer" class="form-label">Cash In Drawer (Rp)</label>
                <input type="number" name="sales_finance[cash_in_drawer]" id="cash_in_drawer" class="form-control" value="{{ old('sales_finance.cash_in_drawer', 0) }}">
            </div>

            <div class="col-md-3">
                <label for="variance_status" class="form-label">Status Variansi Cash</label>
                <select name="sales_finance[variance_status]" id="variance_status" class="form-select">
                    <option value="Match" {{ old('sales_finance.variance_status') == 'Match' ? 'selected' : '' }}>Match (Sesuai)</option>
                    <option value="Over" {{ old('sales_finance.variance_status') == 'Over' ? 'selected' : '' }}>Over (Lebih)</option>
                    <option value="Short" {{ old('sales_finance.variance_status') == 'Short' ? 'selected' : '' }}>Short (Kurang)</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="cash_variance_note" class="form-label">Penjelasan Selisih Cash</label>
                <input type="text" name="sales_finance[cash_variance_note]" id="cash_variance_note" class="form-control" value="{{ old('sales_finance.cash_variance_note') }}" placeholder="Sebab jika over/short">
            </div>
        </div>
    </div>

    <!-- POIN 3: PRODUCT PERFORMANCE & TOP SALES -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
            <span>3. Product Performance & Top Sales</span>
            <button type="button" class="btn btn-sm btn-light" id="add-product-btn">+ Tambah Produk</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" id="top-products-table">
                    <thead class="table-light">
                        <tr>
                            <th>Kategori / Nama Produk</th>
                            <th width="150">Qty Terjual</th>
                            <th width="220">Total Sales (Rp)</th>
                            <th width="80" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="top_products[0][product_category]" class="form-control" placeholder="Contoh: Milk Tea / Sundae" required></td>
                            <td><input type="number" name="top_products[0][qty_sold]" class="form-control" placeholder="0" required></td>
                            <td><input type="number" name="top_products[0][sales_amount]" class="form-control" placeholder="0" required></td>
                            <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- POIN 4: STOCK & INVENTORY MANAGEMENT -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">4. Stock & Inventory Management</div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Status Stock Out</label>
                <select name="is_stock_out" class="form-select">
                    <option value="0" {{ old('is_stock_out') == '0' ? 'selected' : '' }}>Aman (Tidak Ada Stock Out)</option>
                    <option value="1" {{ old('is_stock_out') == '1' ? 'selected' : '' }}>Ada Stock Out (Item Habis)</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-bold">Daftar Item Low Stock / Habis</label>
                <input type="text" name="low_stock_items" class="form-control" value="{{ old('low_stock_items') }}" placeholder="Contoh: Cone, Boba, Sugar Syrup">
            </div>
        </div>
    </div>

    <!-- POIN 5: STAFF ATTENDANCE & KEHADIRAN CREW -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">5. Staff Attendance & Kehadiran Crew</div>
        <div class="card-body">
            <div id="employee-attendance-container">
                <p class="text-muted mb-0">Silakan pilih outlet terlebih dahulu untuk memuat daftar crew/karyawan secara otomatis.</p>
            </div>
        </div>
    </div>

    <!-- POIN 6: KONDISI KEBERSIHAN & STANDAR TOKO -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">6. Kondisi Kebersihan & Standar Toko</div>
        <div class="card-body row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">Area Bar & Counter</label>
                <select name="hygiene[bar]" class="form-select">
                    <option value="Bersih & Rapih">Bersih & Rapih</option>
                    <option value="Perlu Perhatian">Perlu Perhatian</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Area Dine In & Meja</label>
                <select name="hygiene[dine_in]" class="form-select">
                    <option value="Bersih & Rapih">Bersih & Rapih</option>
                    <option value="Perlu Perhatian">Perlu Perhatian</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Area Dapur / Gudang</label>
                <select name="hygiene[kitchen]" class="form-select">
                    <option value="Bersih & Rapih">Bersih & Rapih</option>
                    <option value="Perlu Perhatian">Perlu Perhatian</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Area Toilet & Fasilitas</label>
                <select name="hygiene[toilet]" class="form-select">
                    <option value="Bersih & Rapih">Bersih & Rapih</option>
                    <option value="Perlu Perhatian">Perlu Perhatian</option>
                </select>
            </div>
        </div>
    </div>

    <!-- POIN 7: PEMELIHARAAN MESIN & PERALATAN -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">7. Pemeliharaan Mesin & Peralatan Toko</div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Status Mesin Ice Cream</label>
                <select name="equipment[ice_cream_machine]" class="form-select">
                    <option value="Normal">Normal / Optimal</option>
                    <option value="Trouble">Bermasalah / Perlu Service</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Status Chiller & Freezer</label>
                <select name="equipment[chiller_freezer]" class="form-select">
                    <option value="Normal">Normal / Sesuai Suhu</option>
                    <option value="Trouble">Bermasalah / Panas</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Status POS & Printer</label>
                <select name="equipment[pos_printer]" class="form-select">
                    <option value="Normal">Normal / Lancar</option>
                    <option value="Trouble">Bermasalah / Eror</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Catatan Kerusakan Peralatan (Jika Ada)</label>
                <input type="text" name="equipment[maintenance_note]" class="form-control" value="{{ old('equipment.maintenance_note') }}" placeholder="Jelaskan jenis kendala mesin/peralatan">
            </div>
        </div>
    </div>

    <!-- POIN 8: PROMOSI & MARKETING TOKO -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">8. Promosi & Marketing Toko</div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Promosi Aktif Hari Ini</label>
                <input type="text" name="marketing[active_promo]" class="form-control" value="{{ old('marketing.active_promo') }}" placeholder="Contoh: Promo Grand Opening 50%">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Respon Pelanggan & Masukan (Feedback)</label>
                <input type="text" name="marketing[customer_feedback]" class="form-control" value="{{ old('marketing.customer_feedback') }}" placeholder="Contoh: Pelanggan menyukai rasa baru">
            </div>
        </div>
    </div>

    <!-- POIN 9: KENDALA OPERASIONAL & ACTION PLAN -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
            <span>9. Daily Issue & Action Plan</span>
            <button type="button" class="btn btn-sm btn-light" id="add-action-btn">+ Tambah Masalah/Isu</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" id="action-plans-table">
                    <thead class="table-light">
                        <tr>
                            <th>Masalah (Issue)</th>
                            <th>Akar Masalah (Root Cause)</th>
                            <th>Tindakan Perbaikan</th>
                            <th width="150">PIC</th>
                            <th width="150">Deadline</th>
                            <th width="60" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="action_plans[0][issue]" class="form-control" placeholder="Isu operasional"></td>
                            <td><input type="text" name="action_plans[0][root_cause]" class="form-control" placeholder="Penyebab utama"></td>
                            <td><input type="text" name="action_plans[0][corrective_action]" class="form-control" placeholder="Solusi"></td>
                            <td><input type="text" name="action_plans[0][pic]" class="form-control" placeholder="PIC"></td>
                            <td><input type="date" name="action_plans[0][deadline]" class="form-control"></td>
                            <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- POIN 10: RINGKASAN HARIAN & EVALUASI TARGET -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">10. Ringkasan Harian & Evaluasi Target</div>
        <div class="card-body row g-3">
            <div class="col-md-3">
                <label for="performance_rating" class="form-label fw-bold">Performance Rating <span class="text-danger">*</span></label>
                <select name="performance_rating" id="performance_rating" class="form-select" required>
                    <option value="Excellent" {{ old('performance_rating') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                    <option value="Good" {{ old('performance_rating', 'Good') == 'Good' ? 'selected' : '' }}>Good</option>
                    <option value="Average" {{ old('performance_rating') == 'Average' ? 'selected' : '' }}>Average</option>
                    <option value="Below Target" {{ old('performance_rating') == 'Below Target' ? 'selected' : '' }}>Below Target</option>
                </select>
            </div>
            <div class="col-md-9">
                <label for="key_achievement" class="form-label fw-bold">Pencapaian Utama (Key Achievement)</label>
                <input type="text" name="key_achievement" id="key_achievement" class="form-control" value="{{ old('key_achievement') }}" placeholder="Pencapaian terbaik shift ini">
            </div>
            <div class="col-md-6">
                <label for="main_problem" class="form-label fw-bold">Kendala Utama (Main Problem)</label>
                <textarea name="main_problem" id="main_problem" class="form-control" rows="2" placeholder="Kendala terbesar hari ini">{{ old('main_problem') }}</textarea>
            </div>
            <div class="col-md-6">
                <label for="action_for_tomorrow" class="form-label fw-bold">Rencana Tindakan Besok (Action for Tomorrow)</label>
                <textarea name="action_for_tomorrow" id="action_for_tomorrow" class="form-control" rows="2" placeholder="Rencana fokus besok">{{ old('action_for_tomorrow') }}</textarea>
            </div>
        </div>
    </div>

    <!-- POIN 11: OTORISASI & PENANGGUNG JAWAB -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">11. Otorisasi & Penanggung Jawab</div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <label for="prepared_by" class="form-label fw-bold">Dibuat Oleh <span class="text-danger">*</span></label>
                <input type="text" name="prepared_by" id="prepared_by" class="form-control" value="{{ old('prepared_by', auth()->user()->name ?? '') }}" required>
            </div>
            <div class="col-md-4">
                <label for="supervisor_name" class="form-label fw-bold">Nama Supervisor</label>
                <input type="text" name="supervisor_name" id="supervisor_name" class="form-control" value="{{ old('supervisor_name') }}" placeholder="Opsional">
            </div>
            <div class="col-md-4">
                <label for="store_manager_name" class="form-label fw-bold">Nama Store Manager</label>
                <input type="text" name="store_manager_name" id="store_manager_name" class="form-control" value="{{ old('store_manager_name') }}" placeholder="Opsional">
            </div>
        </div>
    </div>

    <!-- SUBMIT BUTTON -->
    <div class="text-end mb-5">
        <button type="submit" class="btn btn-danger btn-lg px-5 fw-bold">Simpan Laporan Operasional</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const outletSelect = document.getElementById('outlet_id');
    const reportDateInput = document.getElementById('report_date');
    const targetSalesInput = document.getElementById('target_sales');
    const targetTransactionsInput = document.getElementById('target_transactions');
    const employeeContainer = document.getElementById('employee-attendance-container');

    function loadOutletData() {
        const outletId = outletSelect ? outletSelect.value : '';
        const reportDate = reportDateInput ? reportDateInput.value : '';

        if (!outletId) {
            if (targetSalesInput) targetSalesInput.value = '';
            if (targetTransactionsInput) targetTransactionsInput.value = '';
            if (employeeContainer) {
                employeeContainer.innerHTML = '<p class="text-muted mb-0">Silakan pilih outlet terlebih dahulu untuk memuat daftar crew/karyawan secara otomatis.</p>';
            }
            return;
        }

        if (employeeContainer) {
            employeeContainer.innerHTML = '<div class="text-center py-3"><div class="spinner-border text-danger spinner-border-sm" role="status"></div> <span class="ms-2">Memuat target & data crew...</span></div>';
        }

        fetch('/api/outlets/' + outletId + '?date=' + reportDate)
            .then(function(response) {
                if (!response.ok) throw new Error('Gagal memuat data outlet');
                return response.json();
            })
            .then(function(data) {
                if (targetSalesInput) {
                    targetSalesInput.value = data.active_target_sales !== undefined ? data.active_target_sales : (data.target_sales || 0);
                }
                if (targetTransactionsInput) {
                    targetTransactionsInput.value = data.active_target_transactions !== undefined ? data.active_target_transactions : (data.target_transactions || 0);
                }

                if (data.employees && data.employees.length > 0) {
                    let html = '<div class="table-responsive"><table class="table table-bordered align-middle mb-0">' +
                        '<thead class="table-light"><tr><th width="50">#</th><th>Nama Karyawan / Crew</th><th>Jabatan</th><th width="200">Status Kehadiran</th><th>Keterangan / Catatan</th></tr></thead><tbody>';
                    
                    data.employees.forEach(function(emp, index) {
                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><strong>' + emp.name + '</strong><input type="hidden" name="attendances[' + index + '][staff_name]" value="' + emp.name + '"></td>' +
                            '<td><span class="badge bg-secondary">' + (emp.position || 'Crew') + '</span><input type="hidden" name="attendances[' + index + '][schedule]" value="' + (emp.position || 'Crew') + '"></td>' +
                            '<td><select name="attendances[' + index + '][attendance_status]" class="form-select form-select-sm">' +
                                '<option value="Hadir">Hadir</option>' +
                                '<option value="Izin">Izin</option>' +
                                '<option value="Sakit">Sakit</option>' +
                                '<option value="Alpha">Alpha</option>' +
                                '<option value="Off">Off / Libur</option>' +
                            '</select></td>' +
                            '<td><input type="text" name="attendances[' + index + '][remarks]" class="form-control form-control-sm" placeholder="Catatan opsional"></td>' +
                        '</tr>';
                    });

                    html += '</tbody></table></div>';
                    employeeContainer.innerHTML = html;
                } else {
                    employeeContainer.innerHTML = '<p class="text-warning mb-0">Belum ada karyawan terdaftar untuk outlet ini. Tambahkan data karyawan di menu Edit Outlet.</p>';
                }
            })
            .catch(function(err) {
                if (employeeContainer) {
                    employeeContainer.innerHTML = '<p class="text-danger mb-0">Gagal mengambil data karyawan/target outlet.</p>';
                }
            });
    }

    if (outletSelect) outletSelect.addEventListener('change', loadOutletData);
    if (reportDateInput) reportDateInput.addEventListener('change', loadOutletData);

    // Dynamic Row - Top Products
    let productIndex = 1;
    const addProductBtn = document.getElementById('add-product-btn');
    if (addProductBtn) {
        addProductBtn.addEventListener('click', function () {
            const tableBody = document.getElementById('top-products-table').getElementsByTagName('tbody')[0];
            const newRow = tableBody.insertRow();
            newRow.innerHTML = '<td><input type="text" name="top_products[' + productIndex + '][product_category]" class="form-control" placeholder="Contoh: Milk Tea / Sundae" required></td>' +
                '<td><input type="number" name="top_products[' + productIndex + '][qty_sold]" class="form-control" placeholder="0" required></td>' +
                '<td><input type="number" name="top_products[' + productIndex + '][sales_amount]" class="form-control" placeholder="0" required></td>' +
                '<td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>';
            productIndex++;
        });
    }

    // Dynamic Row - Action Plans
    let actionIndex = 1;
    const addActionBtn = document.getElementById('add-action-btn');
    if (addActionBtn) {
        addActionBtn.addEventListener('click', function () {
            const tableBody = document.getElementById('action-plans-table').getElementsByTagName('tbody')[0];
            const newRow = tableBody.insertRow();
            newRow.innerHTML = '<td><input type="text" name="action_plans[' + actionIndex + '][issue]" class="form-control" placeholder="Isu operasional"></td>' +
                '<td><input type="text" name="action_plans[' + actionIndex + '][root_cause]" class="form-control" placeholder="Penyebab utama"></td>' +
                '<td><input type="text" name="action_plans[' + actionIndex + '][corrective_action]" class="form-control" placeholder="Solusi"></td>' +
                '<td><input type="text" name="action_plans[' + actionIndex + '][pic]" class="form-control" placeholder="PIC"></td>' +
                '<td><input type="date" name="action_plans[' + actionIndex + '][deadline]" class="form-control"></td>' +
                '<td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>';
            actionIndex++;
        });
    }

    // Remove Row Delegate
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            const row = e.target.closest('tr');
            if (row) row.remove();
        }
    });

    // Auto trigger saat halaman pertama di-load jika sudah terpilih outlet
    if (outletSelect && outletSelect.value) {
        loadOutletData();
    }
});
</script>
@endpush