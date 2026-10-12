@extends('layouts.app')

@section('title', 'Edit User Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-danger mb-0">Edit User Pengguna</h3>
        <small class="text-muted">Perbarui data profil, role, atau ubah password</small>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
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

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Password Baru (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Role Akses <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff / Operator Outlet</option>
                        <option value="atasan" {{ old('role', $user->role) == 'atasan' ? 'selected' : '' }}>Atasan / Management (Read-Only & Export)</option>
                        <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin (Akses Penuh CRUD)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Penugasan Outlet (Opsional)</label>
                    <select name="outlet_id" class="form-select">
                        <option value="">-- Semua Outlet / Kantor Pusat --</option>
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}" {{ old('outlet_id', $user->outlet_id) == $outlet->id ? 'selected' : '' }}>
                                {{ $outlet->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-warning text-white fw-bold px-4">Perbarui User</button>
            </div>
        </form>
    </div>
</div>
@endsection