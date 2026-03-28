@extends('layouts.app')
@section('title', 'Device Detail — ' . $device->asset_code)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Devices</a></li>
    <li class="breadcrumb-item active">{{ $device->asset_code }}</li>
@endsection

@section('content')
<div class="d-flex align-items-start justify-content-between mb-3">
    <div>
        <h5 class="fw-bold mb-1">
            <span class="badge bg-secondary me-2">{{ $device->asset_code }}</span>
            {{ $device->brand }} {{ $device->model }}
        </h5>
        <span class="badge badge-{{ $device->status }}">{{ ucfirst(str_replace('_',' ',$device->status)) }}</span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('maintenance.create', ['device_id' => $device->id]) }}" class="btn btn-outline-warning btn-sm">
            <i class="bi bi-tools me-1"></i>Add Maintenance Log
        </a>
        <a href="{{ route('devices.edit', $device) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header">Device Information</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th class="text-muted fw-normal" width="40%">Type</th><td>{{ ucfirst($device->device_type) }}</td></tr>
                    <tr><th class="text-muted fw-normal">Serial No.</th><td>{{ $device->serial_number }}</td></tr>
                    <tr><th class="text-muted fw-normal">Processor</th><td>{{ $device->processor ?? '-' }}</td></tr>
                    <tr><th class="text-muted fw-normal">RAM</th><td>{{ $device->ram_size ? $device->ram_size . ' GB' : '-' }}</td></tr>
                    <tr><th class="text-muted fw-normal">Storage</th><td>{{ $device->storage_size ? $device->storage_size . ' GB ' . strtoupper($device->storage_type ?? '') : '-' }}</td></tr>
                    <tr><th class="text-muted fw-normal">OS</th><td>{{ $device->os ?? '-' }}</td></tr>
                    <tr><th class="text-muted fw-normal">Purchase Date</th><td>{{ $device->purchase_date?->format('d M Y') ?? '-' }}</td></tr>
                    <tr><th class="text-muted fw-normal">Warranty Until</th><td>
                        @if($device->warranty_until)
                            <span class="{{ $device->warranty_until->isPast() ? 'text-danger' : '' }}">
                                {{ $device->warranty_until->format('d M Y') }}
                            </span>
                        @else - @endif
                    </td></tr>
                    <tr><th class="text-muted fw-normal">Location</th><td>{{ $device->location ?? '-' }}</td></tr>
                    <tr><th class="text-muted fw-normal">Assigned To</th><td>{{ $device->assigned_to ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card shadow-sm mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-tools me-2"></i>Maintenance History</span>
                <a href="{{ route('maintenance.byDevice', $device) }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Date</th><th>Type</th><th>Description</th><th>Technician</th></tr></thead>
                    <tbody>
                    @forelse($device->maintenanceLogs->take(5) as $log)
                        <tr>
                            <td><small>{{ $log->maintenance_date->format('d/m/Y') }}</small></td>
                            <td><span class="badge {{ $log->maintenance_type=='preventive' ? 'bg-info text-dark' : ($log->maintenance_type=='corrective' ? 'bg-warning text-dark' : 'bg-success') }}">
                                {{ ucfirst($log->maintenance_type) }}
                            </span></td>
                            <td><small>{{ Str::limit($log->description, 40) }}</small></td>
                            <td><small>{{ $log->technician }}</small></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">No maintenance history.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
