@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-danger mb-0">Manajemen User Pengguna</h3>
        <small class="text-muted">Kelola akun, hak akses role, dan penugasan outlet</small>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-danger">+ Tambah User Baru</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
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
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Role Akses</th>
                        <th>Outlet Penugasan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                        <tr>
                            <td>{{ $index + 1 + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td class="fw-bold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->role === 'superadmin')
                                    <span class="badge bg-danger">Superadmin</span>
                                @elseif($u->role === 'atasan')
                                    <span class="badge bg-primary">Atasan / Management</span>
                                @else
                                    <span class="badge bg-secondary">Staff Operasional</span>
                                @endif
                            </td>
                            <td>
                                @if($u->outlet)
                                    <span class="badge bg-info text-dark">{{ $u->outlet->name }}</span>
                                @else
                                    <span class="text-muted small">Semua Outlet / Pusat</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                
                                @if(auth()->id() !== $u->id)
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data user pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-3">
    {{ $users->links() }}
</div>
@endsection