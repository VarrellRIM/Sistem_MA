@extends('layouts.app')
@section('title', 'Add Sparepart')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('spareparts.index') }}">Spareparts</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
<div class="card shadow-sm" style="max-width:680px">
    <div class="card-header"><i class="bi bi-plus-circle me-2"></i>Add New Sparepart</div>
    <div class="card-body">
        <form method="POST" action="{{ route('spareparts.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Part Code <span class="text-danger">*</span></label>
                    <input type="text" name="part_code" class="form-control @error('part_code') is-invalid @enderror"
                        value="{{ old('part_code') }}" placeholder="SPR-00001" required>
                    @error('part_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-7">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="part_category" class="form-select @error('part_category') is-invalid @enderror" required>
                        <option value="">-- Select Category --</option>
                        @foreach(['ram'=>'RAM','ssd'=>'SSD','hdd'=>'HDD','psu'=>'PSU','motherboard'=>'Motherboard','keyboard'=>'Keyboard','mouse'=>'Mouse','cable'=>'Cable','other'=>'Other'] as $val => $label)
                            <option value="{{ $val }}" @selected(old('part_category')==$val)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('part_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Part Name <span class="text-danger">*</span></label>
                    <input type="text" name="part_name" class="form-control @error('part_name') is-invalid @enderror"
                        value="{{ old('part_name') }}" placeholder="RAM DDR4 8GB..." required>
                    @error('part_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="Kingston...">
                </div>
                <div class="col-12">
                    <label class="form-label">Specification</label>
                    <input type="text" name="specification" class="form-control" value="{{ old('specification') }}" placeholder="8GB DDR4 3200MHz...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Initial Stock <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                        value="{{ old('stock', 0) }}" min="0" required>
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Minimum Stock <span class="text-danger">*</span></label>
                    <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror"
                        value="{{ old('min_stock', 0) }}" min="0" required>
                    @error('min_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Unit Price (Rp)</label>
                    <input type="number" name="unit_price" class="form-control" value="{{ old('unit_price', 0) }}" min="0" step="0.01">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Supplier</label>
                    <input type="text" name="supplier" class="form-control" value="{{ old('supplier') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Storage Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Shelf A-1, Box 3...">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save</button>
                    <a href="{{ route('spareparts.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
