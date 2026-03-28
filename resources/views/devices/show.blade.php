@extends('layouts.app')
@section('title', 'Detail Perangkat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Perangkat</a></li>
    <li class="breadcrumb-item active">{{ $device->asset_code }}</li>
@endsection

@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-pc-display me-2"></i>Info Perangkat</span>
                <span class="badge badge-status-{{ $device->status }}">
                    {{ ucfirst(str_replace('_',' ', $device->status)) }}
                </span>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><th style="width:40%">Asset Code</th><td><span class="badge bg-secondary">{{ $device->asset_code }}</span></td></tr>
                    <tr><th>Tipe</th><td class="text-uppercase">{{ $device->device_type }}</td></tr>
                    <tr><th>Merk / Model</th><td>{{ $device->brand }} {{ $device->model }}</td></tr>
                    <tr><th>Serial Number</th><td><small>{{ $device->serial_number }}</small></td></tr>
                    <tr><th>Prosesor</th><td>{{ $device->processor ?? '-' }}</td></tr>
                    <tr><th>RAM</th><td>{{ $device->ram_size ? $device->ram_size . ' GB' : '-' }}</td></tr>
                    <tr><th>Storage</th><td>{{ $device->storage_size ? $device->storage_size . ' GB ' . strtoupper($device->storage_type ?? '') : '-' }}</td></tr>
                    <tr><th>OS</th><td>{{ $device->os ?? '-' }}</td></tr>
                    <tr><th>Lokasi</th><td>{{ $device->location ?? '-' }}</td></tr>
                    <tr><th>Pengguna</th><td>{{ $device->assigned_to ?? '-' }}</td></tr>
                    <tr><th>Tgl Pembelian</th><td>{{ $device->purchase_date?->format('d/m/Y') ?? '-' }}</td></tr>
                    <tr><th>Garansi s/d</th><td>{{ $device->warranty_until?->format('d/m/Y') ?? '-' }}</td></tr>
                    <tr><th>Catatan</th><td>{{ $device->notes ?? '-' }}</td></tr>
                </table>
                <div class="d-flex gap-2 mt-2">
                    <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('maintenance.create', ['device_id' => $device->id]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-tools me-1"></i>Tambah Maintenance
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header">
                <i class="bi bi-clock-history me-2"></i>Riwayat Maintenance
            </div>
            <div class="card-body p-0">
                @if($device->maintenanceLogs->isEmpty())
                    <div class="text-center text-muted py-4">Belum ada riwayat maintenance</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead><tr><th>Tanggal</th><th>Tipe</th><th>Deskripsi</th><th>Teknisi</th><th>Biaya</th></tr></thead>
                            <tbody>
                            @foreach($device->maintenanceLogs as $log)
                                <tr>
                                    <td>{{ $log->maintenance_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge
                                            {{ $log->maintenance_type == 'preventive' ? 'bg-info text-dark' : ($log->maintenance_type == 'corrective' ? 'bg-warning text-dark' : 'bg-success') }}">
                                            {{ ucfirst($log->maintenance_type) }}
                                        </span>
                                    </td>
                                    <td><small>{{ Str::limit($log->description, 50) }}</small></td>
                                    <td><small>{{ $log->technician }}</small></td>
                                    <td><small>{{ $log->cost > 0 ? 'Rp ' . number_format($log->cost, 0, ',', '.') : '-' }}</small></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
