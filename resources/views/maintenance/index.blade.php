@extends('layouts.app')
@section('title', 'Log Maintenance')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Maintenance</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-tools me-2"></i>Log Maintenance</h5>
    <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tambah Log
    </a>
</div>

{{-- Filter --}}
<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <select name="device_id" class="form-select form-select-sm">
                    <option value="">Semua Perangkat</option>
                    @foreach($devices as $dev)
                        <option value="{{ $dev->id }}" @selected(request('device_id')==$dev->id)>
                            [{{ $dev->asset_code }}] {{ $dev->brand }} {{ $dev->model }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="type" class="form-select form-select-sm">
                    <option value="">Semua Tipe</option>
                    <option value="preventive" @selected(request('type')=='preventive')>Preventive</option>
                    <option value="corrective" @selected(request('type')=='corrective')>Corrective</option>
                    <option value="upgrade" @selected(request('type')=='upgrade')>Upgrade</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
            </div>
            @if(request()->hasAny(['device_id','type']))
                <div class="col-auto"><a href="{{ route('maintenance.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a></div>
            @endif
        </form>
    </div>
</div>

<div class="card table-card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>Perangkat</th><th>Tgl Maintenance</th><th>Tipe</th><th>Deskripsi</th>
                <th>Sparepart</th><th>Teknisi</th><th>Biaya</th><th>Next Maint.</th>
            </tr></thead>
            <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>
                        <a href="{{ route('maintenance.byDevice', $log->device) }}" class="text-decoration-none fw-medium">
                            {{ $log->device->asset_code }}
                        </a>
                        <small class="d-block text-muted">{{ $log->device->brand }} {{ $log->device->model }}</small>
                    </td>
                    <td>{{ $log->maintenance_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge
                            {{ $log->maintenance_type == 'preventive' ? 'bg-info text-dark' : ($log->maintenance_type == 'corrective' ? 'bg-warning text-dark' : 'bg-success') }}">
                            {{ ucfirst($log->maintenance_type) }}
                        </span>
                    </td>
                    <td><small>{{ Str::limit($log->description, 50) }}</small></td>
                    <td><small>{{ $log->sparepart?->part_name ?? '-' }}</small></td>
                    <td><small>{{ $log->technician }}</small></td>
                    <td><small>{{ $log->cost > 0 ? 'Rp ' . number_format($log->cost, 0, ',', '.') : '-' }}</small></td>
                    <td>
                        @if($log->next_maintenance)
                            <span class="badge {{ $log->next_maintenance->isPast() ? 'bg-danger' : 'bg-secondary' }}">
                                {{ $log->next_maintenance->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada log maintenance.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
        <div class="card-footer bg-transparent">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
