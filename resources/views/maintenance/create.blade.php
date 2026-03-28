@extends('layouts.app')
@section('title', 'Add Maintenance Log')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('maintenance.index') }}">Maintenance</a></li>
    <li class="breadcrumb-item active">Add Log</li>
@endsection

@section('content')
<div class="card shadow-sm" style="max-width:680px">
    <div class="card-header"><i class="bi bi-tools me-2"></i>Add Maintenance Log</div>
    <div class="card-body">
        <form method="POST" action="{{ route('maintenance.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Device <span class="text-danger">*</span></label>
                    <select name="device_id" class="form-select @error('device_id') is-invalid @enderror" required>
                        <option value="">-- Select Device --</option>
                        @foreach($devices as $dev)
                            <option value="{{ $dev->id }}" @selected(old('device_id', $selectedDevice?->id) == $dev->id)>
                                [{{ $dev->asset_code }}] {{ $dev->brand }} {{ $dev->model }}
                            </option>
                        @endforeach
                    </select>
                    @error('device_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Maintenance Date <span class="text-danger">*</span></label>
                    <input type="date" name="maintenance_date" class="form-control @error('maintenance_date') is-invalid @enderror"
                        value="{{ old('maintenance_date', date('Y-m-d')) }}" required>
                    @error('maintenance_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Maintenance Type <span class="text-danger">*</span></label>
                    <select name="maintenance_type" class="form-select @error('maintenance_type') is-invalid @enderror" required>
                        <option value="">-- Select --</option>
                        <option value="preventive" @selected(old('maintenance_type')=='preventive')>Preventive</option>
                        <option value="corrective"  @selected(old('maintenance_type')=='corrective')>Corrective</option>
                        <option value="upgrade"     @selected(old('maintenance_type')=='upgrade')>Upgrade</option>
                    </select>
                    @error('maintenance_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        rows="3" placeholder="Describe the maintenance work done..." required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Sparepart Used (Optional)</label>
                    <select name="sparepart_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($spareparts as $sp)
                            <option value="{{ $sp->id }}" @selected(old('sparepart_id')==$sp->id)>
                                [{{ $sp->part_code }}] {{ $sp->part_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Technician <span class="text-danger">*</span></label>
                    <input type="text" name="technician" class="form-control @error('technician') is-invalid @enderror"
                        value="{{ old('technician') }}" required>
                    @error('technician')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cost (Rp)</label>
                    <input type="number" name="cost" class="form-control" value="{{ old('cost', 0) }}" min="0" step="0.01">
                </div>
                <div class="col-12">
                    <label class="form-label">Next Maintenance Date</label>
                    <input type="date" name="next_maintenance" class="form-control @error('next_maintenance') is-invalid @enderror"
                        value="{{ old('next_maintenance') }}">
                    @error('next_maintenance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Log</button>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
