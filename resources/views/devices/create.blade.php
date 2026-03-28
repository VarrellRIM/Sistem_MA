@extends('layouts.app')
@section('title', 'Tambah Perangkat')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Perangkat</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="card shadow-sm" style="max-width:780px">
    <div class="card-header"><i class="bi bi-plus-circle me-2"></i>Tambah Perangkat Baru</div>
    <div class="card-body">
        <form method="POST" action="{{ route('devices.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Asset Code <span class="text-danger">*</span></label>
                    <input type="text" name="asset_code" class="form-control @error('asset_code') is-invalid @enderror"
                        value="{{ old('asset_code') }}" placeholder="IT-00001" required>
                    @error('asset_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipe Perangkat <span class="text-danger">*</span></label>
                    <select name="device_type" class="form-select @error('device_type') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="pc" @selected(old('device_type')=='pc')>PC</option>
                        <option value="laptop" @selected(old('device_type')=='laptop')>Laptop</option>
                        <option value="server" @selected(old('device_type')=='server')>Server</option>
                    </select>
                    @error('device_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" @selected(old('status','active')=='active')>Active</option>
                        <option value="maintenance" @selected(old('status')=='maintenance')>Maintenance</option>
                        <option value="retired" @selected(old('status')=='retired')>Retired</option>
                        <option value="in_use" @selected(old('status')=='in_use')>In Use</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Merk <span class="text-danger">*</span></label>
                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
                        value="{{ old('brand') }}" placeholder="Dell, HP, Lenovo..." required>
                    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Model <span class="text-danger">*</span></label>
                    <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
                        value="{{ old('model') }}" placeholder="OptiPlex 3080..." required>
                    @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Serial Number <span class="text-danger">*</span></label>
                    <input type="text" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror"
                        value="{{ old('serial_number') }}" required>
                    @error('serial_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prosesor</label>
                    <input type="text" name="processor" class="form-control" value="{{ old('processor') }}" placeholder="Intel Core i5-10400...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RAM (GB)</label>
                    <input type="number" name="ram_size" class="form-control" value="{{ old('ram_size') }}" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Storage (GB)</label>
                    <input type="number" name="storage_size" class="form-control" value="{{ old('storage_size') }}" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipe Storage</label>
                    <select name="storage_type" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="ssd" @selected(old('storage_type')=='ssd')>SSD</option>
                        <option value="hdd" @selected(old('storage_type')=='hdd')>HDD</option>
                        <option value="nvme" @selected(old('storage_type')=='nvme')>NVMe</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sistem Operasi</label>
                    <input type="text" name="os" class="form-control" value="{{ old('os') }}" placeholder="Windows 11 Pro...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Ruang IT, Lantai 2...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Pembelian</label>
                    <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Garansi Sampai</label>
                    <input type="date" name="warranty_until" class="form-control" value="{{ old('warranty_until') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Digunakan Oleh</label>
                    <input type="text" name="assigned_to" class="form-control" value="{{ old('assigned_to') }}" placeholder="Nama karyawan...">
                </div>
                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                    <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
