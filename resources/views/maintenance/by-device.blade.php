@extends('layouts.app')
@section('title', 'Maintenance — ' . $device->asset_code)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('maintenance.index') }}">Maintenance</a></li>
    <li class="breadcrumb-item active">{{ $device->asset_code }}</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h5 class="fw-bold mb-0"><i class="bi bi-tools me-2"></i>Maintenance History</h5>
        <span class="text-muted">
            {{ $device->brand }} {{ $device->model }} —
            <span class="badge bg-secondary">{{ $device->asset_code }}</span>
        </span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('devices.show', $device) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pc-display me-1"></i>Device Detail
        </a>
        <a href="{{ route('maintenance.create', ['device_id' => $device->id]) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Log
        </a>
    </div>
</div>

<div class="card table-card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>Date</th><th>Type</th><th>Description</th>
                <th>Sparepart Used</th><th>Technician</th><th>Cost</th><th>Next Maintenance</th>
            </tr></thead>
            <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->maintenance_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $log->maintenance_type=='preventive' ? 'bg-info text-dark' : ($log->maintenance_type=='corrective' ? 'bg-warning text-dark' : 'bg-success') }}">
                            {{ ucfirst($log->maintenance_type) }}
                        </span>
                    </td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->sparepart?->part_name ?? '-' }}</td>
                    <td>{{ $log->technician }}</td>
                    <td>{{ $log->cost > 0 ? 'Rp ' . number_format($log->cost, 0, ',', '.') : '-' }}</td>
                    <td>
                        @if($log->next_maintenance)
                            <span class="badge {{ $log->next_maintenance->isPast() ? 'bg-danger' : ($log->next_maintenance->diffInDays(now()) <= 7 ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                {{ $log->next_maintenance->format('d/m/Y') }}
                            </span>
                        @else - @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No maintenance history for this device.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
        <div class="card-footer bg-transparent">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
