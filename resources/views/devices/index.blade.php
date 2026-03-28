@extends('layouts.app')
@section('title', 'Device List')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Devices</li>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-pc-display me-2"></i>Device List</h5>
    <a href="{{ route('devices.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Add Device
    </a>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Search code, brand, model, S/N..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-2">
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="pc"     @selected(request('type')=='pc')>PC</option>
                    <option value="laptop" @selected(request('type')=='laptop')>Laptop</option>
                    <option value="server" @selected(request('type')=='server')>Server</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="active"      @selected(request('status')=='active')>Active</option>
                    <option value="in_use"      @selected(request('status')=='in_use')>In Use</option>
                    <option value="maintenance" @selected(request('status')=='maintenance')>Maintenance</option>
                    <option value="retired"     @selected(request('status')=='retired')>Retired</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Search</button>
            </div>
            @if(request()->hasAny(['search','type','status']))
                <div class="col-auto"><a href="{{ route('devices.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a></div>
            @endif
        </form>
    </div>
</div>

<div class="card table-card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>Asset Code</th><th>Type</th><th>Brand / Model</th><th>Serial No.</th>
                <th>Specs</th><th>Status</th><th>Location</th><th>Assigned To</th><th class="text-center">Actions</th>
            </tr></thead>
            <tbody>
            @forelse($devices as $device)
                <tr>
                    <td><span class="badge bg-secondary">{{ $device->asset_code }}</span></td>
                    <td><span class="badge bg-light text-dark text-uppercase">{{ $device->device_type }}</span></td>
                    <td>
                        <span class="fw-medium">{{ $device->brand }} {{ $device->model }}</span>
                        @if($device->os)<small class="d-block text-muted">{{ $device->os }}</small>@endif
                    </td>
                    <td><small>{{ $device->serial_number }}</small></td>
                    <td>
                        <small>
                            @if($device->processor){{ $device->processor }}<br>@endif
                            @if($device->ram_size)RAM {{ $device->ram_size }}GB · @endif
                            @if($device->storage_size){{ $device->storage_size }}GB {{ strtoupper($device->storage_type ?? '') }}@endif
                        </small>
                    </td>
                    <td>
                        <span class="badge badge-{{ $device->status }}">
                            {{ ucfirst(str_replace('_', ' ', $device->status)) }}
                        </span>
                    </td>
                    <td><small>{{ $device->location ?? '-' }}</small></td>
                    <td><small>{{ $device->assigned_to ?? '-' }}</small></td>
                    <td class="text-center">
                        <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('devices.destroy', $device) }}" class="d-inline"
                              onsubmit="return confirm('Delete device {{ $device->asset_code }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No devices found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($devices->hasPages())
        <div class="card-footer bg-transparent">{{ $devices->links() }}</div>
    @endif
</div>
@endsection
