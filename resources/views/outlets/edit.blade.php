@extends('layouts.app')

@section('title', 'Edit Outlet & Crew')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-danger mb-0">Edit Outlet & Crew</h3>
        <small class="text-muted">Perbarui target harian dan daftar karyawan outlet</small>
    </div>
    <a href="{{ route('outlets.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@if($errors->any())
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

<form action="{{ route('outlets.update', $outlet->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- 1. Informasi Utama & Target -->
    <div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-danger text-white fw-bold">1. Profil & Target Outlet</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label fw-bold">Kode Outlet</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $outlet->code) }}" placeholder="Contoh: MMY-TMB">
        </div>

        <div class="col-md-4">
            <label class="form-label fw-bold">Nama Outlet <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $outlet->name) }}" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Alamat</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $outlet->address) }}">
        </div>

        <!-- TARGET WEEKDAY -->
        <div class="col-md-3">
            <label class="form-label fw-bold">Target Sales (Senin - Jumat) <span class="text-danger">*</span></label>
            <input type="number" name="target_sales" class="form-control" value="{{ old('target_sales', $outlet->target_sales) }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">Target Transaksi (Senin - Jumat) <span class="text-danger">*</span></label>
            <input type="number" name="target_transactions" class="form-control" value="{{ old('target_transactions', $outlet->target_transactions) }}" required>
        </div>

        <!-- TARGET WEEKEND -->
        <div class="col-md-3">
            <label class="form-label fw-bold text-danger">Target Sales (Sabtu - Minggu)</label>
            <input type="number" name="target_sales_weekend" class="form-control border-danger" value="{{ old('target_sales_weekend', $outlet->target_sales_weekend ?? $outlet->target_sales) }}" placeholder="Lebih tinggi dari hari biasa">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold text-danger">Target Transaksi (Sabtu - Minggu)</label>
            <input type="number" name="target_transactions_weekend" class="form-control border-danger" value="{{ old('target_transactions_weekend', $outlet->target_transactions_weekend ?? $outlet->target_transactions) }}" placeholder="Lebih tinggi dari hari biasa">
        </div>
    </div>
</div>

    <!-- 2. Data Karyawan / Crew -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
            <span>2. Daftar Karyawan / Crew Outlet</span>
            <button type="button" class="btn btn-sm btn-light" id="add-employee-btn">+ Tambah Baris Crew</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="employees-table">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Jabatan / Posisi</th>
                            <th width="80" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($outlet->employees) > 0)
                            @foreach($outlet->employees as $index => $emp)
                                <tr>
                                    <td><input type="text" name="employees[{{ $index }}][name]" class="form-control" value="{{ $emp->name }}" required></td>
                                    <td>
                                        <select name="employees[{{ $index }}][position]" class="form-select">
                                            <option value="Crew" {{ $emp->position == 'Crew' ? 'selected' : '' }}>Crew</option>
                                            <option value="Kasir" {{ $emp->position == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                                            <option value="Leader" {{ $emp->position == 'Leader' ? 'selected' : '' }}>Leader</option>
                                            <option value="Store Manager" {{ $emp->position == 'Store Manager' ? 'selected' : '' }}>Store Manager</option>
                                        </select>
                                    </td>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td><input type="text" name="employees[0][name]" class="form-control" placeholder="Nama Karyawan"></td>
                                <td>
                                    <select name="employees[0][position]" class="form-select">
                                        <option value="Crew">Crew</option>
                                        <option value="Kasir">Kasir</option>
                                        <option value="Leader">Leader</option>
                                        <option value="Store Manager">Store Manager</option>
                                    </select>
                                </td>
                                <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-end mb-5">
        <button type="submit" class="btn btn-warning text-white fw-bold btn-lg px-5">Perbarui Outlet</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let empIndex = {{ count($outlet->employees) > 0 ? count($outlet->employees) : 1 }};
    const addBtn = document.getElementById('add-employee-btn');

    if (addBtn) {
        addBtn.addEventListener('click', function() {
            let table = document.getElementById('employees-table').getElementsByTagName('tbody')[0];
            let newRow = table.insertRow();
            newRow.innerHTML = '<td><input type="text" name="employees[' + empIndex + '][name]" class="form-control" placeholder="Nama Karyawan" required></td>' +
                '<td>' +
                    '<select name="employees[' + empIndex + '][position]" class="form-select">' +
                        '<option value="Crew">Crew</option>' +
                        '<option value="Kasir">Kasir</option>' +
                        '<option value="Leader">Leader</option>' +
                        '<option value="Store Manager">Store Manager</option>' +
                    '</select>' +
                '</td>' +
                '<td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>';
            empIndex++;
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            const row = e.target.closest('tr');
            if (row) row.remove();
        }
    });
});
</script>
@endpush