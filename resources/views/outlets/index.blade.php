@extends('layouts.app')

@section('title', 'Manajemen Data Outlet')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-danger mb-0">Manajemen Data Outlet</h3>
        <small class="text-muted">Kelola data outlet, target operasional, dan daftar crew</small>
    </div>
    <a href="{{ route('outlets.create') }}" class="btn btn-danger">+ Tambah Outlet Baru</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Outlet</th>
                        <th>Target Sales / Hari</th>
                        <th>Target Transaksi</th>
                        <th>Jumlah Crew</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($outlets as $index => $outlet)
                        <tr>
                            <td>{{ $index + 1 + ($outlets->currentPage() - 1) * $outlets->perPage() }}</td>
                            <td class="fw-bold">{{ $outlet->name }}</td>
                            <td class="text-success fw-bold">Rp {{ number_format($outlet->target_sales, 0, ',', '.') }}</td>
                            <td>{{ number_format($outlet->target_transactions) }} Transaksi</td>
                            <td><span class="badge bg-info text-dark">{{ $outlet->employees_count }} Orang</span></td>
                            <td class="text-center">
                                <a href="{{ route('outlets.edit', $outlet->id) }}" class="btn btn-sm btn-outline-warning">Edit & Crew</a>
                                <form action="{{ route('outlets.destroy', $outlet->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus outlet ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data outlet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-3">
    {{ $outlets->links() }}
</div>
@endsection