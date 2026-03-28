@extends('layouts.app')
@section('title', 'Daftar Perangkat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Perangkat</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-pc-display me-2"></i>Daftar Perangkat</h5>
    <a href="{{ route('devices.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tambah Perangkat
    </a>
</div>

{{-- Filter --}}
<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari asset code, serial number, pengguna..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-3">
                <select name="type" class="form-select form-select-sm">
                    <option value="">Semua Tipe</option>
                    <option value="pc" @selected(request('type')=='pc')>PC</option>
                    <option value="laptop" @selected(request('type')=='laptop')>Laptop</option>
                    <option value="server" @selected(request('type')=='server')>Server</option>
                </select>
            </div>
            <div class="col-6 col-md-auto">
                <button class="btn btn-sm btn-primary w-100"><i class="bi bi-search"></i> Cari</button>
            </div>
            @if(request()->hasAny(['search','type']))
                <div class="col-auto">
                    <a href="{{ route('devices.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                </div>
            @endif
        </form>
    </div>
</div>

<div class="card table-card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>Asset Code</th><th>Tipe</th><th>Brand / Model</th>
                <th>Serial Number</th><th>Status</th><th>Lokasi</th>
                <th>Pengguna</th><th class="text-center">Aksi</th>
            </tr></thead>
            <tbody>
            @forelse($devices as $device)
                <tr>
                    <td><span class="badge bg-secondary">{{ $device->asset_code }}</span></td>
                    <td><span class="badge bg-light text-dark text-uppercase">{{ $device->device_type }}</span></td>
                    <td>
                        <span class="fw-medium">{{ $device->brand }}</span>
                        <small class="d-block text-muted">{{ $device->model }}</small>
                    </td>
                    <td><small>{{ $device->serial_number }}</small></td>
                    <td>
                        <span class="badge badge-status-{{ $device->status }}">
                            {{ ucfirst(str_replace('_',' ',$device->status)) }}
                        </span>
                    </td>
                    <td>{{ $device->location ?? '-' }}</td>
                    <td>{{ $device->assigned_to ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('devices.show', $device) }}" class="btn btn-xs btn-outline-info btn-sm" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('devices.edit', $device) }}" class="btn btn-xs btn-outline-warning btn-sm" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('devices.destroy', $device) }}" class="d-inline"
                              onsubmit="return confirm('Hapus perangkat {{ $device->asset_code }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('maintenance.byDevice', $device) }}" class="btn btn-xs btn-outline-secondary btn-sm" title="Maintenance">
                            <i class="bi bi-tools"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada perangkat ditemukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($devices->hasPages())
        <div class="card-footer bg-transparent">{{ $devices->links() }}</div>
    @endif
</div>
@endsection
