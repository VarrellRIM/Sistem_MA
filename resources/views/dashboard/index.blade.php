@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card text-white" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">
            <div class="stat-num">{{ $totalDevices }}</div>
            <div class="stat-lbl"><i class="bi bi-pc-display me-1"></i>Total Devices</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-white" style="background:linear-gradient(135deg,#10b981,#059669)">
            <div class="stat-num">{{ $activeDevices }}</div>
            <div class="stat-lbl"><i class="bi bi-check-circle me-1"></i>Active</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-white" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="stat-num">{{ $maintDevices }}</div>
            <div class="stat-lbl"><i class="bi bi-tools me-1"></i>Under Maintenance</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card text-white" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)">
            <div class="stat-num">{{ \App\Models\Sparepart::count() }}</div>
            <div class="stat-lbl"><i class="bi bi-boxes me-1"></i>Sparepart Types</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Upcoming Maintenance --}}
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <i class="bi bi-calendar-event text-warning me-2"></i>Upcoming Maintenance (Next 7 Days)
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Device</th><th>Date</th><th>Technician</th></tr></thead>
                    <tbody>
                    @forelse($upcomingMaintenance as $log)
                        <tr>
                            <td>
                                <a href="{{ route('maintenance.byDevice', $log->device) }}" class="text-decoration-none fw-medium">
                                    {{ $log->device->asset_code }}
                                </a>
                                <small class="d-block text-muted">{{ $log->device->brand }} {{ $log->device->model }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $log->next_maintenance->isToday() || $log->next_maintenance->isPast() ? 'bg-danger' : 'bg-warning text-dark' }}">
                                    {{ $log->next_maintenance->format('d M Y') }}
                                </span>
                            </td>
                            <td><small>{{ $log->technician }}</small></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">No upcoming maintenance.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Low Stock --}}
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <i class="bi bi-exclamation-triangle text-danger me-2"></i>Low Stock Alert
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Part</th><th>Category</th><th>Stock</th><th>Min</th></tr></thead>
                    <tbody>
                    @forelse($lowStockItems as $sp)
                        <tr>
                            <td>
                                <span class="fw-medium">{{ $sp->part_name }}</span>
                                <small class="d-block text-muted">{{ $sp->part_code }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark text-uppercase">{{ $sp->part_category }}</span></td>
                            <td><span class="badge bg-danger">{{ $sp->stock }}</span></td>
                            <td><small>{{ $sp->min_stock }}</small></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">All spareparts are sufficiently stocked.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($lowStockItems->isNotEmpty())
                <div class="card-footer text-end bg-transparent">
                    <a href="{{ route('spareparts.index') }}" class="btn btn-sm btn-outline-danger">View All Spareparts</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Longest Since Maintenance --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <i class="bi bi-clock-history text-secondary me-2"></i>Devices — Longest Since Last Maintenance
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Asset Code</th><th>Brand / Model</th><th>Location</th><th>Assigned To</th><th>Last Maintenance</th></tr></thead>
                    <tbody>
                    @forelse($oldestMaintained as $device)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $device->asset_code }}</span></td>
                            <td>{{ $device->brand }} {{ $device->model }}</td>
                            <td><small>{{ $device->location ?? '-' }}</small></td>
                            <td><small>{{ $device->assigned_to ?? '-' }}</small></td>
                            <td>
                                @if($device->latestMaintenance)
                                    {{ $device->latestMaintenance->maintenance_date->diffForHumans() }}
                                @else
                                    <span class="badge bg-danger">Never maintained</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">No devices found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
