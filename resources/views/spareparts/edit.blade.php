@extends('layouts.app')
@section('title', 'Edit Sparepart')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('spareparts.index') }}">Sparepart</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card shadow-sm" style="max-width:680px">
    <div class="card-header"><i class="bi bi-pencil-square me-2"></i>Edit Sparepart — {{ $sparepart->part_code }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('spareparts.update', $sparepart) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Part Code <span class="text-danger">*</span></label>
                    <input type="text" name="part_code" class="form-control @error('part_code') is-invalid @enderror"
                        value="{{ old('part_code', $sparepart->part_code) }}" required>
                    @error('part_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-7">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="part_category" class="form-select @error('part_category') is-invalid @enderror" required>
                        @foreach(['ram'=>'RAM','ssd'=>'SSD','hdd'=>'HDD','psu'=>'PSU','motherboard'=>'Motherboard','keyboard'=>'Keyboard','mouse'=>'Mouse','cable'=>'Cable','other'=>'Other'] as $val => $label)
                            <option value="{{ $val }}" @selected(old('part_category',$sparepart->part_category)==$val)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('part_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nama Sparepart <span class="text-danger">*</span></label>
                    <input type="text" name="part_name" class="form-control @error('part_name') is-invalid @enderror"
                        value="{{ old('part_name', $sparepart->part_name) }}" required>
                    @error('part_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" class="form-control" value="{{ old('brand', $sparepart->brand) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Spesifikasi</label>
                    <input type="text" name="specification" class="form-control" value="{{ old('specification', $sparepart->specification) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                        value="{{ old('stock', $sparepart->stock) }}" min="0" required>
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Min Stok <span class="text-danger">*</span></label>
                    <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror"
                        value="{{ old('min_stock', $sparepart->min_stock) }}" min="0" required>
                    @error('min_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Harga Satuan (Rp)</label>
                    <input type="number" name="unit_price" class="form-control" value="{{ old('unit_price', $sparepart->unit_price) }}" min="0" step="1000">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Supplier</label>
                    <input type="text" name="supplier" class="form-control" value="{{ old('supplier', $sparepart->supplier) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lokasi Penyimpanan</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $sparepart->location) }}">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Perbarui</button>
                    <a href="{{ route('spareparts.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
