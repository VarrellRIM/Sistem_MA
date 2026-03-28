@extends('layouts.app')
@section('title', 'Edit Device')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Devices</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card shadow-sm" style="max-width:720px">
    <div class="card-header"><i class="bi bi-pencil-square me-2"></i>Edit Device — {{ $device->asset_code }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('devices.update', $device) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Asset Code <span class="text-danger">*</span></label>
                    <input type="text" name="asset_code" class="form-control @error('asset_code') is-invalid @enderror"
                        value="{{ old('asset_code', $device->asset_code) }}" required>
                    @error('asset_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Device Type <span class="text-danger">*</span></label>
                    <select name="device_type" class="form-select @error('device_type') is-invalid @enderror" required>
                        <option value="pc"     @selected(old('device_type',$device->device_type)=='pc')>PC</option>
                        <option value="laptop" @selected(old('device_type',$device->device_type)=='laptop')>Laptop</option>
                        <option value="server" @selected(old('device_type',$device->device_type)=='server')>Server</option>
                    </select>
                    @error('device_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active"      @selected(old('status',$device->status)=='active')>Active</option>
                        <option value="in_use"      @selected(old('status',$device->status)=='in_use')>In Use</option>
                        <option value="maintenance" @selected(old('status',$device->status)=='maintenance')>Maintenance</option>
                        <option value="retired"     @selected(old('status',$device->status)=='retired')>Retired</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Brand <span class="text-danger">*</span></label>
                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
                        value="{{ old('brand', $device->brand) }}" required>
                    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Model <span class="text-danger">*</span></label>
                    <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
                        value="{{ old('model', $device->model) }}" required>
                    @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Serial Number <span class="text-danger">*</span></label>
                    <input type="text" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror"
                        value="{{ old('serial_number', $device->serial_number) }}" required>
                    @error('serial_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Processor</label>
                    <input type="text" name="processor" class="form-control" value="{{ old('processor', $device->processor) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RAM (GB)</label>
                    <input type="number" name="ram_size" class="form-control" value="{{ old('ram_size', $device->ram_size) }}" min="1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Storage (GB)</label>
                    <input type="number" name="storage_size" class="form-control" value="{{ old('storage_size', $device->storage_size) }}" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Storage Type</label>
                    <select name="storage_type" class="form-select">
                        <option value="">-- Select --</option>
                        <option value="ssd"  @selected(old('storage_type',$device->storage_type)=='ssd')>SSD</option>
                        <option value="hdd"  @selected(old('storage_type',$device->storage_type)=='hdd')>HDD</option>
                        <option value="nvme" @selected(old('storage_type',$device->storage_type)=='nvme')>NVMe</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Operating System</label>
                    <input type="text" name="os" class="form-control" value="{{ old('os', $device->os) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Purchase Date</label>
                    <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', $device->purchase_date?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Warranty Until</label>
                    <input type="date" name="warranty_until" class="form-control" value="{{ old('warranty_until', $device->warranty_until?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $device->location) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Assigned To</label>
                    <input type="text" name="assigned_to" class="form-control" value="{{ old('assigned_to', $device->assigned_to) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $device->notes) }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                    <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
