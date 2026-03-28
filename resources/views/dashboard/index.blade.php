@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    {{-- Total Perangkat --}}
    <div class="col-6 col-md-3">
        <div class="stat-card bg-white shadow-sm">
            <div class="stat-icon bg-indigo-100" style="background:#e0e7ff">
                <i class="bi bi-pc-display text-primary"></i>
            </div>
            <div>
                <div class="stat-value text-primary">{{ $deviceStats['total'] }}</div>
                <div class="stat-label">Total Perangkat</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-white shadow-sm">
            <div class="stat-icon" style="background:#dcfce7">
                <i class="bi bi-check-circle" style="color:#16a34a"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#16a34a">{{ $deviceStats['active'] }}</div>
                <div class="stat-label">Active</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-white shadow-sm">
            <div class="stat-icon" style="background:#fef9c3">
                <i class="bi bi-wrench" style="color:#ca8a04"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#ca8a04">{{ $deviceStats['maintenance'] }}</div>
                <div class="stat-label">Maintenance</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-white shadow-sm">
            <div class="stat-icon" style="background:#dbeafe">
                <i class="bi bi-boxes" style="color:#2563eb"></i>
            </div>
            <div>
                <div class="stat-value" style="color:#2563eb">{{ $totalSpareparts }}</div>
                <div class="stat-label">Jenis Sparepart</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Upcoming Maintenance --}}
    <div class="col-12 col-lg-6">
        <div class="card table-card shadow-sm h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-calendar-event text-warning"></i>
                Maintenance dalam 7 Hari ke Depan
                @if($upcomingMaintenance->count())
                    <span class="badge bg-warning text-dark ms-auto">{{ $upcomingMaintenance->count() }}</span>
                @endif
            </div>
            <div class="card-body p-0">
                @if($upcomingMaintenance->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle fs-3 d-block mb-2"></i>
                        Tidak ada jadwal maintenance mendatang
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead><tr>
                                <th>Perangkat</th><th>Tgl Maintenance</th><th>Teknisi</th>
                            </tr></thead>
                            <tbody>
                            @foreach($upcomingMaintenance as $log)
                                <tr>
                                    <td>
                                        <a href="{{ route('maintenance.byDevice', $log->device) }}" class="text-decoration-none fw-medium">
                                            {{ $log->device->asset_code }}
                                        </a>
                                        <small class="d-block text-muted">{{ $log->device->brand }} {{ $log->device->model }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            {{ $log->next_maintenance->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td><small>{{ $log->technician }}</small></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Low Stock Alert --}}
    <div class="col-12 col-lg-6">
        <div class="card table-card shadow-sm h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle text-danger"></i>
                Sparepart Stok Rendah
                @if($lowStockItems->count())
                    <span class="badge bg-danger ms-auto">{{ $lowStockItems->count() }}</span>
                @endif
            </div>
            <div class="card-body p-0">
                @if($lowStockItems->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-shield-check fs-3 d-block mb-2"></i>
                        Semua stok aman
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead><tr><th>Sparepart</th><th>Stok</th><th>Min</th></tr></thead>
                            <tbody>
                            @foreach($lowStockItems as $sp)
                                <tr class="low-stock-row">
                                    <td>
                                        <span class="fw-medium">{{ $sp->part_name }}</span>
                                        <small class="d-block text-muted">{{ $sp->part_code }}</small>
                                    </td>
                                    <td><span class="badge bg-danger">{{ $sp->stock }}</span></td>
                                    <td><span class="text-muted">{{ $sp->min_stock }}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 5 perangkat maintenance terlama --}}
    <div class="col-12">
        <div class="card table-card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-clock-history"></i>
                5 Perangkat dengan Maintenance Terlama
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr>
                        <th>Asset Code</th><th>Perangkat</th><th>Status</th>
                        <th>Lokasi</th><th>Maintenance Terakhir</th><th>Aksi</th>
                    </tr></thead>
                    <tbody>
                    @foreach($oldestMaintained as $device)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $device->asset_code }}</span></td>
                            <td>
                                <span class="fw-medium">{{ $device->brand }} {{ $device->model }}</span>
                                <small class="d-block text-muted text-capitalize">{{ $device->device_type }}</small>
                            </td>
                            <td>
                                <span class="badge badge-status-{{ $device->status }}">
                                    {{ ucfirst(str_replace('_',' ',$device->status)) }}
                                </span>
                            </td>
                            <td>{{ $device->location ?? '-' }}</td>
                            <td>
                                @if($device->latestMaintenance)
                                    {{ $device->latestMaintenance->maintenance_date->format('d/m/Y') }}
                                @else
                                    <span class="text-danger">Belum pernah</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('maintenance.byDevice', $device) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-list-ul"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
